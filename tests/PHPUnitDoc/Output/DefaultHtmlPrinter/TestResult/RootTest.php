<?php
namespace Momo\TestDoc\PHPUnitDoc\Output\DefaultHtmlPrinter\TestResult;

class RootTest extends \PHPUnit_Framework_TestCase
{
    /**
     * 同じ名前のSetを複数回追加すると例外が発生する。
     *
     * @expectedException RuntimeException
     */
    public function testAddSetOfSameNameTwiceShouldThrowException()
    {
        $SUT = new Root();

        $set1 = new Set('set');
        $SUT->addSet($set1);

        $set2 = new Set('set');
        $SUT->addSet($set2);
    }
}
