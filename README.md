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

## API

Attributes are once-time objects that have the duty to get or set a value in some place.

The most basic type of Attribute is the GenericAttribute: it allows you to get or set any value of whatever type.

To instantiate an attribute you can use the `Attr` service locator factory method `generic()`. Then use the mathod 
handle to get or set its value.

```php
class Record {

    protected $data = [];
    
    function name($value=null) {
        Attr::generic($this->data)->handle();
    }
}

$item = new Record();
```

There's quit a bit of magic in the code above. `$item->name()` will return `$item->data['name']`. 
`$item->name('Tommy')` will set `$item->data['name']` to "Tommy" and return `$item` itself, to allow
chaining.

Each of the `Attr` factory methods interally use the `GenericAttribute::make($target, $path, $return)` method.

- `$target` is the storage array where the value should be stored/retrieved. It defaults to `$return->data`
  (note: if you use the default value, the storage has to be a `public` member or `protected`, not `private`)
- `$path` is the key within `$target` where the value will be retrieved/stored. It defaults to the name
  of the calling method (in the example above, it defaults to `name`)
- `$return` is the object that will be returned when a setter is invoked, and defaults to the caller object
  instance (in the example above, it defaults to the `$item` instance)
  
Since we use smart defaults, as long as `$item->data['name']` is the place where you want to store the attribute
value, you can simplify the example above in the following way:

```php
class Record {

    protected $data = [];
    
    function name($value=null) {
        Attr::generic()->handle();
    }
}

$item = new Record();
```

As you see, we don't need to specify the storage, as long as it matches `$data` as the storage, `name` as the key
and `$item` as the returned object.

You can of course specify totally different arguments.

```php
class Record {

    protected $values = [];
    
    function name($value=null) {
        $object = new MyObject();
        Attr::generic($this->values, 'firstName', $object)->handle();
    }
}

$item = new Record();
```

In the following example, '$item->name()' will return `$item->values['firstName']`. `$item->name('something')`
will return `$object`.

### The handle method

`handle()` is a method tha magically sniffs the arguments passed to the invoking function (`name()` in the above
example) and passes them to the attribute.

- in the above example, if you call `$item->name()` the the value of the key `name` will be returned.
- in the above example, if you call `$item->name('Bobby)`, `Bobby` will be set as the value of `name`, and
  `$return` will be returnd to allow chaining.
  
If you need more control, you can pass to the attribute's `handle()` method an array containing the expected
arguments:

```php
class Record {

    protected $data = [];
    
    function name() 
        Attr::generic($this->data, 'firstName')->handle([]);
    }
}

$item = new Record();
```

The above example will always return `$item->data['firstName']`, it doesn't matter if you pass `name()` any
argument or not.

```php
class Record {

    protected $data = [];
    
    function increment($value) 
        $attribute->Attr::generic($this->data, 'count');
        $current = $attribute()->handle([]);
        
        return $attribute->handle([$current + $value]);
    }
}

$item = new Record();
```

In the above example `$item->increment(3)` will increment the counter by 3 and return the current object for chaining.

### `get()` and `set()` methods

Internally, the `handle()` method will invoke attribute's `get()` and `set($value)` methods depending if you pass it
arguments or not.

Let's say we want to simplify the code above and want to disregard chaining, to return the `count` value anytime.

```php
class Record {

    protected $data = [];
    
    function increment($value) 
        $attribute->Attr::generic($this->data, 'count');
        $current = $attribute()->get($value);
        $attribute->set($current + $value);
        
        return $attribute->get(),
    }
}

$item = new Record();
```

While slightly longer, this is actually cleaner and more readable.

```php
$item->increment(3); // will return 3
$item->increment(2); // will return 5
$item->increment(4); // will return 9
```
 
