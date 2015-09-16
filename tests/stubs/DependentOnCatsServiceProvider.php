<?php

use BapCat\Services\ServiceProvider;

class DependentOnCatsServiceProvider implements ServiceProvider {
  public static $registered = false;
  public static $booted     = false;
  
  const provides = 'other';
  
  const requires = [
    'cats'
  ];
  
  public function __construct() {
    if(!CatServiceProvider::$registered) {
      throw new Exception('CatServiceProvider was not loaded first');
    }
  }
  
  public function register() {
    self::$registered = true;
  }
  
  public function boot() {
    self::$booted = true;
  }
}
