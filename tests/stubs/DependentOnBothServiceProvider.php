<?php

use BapCat\Services\ServiceProvider;

class DependentOnBothServiceProvider implements ServiceProvider {
  public static $registered = false;
  public static $booted     = false;
  
  const requires = [
    'cats',
    'other'
  ];
  
  public function __construct() {
    if(!CatServiceProvider::$registered) {
      throw new Exception('CatServiceProvider was not loaded first');
    }
    
    if(!DependentOnCatsServiceProvider::$registered) {
      throw new Exception('DependentOnCatsServiceProvider was not loaded first');
    }
  }
  
  public function register() {
    self::$registered = true;
  }
  
  public function boot() {
    self::$booted = true;
  }
}
