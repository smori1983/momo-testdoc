<?php
namespace Momo\TestDoc\PHPUnitDoc\PHPUnit;

use Momo\TestDoc\PHPUnitDoc\Annotation as Doc;

/**
 * @Doc\Name("TestType02")
 */
class DummyTestD02
{
    /**
     * @Doc\When("When of method01.")
     * @Doc\Then("Then of method01.")
     */
    public function method01()
    {
    }
}
