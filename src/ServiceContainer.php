<?php namespace BapCat\Services;

use BapCat\Interfaces\Ioc\Ioc;

use InvalidArgumentException;
use ReflectionClass;

/**
 * A registry for Service Providers
 * 
 * @author    Corey Frenette
 * @copyright Copyright (c) 2015, BapCat
 */
class ServiceContainer {
  /**
   * IOC container
   * 
   * @var  Ioc
   */
  private $ioc;
  
  /**
   * Array of queued services, waiting for the
   * services they depend on to be registered
   * 
   * @var  array<string>
   */
  private $queue = [];
  
  /**
   * Array of services
   * 
   * @var  array<ServiceProvider>
   */
  private $services = [];
  
  /**
   * Constructor
   * 
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
   * @param  class<ServiceProvider>  $service  The Service Provider to register
   */
  public function register($class_name) {
    $class = new ReflectionClass($class_name);
    
    if(!$class->implementsInterface(ServiceProvider::class)) {
      throw new InvalidArgumentException("[$class_name] is not a service provider");
    }
    
    if($class->hasConstant('requires')) {
      $requirements = array_flip($class->getConstant('requires'));
      
      foreach($this->services as $service_name => $service) {
        if(array_key_exists($service_name, $requirements)) {
          unset($requirements[$service_name]);
        }
      }
      
      if(count($requirements) !== 0) {
        $this->queue[$class_name] = array_flip($requirements);
        return;
      }
    }
    
    $service = $this->ioc->make($class_name);
    $service->register();
    
    if(!$class->hasConstant('provides')) {
      $this->services[] = $service;
    } else {
      $provides = $class->getConstant('provides');
      
      $this->services[$provides] = $service;
      
      foreach($this->queue as $queued_name => &$queued) {
        if(in_array($provides, $queued)) {
          unset($this->queue[$queued_name]);
          $this->register($queued_name);
        }
      }
    }
  }
  
  /**
   * Boot all Service Providers
   * 
   * @throws  Exception  If any service provider's dependencies have not been registered
   */
  public function boot() {
    if(count($this->queue) !== 0) {
      throw new ServiceDependenciesNotRegisteredException($this->queue);
    }
    
    foreach($this->services as $service) {
      $service->boot();
    }
  }
}
