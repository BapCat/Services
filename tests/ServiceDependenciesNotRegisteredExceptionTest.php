<?php

use BapCat\Services\ServiceDependenciesNotRegisteredException;
use PHPUnit\Framework\TestCase;

class ServiceDependenciesNotRegisteredExceptionTest extends TestCase {
  /** @var  ServiceDependenciesNotRegisteredException  $exception */
  private $exception;

  /** @var  string[][]  $services */
  private $services = [
    'test' => [
      'test' => 'test'
    ]
  ];

  public function setUp() {
    $this->exception = new ServiceDependenciesNotRegisteredException($this->services);
  }

  public function testAccessors(): void {
    $this->assertSame($this->services, $this->exception->getServices());
  }
}
