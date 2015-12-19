<?php
namespace Momo\TestDoc\PHPUnitDoc\Annotation;

class WhenTest extends \PHPUnit_Framework_TestCase
{
    private $SUT = null;

    /**
     * Test DSL
     */
    private function createSUT($values)
    {
        $this->SUT = new When(array('value' => $values));
    }

    /**
     * @dataProvider dataForGetValue
     */
    public function testGetValue($value)
    {
        $this->createSUT($value);

        $this->assertSame($value, $this->SUT->getValue());
    }

    public function dataForGetValue()
    {
        return array(
            array('foo'),
            array('bar'),
        );
    }

    /**
     * @dataProvider dataForInvalidArguments
     * @expectedException RuntimeException
     */
    public function testInvalidArguments(array $values)
    {
        $this->createSUT($values);
    }

    public function dataForInvalidArguments()
    {
        return array(
            array(array()),
            array(array('foo', 'bar')),
        );
    }
}
