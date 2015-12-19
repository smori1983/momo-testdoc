<?php
namespace Momo\TestDoc\PHPUnitDoc\PHPUnit;

use Momo\TestDoc\PHPUnitDoc\Annotation as Doc;

/**
 * @Doc\Name("Unit Test")
 */
class DummyTestA03
{
    /**
     * @Doc\When("The When description.")
     * @Doc\Then("The Then description.")
     * @dataProvider method01DataProvider
     */
    public function method01($value1, $value2)
    {
    }

    public function method01DataProvider()
    {
        return array(
            array('foo', 1),
            array('bar', 2),
        );
    }

    /**
     * @Doc\When("The When description.")
     * @Doc\Then("The Then description.")
     */
    public function method02()
    {
    }
}
