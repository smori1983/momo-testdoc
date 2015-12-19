<?php
namespace Momo\TestDoc\PHPUnitDoc\PHPUnit;

use Momo\TestDoc\PHPUnitDoc\Annotation as Doc;

/**
 * @Doc\Name("Unit Test")
 */
class DummyTestB03
{
    public function getDataSet()
    {
        return new \PHPUnit_Extensions_Database_DataSet_YamlDataSet(__DIR__ . '/DummyTestB03.yml');
    }

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
     * @Doc\Data({ 0, "user ID" })
     * @Doc\Data({ 1, "user name" })
     * @dataProvider method02DataProvider
     */
    public function method02()
    {
    }

    public function method02DataProvider()
    {
        return array(
            array(1, 'user01'),
            array(2, 'user02'),
        );
    }
}
