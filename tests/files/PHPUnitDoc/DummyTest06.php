<?php
namespace Momo\TestDoc\PHPUnitDoc;

use Momo\TestDoc\PHPUnitDoc\Annotation as Doc;

/**
 * @Doc\Name("Unit Test")
 */
class DummyTest06
{
    /**
     * @Doc\When("The When description.")
     * @Doc\Then("The Then description.")
     * @Doc\Data({ 0, "value1" })
     * @Doc\Data({ 1, "value2" })
     * @Doc\Data({ 2, "result" })
     * @dataProvider method01DataProvider
     */
    public function method01($value1, $value2, $result)
    {
        $this->assertSame($result, $value1 + $value2);
    }

    public function method01DataProvider()
    {
        return array(
            array(10, 9, 19),
        );
    }
}
