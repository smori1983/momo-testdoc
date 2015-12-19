<?php
namespace Momo\TestDoc\PHPUnitDoc;

use Momo\TestDoc\PHPUnitDoc\Annotation as Doc;

/**
 * @Doc\Name("Unit Test")
 */
class DummyTest04
{
    /**
     * @Doc\Given("Given 01")
     * @Doc\Given("Given 02")
     * @Doc\When("When 01")
     * @Doc\When("When 02")
     * @Doc\Then("Then 01")
     * @Doc\Then("Then 02")
     */
    public function method01()
    {
    }
}
