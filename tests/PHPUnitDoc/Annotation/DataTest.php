<?php
namespace Momo\TestDoc\PHPUnitDoc\Annotation;

class DataTest extends \PHPUnit_Framework_TestCase
{
    private $SUT = null;

    /**
     * Test DSL
     */
    public function createSUT($values)
    {
        $this->SUT = new Data(array('value' => $values));
    }

    /**
     * @dataProvider dataForGetValue
     */
    public function testGetValue(array $values, $index, $label)
    {
        $this->createSUT($values);

        $this->assertSame($index, $this->SUT->getIndex());
        $this->assertSame($label, $this->SUT->getLabel());
    }

    public function dataForGetValue()
    {
        return array(
            array(array(0, 'value1'), 0, 'value1'),
            array(array(9, 'foo'), 9, 'foo'),
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
            array(array(0)),
            array(array(0, 'value1', 'foo')),
            array(array('foo', 'bar')),
            array(array(0, 1)),
        );
    }
}
