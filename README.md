Attributes.php
==============

Attributes is a tiny library that helps you implement easily the Builder pattern with a
fluent interface.


## Installation

```shell
composer require attributes/attributes
```

## Usage

Use `Attr` static methods to automate getters and setters in your entities.

```php
class Person {
    
    protected $data;
    
    public function name ($value = null) {
        return Attr::string($this->data)->handle();
    }
    
    public function age ($value = null) {
        return Attr::string($this->data)->handle();
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
