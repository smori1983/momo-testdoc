<?php
namespace Momo\TestDoc\PHPUnitDoc\PHPUnit;

use Momo\TestDoc\PHPUnitDoc\Annotation as Doc;

/**
 * @Doc\Name("Unit Test")
 */
class DummyTestA01
{
    /**
     * @Doc\When("The When description.")
     * @Doc\Then("The Then description.")
     */
    public function method01()
    {
    }
}
