Attributes.php
==============
[![Build Status](https://travis-ci.org/tacone/attributes.svg)](https://travis-ci.org/tacone/attributes)
[![Coverage Status](https://img.shields.io/coveralls/tacone/attributes.svg)](https://coveralls.io/r/tacone/attributes)

# WORK IN PROGRESS | DON'T USE!

Attributes is a tiny library that helps you implement easily the Builder pattern with a
fluent interface.

## Design

Attributes is meant to decouple accessors/mutators logic from the Entity and its state. 

- State has to be stored in plain arrays, to allow easy cloning
- the State is better be stored in the Entity rather than in each attribute object
- you have the option to store the state wherever you want, not just in the entity
- the less code you write, the better. Attributes encapsulate well tested logic, and the library
  allows you (if you wish) to take advantage of convention over configuration to lessen the chance
  of bugs
- we aim to be IDE friendly. We use magic to make thing easier, but require you to write each Entity method
  so as to have full auto completion. 

## Installation

You will need PHP 7.0 or above.

```shell
composer require tacone/attributes
```

## Usage

Use `Attr` static methods to automate getters and setters in your entities.

```php
class Person {
    
    protected $data;
    
    public function name ($value = null) {
        // you don't need to really pass the argument to handle()
        return Attr::string($this->data)->handle();
    }
    
    public function age ($value = null) {
        // if you wish to pass the arguments manually you have to do so by passing
        // it as an arguments array
        return Attr::string($this->data)->handle(func_get_args());
    }

}

$person = new Person();
$name = $person->name(); // ''

$person->name('John'); 
$name = $person->name(); // 'John'

// you can of course chain setters

$person->name('Bobby')->age(21);
$name = $person->name(); // 'Bobby'
$age = $person->age(); // 21

```
