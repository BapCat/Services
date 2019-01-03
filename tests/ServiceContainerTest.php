<?php

require_once __DIR__ . '/stubs/CatServiceProvider.php';
require_once __DIR__ . '/stubs/DependentOnCatsServiceProvider.php';
require_once __DIR__ . '/stubs/DependentOnBothServiceProvider.php';
require_once __DIR__ . '/stubs/NotAServiceProvider.php';

use BapCat\Phi\Phi;
use BapCat\Services\ServiceContainer;
use BapCat\Services\ServiceDependenciesNotRegisteredException;
use PHPUnit\Framework\TestCase;

class ServiceContainerTest extends TestCase {
  /** @var  ServiceContainer  $container */
  private $container;

  public function setUp(): void {
    parent::setUp();
    $this->container = new ServiceContainer(Phi::instance());
  }

  public function testRegisterAndBootDependentService(): void {
    $this->container->register(DependentOnBothServiceProvider::class);
    $this->assertFalse(DependentOnBothServiceProvider::$registered);

    $this->container->register(DependentOnCatsServiceProvider::class);
    $this->assertFalse(DependentOnCatsServiceProvider::$registered);
    $this->assertFalse(DependentOnBothServiceProvider::$registered);

    $this->container->register(CatServiceProvider::class);
    $this->assertTrue(CatServiceProvider::$registered);
    $this->assertTrue(DependentOnCatsServiceProvider::$registered);
    $this->assertTrue(DependentOnBothServiceProvider::$registered);

    $this->container->boot();

    $this->assertTrue(CatServiceProvider::$booted);
    $this->assertTrue(DependentOnCatsServiceProvider::$booted);
    $this->assertTrue(DependentOnBothServiceProvider::$booted);
  }

  public function testMissingDependencies(): void {
    $this->expectException(ServiceDependenciesNotRegisteredException::class);

    $this->container->register(DependentOnCatsServiceProvider::class);
    $this->container->boot();
  }

  public function testNotAServiceProvider(): void {
    $this->expectException(InvalidArgumentException::class);

    $this->container->register(NotAServiceProvider::class);
  }
}
