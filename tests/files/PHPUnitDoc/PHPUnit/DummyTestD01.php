<?php
namespace Momo\TestDoc\PHPUnitDoc\PHPUnit;

use Momo\TestDoc\PHPUnitDoc\Annotation as Doc;

/**
 * @Doc\Name("TestType01")
 */
class DummyTestD01
{
    /**
     * @Doc\When("When of method01.")
     * @Doc\Then("Then of method01.")
     */
    public function method01()
    {
    }
}
