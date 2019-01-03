<?php declare(strict_types=1); namespace BapCat\Services;

use BapCat\Phi\Ioc;
use InvalidArgumentException;
use ReflectionClass;

use function count;
use function in_array;
use ReflectionException;
use RuntimeException;

/**
 * A registry for Service Providers
 *
 * @author    Corey Frenette
 * @copyright Copyright (c) 2019, BapCat
 */
class ServiceContainer {
  /** @var  Ioc  $ioc */
  private $ioc;

  /** @var  string[][]  $queue  Array of queued services, waiting for the services they depend on to be registered */
  private $queue = [];

  /** @var  ServiceProvider[]  $services  Array of services */
  private $services = [];

  /**
   * @param  Ioc  $ioc  An IOC container
   */
  public function __construct(Ioc $ioc) {
    $this->ioc = $ioc;
  }

  /**
   * Registers a Service Provider to be loaded when the framework boots
   *
   * If a service provider depends on other services that have not been registered
   * yet, it may be queued, rather than registered.  Once all services it relies on
   * have been registered, it will be registered.
   *
   * @param  string  $serviceClass  The Service Provider to register
   */
  public function register($serviceClass): void {
    try {
      $class = new ReflectionClass($serviceClass);
    } catch(ReflectionException $e) {
      throw new RuntimeException('Service class not found', 0, $e);
    }

    if(!$class->implementsInterface(ServiceProvider::class)) {
      throw new InvalidArgumentException("[$serviceClass] is not a service provider");
    }

    if($class->hasConstant('requires')) {
      $requirements = array_flip($class->getConstant('requires'));

      foreach($this->services as $service_name => $service) {
        if(array_key_exists($service_name, $requirements)) {
          unset($requirements[$service_name]);
        }
      }

      if(count($requirements) !== 0) {
        $this->queue[$serviceClass] = array_flip($requirements);
        return;
      }
    }

    $service = $this->ioc->make($serviceClass);
    $service->register();

    if(!$class->hasConstant('provides')) {
      $this->services[] = $service;
    } else {
      $provides = $class->getConstant('provides');

      $this->services[$provides] = $service;

      foreach($this->queue as $queued_name => &$queued) {
        if(in_array($provides, $queued, true)) {
          unset($this->queue[$queued_name]);
          $this->register($queued_name);
        }
      }
    }
  }

  /**
   * Boot all Service Providers
   *
   * @throws  ServiceDependenciesNotRegisteredException  If any service provider's dependencies have not been registered
   */
  public function boot(): void {
    if(count($this->queue) !== 0) {
      throw new ServiceDependenciesNotRegisteredException($this->queue);
    }

    foreach($this->services as $service) {
      $service->boot();
    }
  }
}
