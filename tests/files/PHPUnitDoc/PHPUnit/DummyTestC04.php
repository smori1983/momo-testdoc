<?php
namespace Momo\TestDoc\PHPUnitDoc\PHPUnit;

class DummyTestC04
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
}
