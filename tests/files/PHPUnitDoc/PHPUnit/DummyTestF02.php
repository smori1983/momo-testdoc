<?php
namespace Momo\TestDoc\PHPUnitDoc\PHPUnit;

use Momo\TestDoc\PHPUnitDoc\Annotation as Doc;

/**
 * @Doc\Name("TestType01")
 */
class DummyTestF02
{
    /**
     * @Doc\When("When")
     * @Doc\Then("Then")
     * @dataProvider method01DataProvider
     */
    public function method01($value)
    {
    }

    public function method01DataProvider()
    {
        return array(
            array('A'),
        );
    }
}
