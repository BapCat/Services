<?php declare(strict_types=1); namespace BapCat\Services;

use Exception;

/**
 * Thrown if the services a given service depend on have not been registered
 *
 * @author    Corey Frenette
 * @copyright Copyright (c) 2019, BapCat
 */
class ServiceDependenciesNotRegisteredException extends Exception {
  private $services;

  public function __construct(array $services) {
    $this->services = $services;

    $missing = [];

    foreach($services as $service_name => $service) {
      $missing[] = "Service [$service_name] is missing [" . implode(', ', $service) . ']';
    }

    parent::__construct(implode("\n", $missing));
  }

  public function getServices(): array {
    return $this->services;
  }
}
