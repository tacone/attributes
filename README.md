Attributes.php
==============
[![Build Status](https://travis-ci.org/tacone/attributes.svg)](https://travis-ci.org/tacone/attributes)
[![Coverage Status](https://img.shields.io/coveralls/tacone/attributes.svg)](https://coveralls.io/r/tacone/attributes)

# WORK IN PROGRESS | DON'T USE!

Attributes is a tiny library that helps you implement easily the Builder pattern with a
fluent interface.

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
