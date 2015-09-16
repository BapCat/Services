<?php

use BapCat\Services\ServiceProvider;

class CatServiceProvider implements ServiceProvider {
  public static $registered = false;
  public static $booted     = false;
  
  const provides = 'cats';
  
  public function register() {
    self::$registered = true;
  }
  
  public function boot() {
    self::$booted = true;
  }
}
