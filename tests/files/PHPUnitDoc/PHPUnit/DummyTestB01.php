<?php
namespace Momo\TestDoc\PHPUnitDoc\PHPUnit;

use Momo\TestDoc\PHPUnitDoc\Annotation as Doc;

/**
 * @Doc\Name("Unit Test")
 */
class DummyTestB01
{
    /**
     * @Doc\Name("Name of method01.")
     * @Doc\When("When of method01.")
     * @Doc\Then("Then of method01.")
     * @Doc\Data({ 0, "Base Data" })
     * @Doc\Data({ 1, "Additional Data" })
     * @Doc\Data({ 2, "Result" })
     * @dataProvider method01DataProvider
     */
    public function method01($value1, $value2, $result, $unknown)
    {
        $this->assertSame($result, $value1 + $value2);
    }

    public function method01DataProvider()
    {
        return array(
            array(1, 1, 2, 'foo'),
            array(100, 99, 200, 'bar'),
        );
    }

    /**
     * @Doc\Name("Name of method02.")
     * @Doc\When("When of method02.")
     * @Doc\Then("Then of method02.")
     * @Doc\Data({ 0, "Value" })
     * @Doc\Data({ 1, "Result" })
     * @dataProvider method02DataProvider
     */
    public function method02($value, $result)
    {
    }

    public function method02DataProvider()
    {
        return array(
            array(1, 'foo'),
        );
    }
}
