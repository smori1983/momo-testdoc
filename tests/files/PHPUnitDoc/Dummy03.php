<?php
namespace Momo\TestDoc\PHPUnitDoc;

use Momo\TestDoc\PHPUnitDoc\Annotation as Doc;

/**
 * @Doc\Name("Unit Test")
 * @Doc\Group("Group01")
 */
class Dummy03
{
    /**
     * @Doc\Name("name01")
     * @Doc\Given("The Given description.")
     * @Doc\When("The When description.")
     * @Doc\Then("The Then description.")
     */
    public function method01()
    {
    }
}
