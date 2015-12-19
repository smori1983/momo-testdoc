<?php
namespace Momo\TestDoc\PHPUnitDoc\Output\DefaultHtmlPrinter\TestResult;

class SetTest extends \PHPUnit_Framework_TestCase
{
    /**
     * 同じ名前のGroupを複数回追加すると例外が発生する。
     *
     * @expectedException \RuntimeException
     */
    public function testAddGroupOfSameNameTwiceShouldThrowException()
    {
        $SUT = new Set('set');

        $group1 = new Group('group');
        $SUT->addGroup($group1);

        $group2 = new Group('group');
        $SUT->addGroup($group2);
    }
}
