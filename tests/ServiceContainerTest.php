<?php

require_once __DIR__ . '/stubs/TestService.php';

use BapCat\Phi\Phi;
use BapCat\Services\ServiceContainer;
use BapCat\Interfaces\Services\ServiceProvider;

class ServiceContainerTest extends PHPUnit_Framework_TestCase {
  private $container = null;
  
  public function setUp() {
    $this->container = new ServiceContainer(Phi::instance());
  }
  
  public function testRegisterAndBoot() {
    $this->container->register(TestService::class);
    $this->container->boot();
  }
}
