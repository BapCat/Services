<?php

use BapCat\Services\ServiceContainer;
use BapCat\Interfaces\Services\ServiceProvider;

class ServiceContainerTest extends PHPUnit_Framework_TestCase {
  private $container = null;
  
  public function setUp() {
    $this->container = new ServiceContainer();
    
    $this->service = $this
      ->getMockBuilder(ServiceProvider::class)
      ->getMock()
    ;
    
    $this->service
      ->expects($this->once())
      ->method('register')
      ->willReturn(null)
    ;
  }
  
  public function testRegisterAndBoot() {
    $this->container->register($this->service);
    $this->container->boot();
  }
}
