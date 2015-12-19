<?php
namespace Momo\TestDoc\PHPUnitDoc\PHPUnit;

use Momo\TestDoc\PHPUnitDoc\Annotation as Doc;

/**
 * @Doc\Name("Unit Test")
 */
class DummyTestA04
{
    public function getDataSet()
    {
        return new \PHPUnit_Extensions_Database_DataSet_YamlDataSet(__DIR__ . '/DummyTestA04.yml');
    }

    /**
     * @Doc\When("The When description.")
     * @Doc\Then("The Then description.")
     */
    public function method01()
    {
    }
}
