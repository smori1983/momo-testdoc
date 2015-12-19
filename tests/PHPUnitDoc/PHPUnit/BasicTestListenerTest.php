<?php
namespace Momo\TestDoc\PHPUnitDoc\PHPUnit;

use Momo\TestDoc\PHPUnitDoc\Output\OutputInterface;

class BasicTestListenerTest extends \PHPUnit_Framework_TestCase
{
    private $SUT = null;

    public function createSUT(OutputInterface $output)
    {
        return new BasicTestListener($output);
    }

    public function createPHPUnitTestSuite($name)
    {
        $mock = $this->getMock('PHPUnit_Framework_TestSuite');
        $mock->expects($this->any())
             ->method('getName')
             ->will($this->returnValue($name));

        return $mock;
    }

    public function createPHPUnitTest($name)
    {
        $mock = $this->getMock('PHPUnit_Framework_TestCase');
        $mock->expects($this->any())
             ->method('getName')
             ->will($this->returnValue($name));

        return $mock;
    }

    public function callStartTestSuite(\PHPUnit_Framework_TestSuite $suite)
    {
        $this->SUT->startTestSuite($suite);

        return $this;
    }

    public function callEndTestSuite(\PHPUnit_Framework_TestSuite $suite)
    {
        $this->SUT->endTestSuite($suite);

        return $this;
    }

    public function callStartTest(\PHPUnit_Framework_Test $test)
    {
        $this->SUT->startTest($test);

        return $this;
    }

    public function callEndTest(\PHPUnit_Framework_Test $test)
    {
        $this->SUT->endTest($test, 0.1);

        return $this;
    }

    public function callTestError(\PHPUnit_Framework_Test $test)
    {
        $this->SUT->addError($test, new \Exception(), 0.1);

        return $this;
    }

    public function callTestFailure(\PHPUnit_Framework_Test $test)
    {
        $error = $this->getMock('PHPUnit_Framework_AssertionFailedError');
        $this->SUT->addFailure($test, $error, 0.1);

        return $this;
    }

    public function callTestIncomplete(\PHPUnit_Framework_Test $test)
    {
        $this->SUT->addIncompleteTest($test, new \Exception(), 0.1);

        return $this;
    }

    public function callTestRisky(\PHPUnit_Framework_Test $test)
    {
        $this->SUT->addRiskyTest($test, new \Exception(), 0.1);

        return $this;
    }

    public function callTestSkipped(\PHPUnit_Framework_Test $test)
    {
        $this->SUT->addSkippedTest($test, new \Exception(), 0.1);

        return $this;
    }

    public function createOutputMock()
    {
        $mock = $this->getMockForAbstractClass('Momo\TestDoc\PHPUnitDoc\Output\OutputInterface');
        $mock->expects($this->once())
             ->method('execute')
             ->with($this->isInstanceOf('Momo\TestDoc\PHPUnitDoc\TestDocContainer'));

        return $mock;
    }

    public function setUp()
    {
        $this->SUT = $this->createSUT($this->createOutputMock());
    }

    public function testAllSuccess()
    {
        $suite1 = $this->createPHPUnitTestSuite('Momo\TestDoc\PHPUnitDoc\PHPUnit\DummyTestA01');
        $suite2 = $this->createPHPUnitTestSuite('Momo\TestDoc\PHPUnitDoc\PHPUnit\DummyTestA02');

        $this->callStartTestSuite($suite1)->callEndTestSuite($suite1);
        $this->callStartTestSuite($suite2)->callEndTestSuite($suite2);

        $this->SUT->flush();

        $testDocs = $this->SUT->getTestDocs();
        $this->assertCount(2, $testDocs);

        $this->assertSame('Momo\TestDoc\PHPUnitDoc\PHPUnit\DummyTestA01', $testDocs[0]->getClassDoc()->getClassName());
        $methodDocs = $testDocs[0]->getMethodDocs();
        $this->assertCount(1, $methodDocs);
        $this->assertSame('method01', $methodDocs[0]->getMethodName());
        $this->assertSame(0, $methodDocs[0]->getReport()->getTestCount());

        $this->assertSame('Momo\TestDoc\PHPUnitDoc\PHPUnit\DummyTestA02', $testDocs[1]->getClassDoc()->getClassName());
        $methodDocs = $testDocs[1]->getMethodDocs();
        $this->assertCount(2, $methodDocs);
        $this->assertSame('method01', $methodDocs[0]->getMethodName());
        $this->assertSame(0, $methodDocs[0]->getReport()->getTestCount());
        $this->assertSame('method02', $methodDocs[1]->getMethodName());
        $this->assertSame(0, $methodDocs[1]->getReport()->getTestCount());
    }

    public function testResultHasError()
    {
        $suite = $this->createPHPUnitTestSuite('Momo\TestDoc\PHPUnitDoc\PHPUnit\DummyTestA01');
        $suiteTest01 = $this->createPHPUnitTest('method01');

        $this->callStartTestSuite($suite);
        $this->callStartTest($suiteTest01)->callTestError($suiteTest01)->callEndTest($suiteTest01);
        $this->callEndTestSuite($suite);

        $this->SUT->flush();

        $testDocs = $this->SUT->getTestDocs();
        $this->assertCount(1, $testDocs);

        $methodDocs = $testDocs[0]->getMethodDocs();
        $this->assertCount(1, $methodDocs);
        $this->assertSame('method01', $methodDocs[0]->getMethodName());
        $this->assertSame(1, $methodDocs[0]->getReport()->getTestCount());
        $this->assertSame(0, $methodDocs[0]->getReport()->getSuccessCount());
    }

    public function testResultHasFailure()
    {
        $suite = $this->createPHPUnitTestSuite('Momo\TestDoc\PHPUnitDoc\PHPUnit\DummyTestA01');
        $suiteTest01 = $this->createPHPUnitTest('method01');

        $this->callStartTestSuite($suite);
        $this->callStartTest($suiteTest01)->callTestFailure($suiteTest01)->callEndTest($suiteTest01);
        $this->callEndTestSuite($suite);

        $this->SUT->flush();

        $testDocs = $this->SUT->getTestDocs();
        $this->assertCount(1, $testDocs);

        $methodDocs = $testDocs[0]->getMethodDocs();
        $this->assertCount(1, $methodDocs);
        $this->assertSame('method01', $methodDocs[0]->getMethodName());
        $this->assertSame(1, $methodDocs[0]->getReport()->getTestCount());
        $this->assertSame(0, $methodDocs[0]->getReport()->getSuccessCount());
    }

    public function testResultHasIncomplete()
    {
        $suite = $this->createPHPUnitTestSuite('Momo\TestDoc\PHPUnitDoc\PHPUnit\DummyTestA01');
        $suiteTest01 = $this->createPHPUnitTest('method01');

        $this->callStartTestSuite($suite);
        $this->callStartTest($suiteTest01)->callTestIncomplete($suiteTest01)->callEndTest($suiteTest01);
        $this->callEndTestSuite($suite);

        $this->SUT->flush();

        $testDocs = $this->SUT->getTestDocs();
        $this->assertCount(1, $testDocs);

        $methodDocs = $testDocs[0]->getMethodDocs();
        $this->assertCount(1, $methodDocs);
        $this->assertSame('method01', $methodDocs[0]->getMethodName());
        $this->assertSame(1, $methodDocs[0]->getReport()->getTestCount());
        $this->assertSame(0, $methodDocs[0]->getReport()->getSuccessCount());
    }

    public function testResultHasRisky()
    {
        $suite = $this->createPHPUnitTestSuite('Momo\TestDoc\PHPUnitDoc\PHPUnit\DummyTestA01');
        $suiteTest01 = $this->createPHPUnitTest('method01');

        $this->callStartTestSuite($suite);
        $this->callStartTest($suiteTest01)->callTestRisky($suiteTest01)->callEndTest($suiteTest01);
        $this->callEndTestSuite($suite);

        $this->SUT->flush();

        $testDocs = $this->SUT->getTestDocs();
        $this->assertCount(1, $testDocs);

        $methodDocs = $testDocs[0]->getMethodDocs();
        $this->assertCount(1, $methodDocs);
        $this->assertSame('method01', $methodDocs[0]->getMethodName());
        $this->assertSame(1, $methodDocs[0]->getReport()->getTestCount());
        $this->assertSame(0, $methodDocs[0]->getReport()->getSuccessCount());
    }

    public function testResultHasSkipped()
    {
        $suite = $this->createPHPUnitTestSuite('Momo\TestDoc\PHPUnitDoc\PHPUnit\DummyTestA01');
        $suiteTest01 = $this->createPHPUnitTest('method01');

        $this->callStartTestSuite($suite);
        $this->callStartTest($suiteTest01)->callTestSkipped($suiteTest01)->callEndTest($suiteTest01);
        $this->callEndTestSuite($suite);

        $this->SUT->flush();

        $testDocs = $this->SUT->getTestDocs();
        $this->assertCount(1, $testDocs);

        $methodDocs = $testDocs[0]->getMethodDocs();
        $this->assertCount(1, $methodDocs);
        $this->assertSame('method01', $methodDocs[0]->getMethodName());
        $this->assertSame(1, $methodDocs[0]->getReport()->getTestCount());
        $this->assertSame(0, $methodDocs[0]->getReport()->getSuccessCount());
    }

    public function testWithProvidedData()
    {
        $suite = $this->createPHPUnitTestSuite('Momo\TestDoc\PHPUnitDoc\PHPUnit\DummyTestA03');
        $suite01 = $this->createPHPUnitTestSuite('Momo\TestDoc\PHPUnitDoc\PHPUnit\DummyTestA03::method01');
        $suite01Test01 = $this->createPHPUnitTest('method01');
        $suiteTest02 = $this->createPHPUnitTest('method02');

        $this->callStartTestSuite($suite);
        $this->callStartTestSuite($suite01);
        $this->callStartTest($suite01Test01)->callEndTest($suite01Test01);
        $this->callStartTest($suite01Test01)->callEndTest($suite01Test01);
        $this->callEndTestSuite($suite01);
        $this->callStartTest($suiteTest02)->callEndTest($suiteTest02);
        $this->callEndTestSuite($suite);

        $this->SUT->flush();

        $testDocs = $this->SUT->getTestDocs();
        $this->assertCount(1, $testDocs);

        $methodDocs = $testDocs[0]->getMethodDocs();
        $this->assertCount(2, $methodDocs);

        $method01ProvidedData = array(
            array('foo', 1),
            array('bar', 2),
        );
        $this->assertSame('method01', $methodDocs[0]->getMethodName());
        $this->assertTrue($methodDocs[0]->getReport()->hasProvidedData());
        $this->assertEquals($method01ProvidedData, $methodDocs[0]->getReport()->getProvidedData());
        $this->assertSame('method02', $methodDocs[1]->getMethodName());
        $this->assertFalse($methodDocs[1]->getReport()->hasProvidedData());
    }
}
