<?php

/*
 * This file is part of the Silex framework.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Silex\Tests\Application;

use Silex\Application;
use Silex\Provider\ValidatorServiceProvider;

/**
 * ValidatorTrait test cases.
 *
 * @author Ludovic Fleury <ludo.fleur@gmail.com>
 */
class ValidatorTraitTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        if (version_compare(phpversion(), '5.4.0', '<')) {
            $this->markTestSkipped('PHP 5.4 is required for this test');
        }

        if (!is_dir(__DIR__.'/../../../../vendor/symfony/validator')) {
            $this->markTestSkipped('Validator dependency was not installed.');
        }
    }

    public function testValidate()
    {
        $stub = $this->getMock('TestClass');
        $stub::staticExpects($this->any())
             ->method('loadValidatorMetadata');

        $this->assertInstanceOf('Symfony\Component\Validator\ConstraintViolationList', $this->createApplication()->validate($stub));
    }

    public function testValidateValue()
    {
        $this->assertInstanceOf('Symfony\Component\Validator\ConstraintViolationList', $this->createApplication()->validateValue('value', new \Symfony\Component\Validator\Tests\Fixtures\ConstraintA()));
    }

    public function createApplication()
    {
        $app = new ValidatorApplication();
        $app->register(new ValidatorServiceProvider());

        return $app;
    }
}
