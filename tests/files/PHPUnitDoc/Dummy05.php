<?php
namespace Momo\TestDoc\PHPUnitDoc;

use Momo\TestDoc\PHPUnitDoc\Annotation as Doc;

/**
 * @Doc\Name("Unit Test")
 */
class Dummy05
{
    /**
     * @Doc\Given("Given for method01")
     * @Doc\When("When for method01")
     * @Doc\Then("Then for method01")
     */
    public function method01()
    {
    }

    /**
     * @Doc\Given("Given for method02")
     * @Doc\When("When for method02")
     * @Doc\Then("Then for method02")
     */
    public function method02()
    {
    }
}
