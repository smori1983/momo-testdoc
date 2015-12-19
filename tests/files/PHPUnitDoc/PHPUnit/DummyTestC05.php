<?php
namespace Momo\TestDoc\PHPUnitDoc\PHPUnit;

class DummyTestC05
{
    public function getDataSet()
    {
        $yaml = <<<YAML
user:
admin:
YAML;

        return new YamlDataSet($yaml);
    }
}
