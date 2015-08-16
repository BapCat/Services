<?php namespace BapCat\Services;

use BapCat\Interfaces\Services\ServiceProvider;

class ServiceContainer {
  private $providers = [];
  
  public function register(ServiceProvider $provider) {
    $this->providers[] = $provider;
  }
  
  public function boot() {
    foreach($this->providers as $provider) {
      $provider->register();
    }
  }
}
