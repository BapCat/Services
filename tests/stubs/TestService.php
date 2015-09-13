<?php

use BapCat\Interfaces\Services\ServiceProvider;

class TestService implements ServiceProvider {
  public $registered = false;
  
  public function register() {
    $registered = true;
  }
}
