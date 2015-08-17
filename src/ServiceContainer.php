<?php namespace BapCat\Services;

use BapCat\Interfaces\Services\ServiceProvider;

/**
 * A registry for Service Providers
 * 
 * @author    Corey Frenette
 * @copyright Copyright (c) 2015, BapCat
 */
class ServiceContainer {
  private $providers = [];
  
  /**
   * Registers a Service Provider to be loaded when the framework boots
   * 
   * @param  ServiceProvider  $provider  The Service Provider to register
   */
  public function register(ServiceProvider $provider) {
    $this->providers[] = $provider;
  }
  
  /**
   * Boot all Service Providers
   */
  public function boot() {
    foreach($this->providers as $provider) {
      $provider->register();
    }
  }
}
