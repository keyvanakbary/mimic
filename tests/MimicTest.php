<?php

namespace mimic;

class MimicTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @expectedException \RuntimeException
     */
    public function shouldThrowExceptionOnNonExistingClass()
    {
        prototype('Non\Existing\Class');
    }

    /**
     * @test
     */
    public function shouldNotCallConstructor()
    {
        $object = prototype('mimic\ExceptionObject');
        $this->assertNotNull($object);
        $this->assertInstanceOf('mimic\ExceptionObject', $object);
    }

    /**
     * @test
     */
    public function shouldHydrateObject()
    {
        $object = hydrate('mimic\Object', array(
            'privateProperty' => 'private',
            'protectedProperty' => 'protected',
            'publicProperty' => 'public'
        ));
        $this->assertEquals('private', $object->privateProperty());
        $this->assertEquals('protected', $object->protectedProperty());
        $this->assertEquals('public', $object->publicProperty());
    }

    /**
     * @test
     */
    public function shouldExposeObjectData()
    {
        $data = expose(new Object('private', 'protected', 'public'));

        $this->assertEquals(array(
            'privateProperty' => 'private',
            'protectedProperty' => 'protected',
            'publicProperty' => 'public'
        ), $data);
    }
}

class Object
{
    private $privateProperty;
    protected $protectedProperty;
    public $publicProperty;

    public function __construct($private, $protected, $public)
    {
        $this->privateProperty = $private;
        $this->protectedProperty = $protected;
        $this->publicProperty = $public;
    }

    public function privateProperty()
    {
        return $this->privateProperty;
    }

    public function protectedProperty()
    {
        return $this->protectedProperty;
    }

    public function publicProperty()
    {
        return $this->publicProperty;
    }
}

class ExceptionObject extends Object
{
    public function __construct()
    {
        throw new \Exception();
    }
}
