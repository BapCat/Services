<?php

use BapCat\Services\ServiceDependenciesNotRegisteredException;

class ServiceDependenciesNotRegisteredExceptionTest extends PHPUnit_Framework_TestCase {
  private $exception;
  private $services;
  
  public function setUp() {
    $this->services = [
      'test' => [
        'test' => 'test'
      ]
    ];
    
    $this->exception = new ServiceDependenciesNotRegisteredException($this->services);
  }
  
  public function testAccessors() {
    $this->assertSame($this->services, $this->exception->getServices());
  }
}
