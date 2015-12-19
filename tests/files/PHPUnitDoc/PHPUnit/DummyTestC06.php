<?php
namespace Momo\TestDoc\PHPUnitDoc\PHPUnit;

class DummyTestC06
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
point_history:
    -
        id: 1
        user_id: 1
        amount: 10
        created_at: "2015/01/01 12:34:56"
    -
        id: 2
        user_id: 1
        amount: 80
        created_at: "2015/01/10 00:00:00"
    -
        id: 3
        user_id: 2
        amount: 55
        created_at: "2015/02/01 11:22:33"
YAML;

        return new YamlDataSet($yaml);
    }
}
