<?php namespace BapCat\Services;

/**
 * Defines a class that registers a service
 * 
 * @author    Corey Frenette
 * @copyright Copyright (c) 2015, BapCat
 */
interface ServiceProvider {
  /**
   * Register the service - register all IOC bindings here
   */
  public function register();
  
  /**
   * Boot the service - do anything else that requires other services to be registered
   */
  public function boot();
}
