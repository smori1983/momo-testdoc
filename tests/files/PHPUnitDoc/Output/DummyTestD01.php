<?php
namespace Momo\TestDoc\PHPUnitDoc\Output;

use Momo\TestDoc\PHPUnitDoc\Annotation as Doc;

/**
 * @Doc\Name("TestType01")
 * @Doc\Group("Group01")
 */
class DummyTestD01
{
    /**
     * @Doc\When("When")
     * @Doc\Then("Then")
     */
    public function method01()
    {
    }

    /**
     * @Doc\When("When")
     * @Doc\Then("Then")
     */
    public function method02()
    {
    }
}
