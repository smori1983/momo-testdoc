<?php
namespace Momo\TestDoc\PHPUnitDoc\PHPUnit;

use Momo\TestDoc\PHPUnitDoc\Annotation as Doc;

/**
 * @Doc\Name("TestType01")
 * @Doc\Group("Group01")
 */
class DummyTestF01
{
    /**
     * @Doc\When("When of method01.")
     * @Doc\Then("Then of method01.")
     * @dataProvider method01DataProvider
     */
    public function method01($value)
    {
    }

    public function method01DataProvider()
    {
        return array(
            array('a'),
        );
    }
}
