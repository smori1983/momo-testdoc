<?php
namespace Momo\TestDoc\PHPUnitDoc;

class ReaderTest extends \PHPUnit_Framework_TestCase
{
    public $SUT = null;

    public function setUp()
    {
        $this->SUT = new Reader();
    }

    /**
     * Test DSL
     *
     * @param string $className
     *
     * @return TestDoc
     */
    public function read($className)
    {
        $refClass = new \ReflectionClass($className);

        return $this->SUT->read($refClass);
    }

    public function testReadDummyTest01()
    {
        $testDoc = $this->read('Momo\TestDoc\PHPUnitDoc\DummyTest01');

        $this->assertFalse($testDoc->validate());
    }

    public function testReadDummyTest02()
    {
        $testDoc = $this->read('Momo\TestDoc\PHPUnitDoc\DummyTest02');

        $this->assertFalse($testDoc->validate());
    }

    public function testReadDummyTest03()
    {
        $testDoc = $this->read('Momo\TestDoc\PHPUnitDoc\DummyTest03');

        $this->assertTrue($testDoc->validate());

        $classDoc = $testDoc->getClassDoc();
        $this->assertTrue($classDoc->validate());
        $this->assertSame('Momo\TestDoc\PHPUnitDoc\DummyTest03', $classDoc->getClassName());
        $this->assertSame('Unit Test', $classDoc->getName());
        $this->assertTrue($classDoc->hasGroup());
        $this->assertSame('Group01', $classDoc->getGroup());

        $this->assertTrue($testDoc->hasMethodDocOf('method01'));
        $methodDoc = $testDoc->getMethodDocOf('method01');
        $this->assertSame('method01', $methodDoc->getMethodName());
        $this->assertTrue($methodDoc->hasName());
        $this->assertSame('name01', $methodDoc->getName());
        $this->assertTrue($methodDoc->hasGiven());
        $this->assertEquals(array('The Given description.'), $methodDoc->getGiven());
        $this->assertEquals(array('The When description.'), $methodDoc->getWhen());
        $this->assertEquals(array('The Then description.'), $methodDoc->getThen());
    }

    public function testReadDummyTest04()
    {
        $testDoc = $this->read('Momo\TestDoc\PHPUnitDoc\DummyTest04');

        $this->assertTrue($testDoc->validate());

        $methodDoc = $testDoc->getMethodDocOf('method01');
        $this->assertEquals(array('Given 01', 'Given 02'), $methodDoc->getGiven());
        $this->assertEquals(array('When 01', 'When 02'), $methodDoc->getWhen());
        $this->assertEquals(array('Then 01', 'Then 02'), $methodDoc->getThen());
    }

    public function testReadDummyTest05()
    {
        $testDoc = $this->read('Momo\TestDoc\PHPUnitDoc\DummyTest05');

        $this->assertTrue($testDoc->validate());

        $methodDocs = $testDoc->getMethodDocs();

        $this->assertSame('method01', $methodDocs[0]->getMethodName());
        $this->assertSame('method02', $methodDocs[1]->getMethodName());
    }

    public function testReadDummyTest06()
    {
        $testDoc = $this->read('Momo\TestDoc\PHPUnitDoc\DummyTest06');

        $this->assertTrue($testDoc->validate());

        $methodDoc = $testDoc->getMethodDocOf('method01');

        $result = array(
            0 => 'value1',
            1 => 'value2',
            2 => 'result',
        );

        $this->assertTrue($methodDoc->hasDataLabel());
        $this->assertEquals($result, $methodDoc->getDataLabel());
    }
}
