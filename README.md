[![Build Status](https://travis-ci.org/BapCat/Services.svg?branch=1.0.0)](https://travis-ci.org/BapCat/Services)
[![Coverage Status](https://coveralls.io/repos/BapCat/Services/badge.svg?branch=1.0.0)](https://coveralls.io/r/BapCat/Services?branch=1.0.0)
[![License](https://img.shields.io/packagist/l/BapCat/Services.svg)](https://img.shields.io/packagist/l/BapCat/Services.svg)

# Services
This package provides a controlled boot environment for cross-package dependencies.

## Installation

### Composer
[Composer](https://getcomposer.org/) is the recommended method of installation for BapCat packages.

```
$ composer require bapcat/services
```

### GitHub

BapCat packages may be downloaded from [GitHub](https://github.com/BapCat/Services/).

## Features

### Registration
The main use for Services is to register IoC bindings.

```php
<?php namespace BapCat\CoolLogger;

use BapCat\CoolLogger\Logger;

use BapCat\Interfaces\Ioc\Ioc;

class LoggingServiceProvider implements ServiceProvider {
  private $ioc;
  
  public function __construct(Ioc $ioc) {
    $this->ioc = $ioc;
  }
  
  public function register() {
    // Make Logger a singleton
    $this->ioc->singleton(Logger::class, Logger::class);
    
    // Bind the bap.log alias to the Logger singleton
    $this->ioc->bind('bap.log', Logger::class);
  }
}
```
