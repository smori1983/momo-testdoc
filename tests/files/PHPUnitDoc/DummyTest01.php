<?php
namespace Momo\TestDoc\PHPUnitDoc;

/**
 * This is a dummy class.
 *
 * @requires PHP 5.3.3
 * @runTestsInSeparateProcesses
 *
 * @author anonymous
 * @backupGlobals disabled
 * @backupStaticAttributes disabled
 * @coversDefaultClass Some\Name\Space
 * @group someGroup
 */
class DummyTest01
{
    /**
     * @beforeClass
     */
    public static function methodBeforeClass()
    {
    }

    /**
     * @afterClass
     */
    public static function methodAfterClass()
    {
    }

    /**
     * @before
     */
    public function methodBefore()
    {
    }

    /**
     * @after
     */
    public function methodAfter()
    {
    }

    /**
     * This is a dummy method.
     *
     * @codeCoverageIgnore
     */
    public function method01()
    {
    }

    /**
     * @covers Foo::bar
     */
    public function method02()
    {
        // @codeCoverateIgnoreStart
        $value = 1;
        // @codeCoverateIgnoreEnd
    }

    /**
     * @coversNothing
     */
    public function method03()
    {
    }

    /**
     * @dataProvider method04DataProvider
     */
    public function method04($value)
    {
    }

    public function method04DataProvider()
    {
        return array(
            array(null),
        );
    }

    public function method05()
    {
        return array();
    }

    /**
     * @depends method05
     */
    public function method06(array $values)
    {
    }

    /**
     * @expectedException Exception
     * @expectedExceptionMessage message
     * @expectedExceptionCode 99
     */
    public function method07()
    {
        throw new \Exception('message', 99);
    }

    /**
     * @expectedExceptionMessageRegExp /^message/
     */
    public function method08()
    {
        throw new \Exception('message');
    }

    /**
     * @large
     */
    public function method09()
    {
    }

    /**
     * @medium
     */
    public function method10()
    {
    }

    /**
     * @small
     */
    public function method11()
    {
    }

    /**
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function method12()
    {
    }

    /**
     * @test
     * @testdox hogehoge
     */
    public function method13()
    {
    }

    /**
     * @ticket 1234
     */
    public function method14()
    {
    }

    /**
     * @uses Foo
     */
    public function method15()
    {
    }
}
