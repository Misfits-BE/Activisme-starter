<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

/**
 * Class TestCase
 * -----
 * Class for creating the base class in the testing system. 
 * 
 * @author      Tim Joosten <tim@activisme.be>
 * @copyright   Tim Joosten <MIT license>
 * @package     Tests 
 */
abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
}
