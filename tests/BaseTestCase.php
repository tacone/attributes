<?php

namespace Attributes\Test;

use Attributes\Types\StringAttribute;
use PHPUnit\Framework\TestCase;

class BaseTestCase extends TestCase
{

    public function __construct($name = null, array $data = array(), $dataName = '')
    {
        // TODO: find a more elegant way
        require_once (__DIR__.'/../vendor/phpunit/phpunit/src/Framework/Assert/Functions.php');

        error_reporting(-1);
        parent::__construct($name, $data, $dataName);
    }


}
