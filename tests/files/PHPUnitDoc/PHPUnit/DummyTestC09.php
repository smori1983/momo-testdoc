<?php
namespace Momo\TestDoc\PHPUnitDoc\PHPUnit;

class DummyTestC09
{
    public function getDataSet()
    {
        $yaml = <<<YAML
user:
    -
        id: 1
        name: "user01"
        job: "engineer"
    -
        id: 2
        name: "user02"
        age: 99
YAML;

        return new YamlDataSet($yaml);
    }
}
