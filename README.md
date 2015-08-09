# Mimic

[![Build Status](https://secure.travis-ci.org/keyvanakbary/mimic.svg?branch=master)](http://travis-ci.org/keyvanakbary/mimic)

Dead simple functional library for object prototyping, data hydration and data exposition.

## Installation

``` bash
composer require keyvanakbary/mimic
```

## Usage

```php
namespace Domain;

use mimic as m;

class ComputerScientist {
    private $name;
    private $surname;
    
    public function __construct($name, $surname) {
        $this->name = $name;
        $this->surname = $surname;
    }
    
    public function rocks() {
        return $this->name . ' ' . $this->surname . ' rocks!';
    }
}

assert(m\prototype('Domain\ComputerScientist') instanceof Domain\ComputerScientist);

m\hydrate('Domain\ComputerScientist', array(
    'name' => 'John',
    'surname' => 'McCarthy'
))->rocks(); //John McCarthy rocks!

assert(m\expose(new Domain\ComputerScientist('Grace', 'Hopper')) == array(
    'name' => 'Grace',
    'surname' => 'Hopper'
));
```
