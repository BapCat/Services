<?php

use BapCat\Services\ServiceProvider;

class CatServiceProvider implements ServiceProvider {
  public static $registered = false;
  public static $booted     = false;

  protected const provides = 'cats';

  public function register(): void {
    self::$registered = true;
  }

  public function boot(): void {
    self::$booted = true;
  }
}
