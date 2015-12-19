<?php
namespace Momo\TestDoc\PHPUnitDoc\PHPUnit;

class DummyTestC08
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
        age: 99
YAML;

        return new YamlDataSet($yaml);
    }
}
