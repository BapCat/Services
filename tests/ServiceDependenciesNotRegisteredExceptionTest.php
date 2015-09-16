<?php

use BapCat\Services\ServiceDependenciesNotRegisteredException;

class ServiceDependenciesNotRegisteredExceptionTest extends PHPUnit_Framework_TestCase {
  private $exception;
  private $services = [
    'test' => [
      'test' => 'test'
    ]
  ];
  
  public function setUp() {
    $this->exception = new ServiceDependenciesNotRegisteredException($this->services);
  }
  
  public function testAccessors() {
    $this->assertSame($this->services, $this->exception->getServices());
  }
}
