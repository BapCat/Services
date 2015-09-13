<?php namespace BapCat\Services;

use BapCat\Interfaces\Ioc\Ioc;
use BapCat\Interfaces\Services\ServiceProvider;

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
   * Array of services
   * 
   * @var  array<string>
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
   * @param  ServiceProvider  $service  The Service Provider to register
   */
  public function register($service) {
    $this->services[] = $service;
  }
  
  /**
   * Boot all Service Providers
   */
  public function boot() {
    foreach($this->services as $service) {
      $this->ioc->make($service)->register();
    }
  }
}
