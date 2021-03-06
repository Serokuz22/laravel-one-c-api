<?php
namespace Serokuz\OneCApi\Tests;
include_once 'CreatesApplication.php';

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class Test extends BaseTestCase
{
    use CreatesApplication;
}
