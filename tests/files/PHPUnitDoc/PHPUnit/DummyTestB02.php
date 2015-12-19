<?php
namespace Momo\TestDoc\PHPUnitDoc\PHPUnit;

use Momo\TestDoc\PHPUnitDoc\Annotation as Doc;

/**
 * @Doc\Name("Unit Test")
 */
class DummyTestB02
{
    /**
     * @Doc\Given("Given of method01.")
     * @Doc\When("When of method01.")
     * @Doc\Then("Then of method01.")
     */
    public function method01()
    {
    }

    /**
     * @Doc\Given("Given of method02.")
     * @Doc\When("When of method02.")
     * @Doc\Then("Then of method02.")
     */
    public function method02()
    {
    }
}
