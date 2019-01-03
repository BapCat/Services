<?php declare(strict_types=1); namespace BapCat\Services;

/**
 * Defines a class that registers a service
 *
 * @author    Corey Frenette
 * @copyright Copyright (c) 2019, BapCat
 */
interface ServiceProvider {
  /**
   * Register the service - register all IOC bindings here
   */
  public function register(): void;

  /**
   * Boot the service - do anything else that requires other services to be registered
   */
  public function boot(): void;
}
