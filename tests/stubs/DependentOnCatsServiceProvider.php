<?php

use BapCat\Services\ServiceProvider;

class DependentOnCatsServiceProvider implements ServiceProvider {
  public static $registered = false;
  public static $booted     = false;

  protected const provides = 'other';

  protected const requires = [
    'cats',
  ];

  public function __construct() {
    if(!CatServiceProvider::$registered) {
      throw new Exception('CatServiceProvider was not loaded first');
    }
  }

  public function register(): void {
    self::$registered = true;
  }

  public function boot(): void {
    self::$booted = true;
  }
}
