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
        $yaml = <<<YAML
user:
    -
        id: 1
        name: "user01"
    -
        id: 2
        name: "user02"
YAML;

        return new YamlDataSet($yaml);
    }

    /**
     * @Doc\When("The When description.")
     * @Doc\Then("The Then description.")
     */
    public function method01()
    {
    }
}
