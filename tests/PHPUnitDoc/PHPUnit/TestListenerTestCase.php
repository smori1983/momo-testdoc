<?php
namespace Momo\TestDoc\PHPUnitDoc\PHPUnit;

use Momo\TestDoc\PHPUnitDoc\Output\OutputInterface;

abstract class TestListenerTestCase extends \PHPUnit_Framework_TestCase
{
    protected $SUT = null;

    protected function createSUT(OutputInterface $output)
    {
        return new BasicTestListener($output);
    }

    protected function createPHPUnitTestSuite($name)
    {
        $mock = $this->getMock('PHPUnit_Framework_TestSuite');
        $mock->expects($this->any())
             ->method('getName')
             ->will($this->returnValue($name));

        return $mock;
    }

    protected function createPHPUnitTest($name)
    {
        $mock = $this->getMock('PHPUnit_Framework_TestCase');
        $mock->expects($this->any())
             ->method('getName')
             ->will($this->returnValue($name));

        return $mock;
    }

    protected function callStartTestSuite(\PHPUnit_Framework_TestSuite $suite)
    {
        $this->SUT->startTestSuite($suite);

        return $this;
    }

    protected function callEndTestSuite(\PHPUnit_Framework_TestSuite $suite)
    {
        $this->SUT->endTestSuite($suite);

        return $this;
    }

    protected function callStartTest(\PHPUnit_Framework_Test $test)
    {
        $this->SUT->startTest($test);

        return $this;
    }

    protected function callEndTest(\PHPUnit_Framework_Test $test)
    {
        $this->SUT->endTest($test, 0.1);

        return $this;
    }

    protected function callTestError(\PHPUnit_Framework_Test $test)
    {
        $this->SUT->addError($test, new \Exception(), 0.1);

        return $this;
    }

    protected function callTestFailure(\PHPUnit_Framework_Test $test)
    {
        $error = $this->getMock('PHPUnit_Framework_AssertionFailedError');
        $this->SUT->addFailure($test, $error, 0.1);

        return $this;
    }

    protected function callTestIncomplete(\PHPUnit_Framework_Test $test)
    {
        $this->SUT->addIncompleteTest($test, new \Exception(), 0.1);

        return $this;
    }

    protected function callTestRisky(\PHPUnit_Framework_Test $test)
    {
        $this->SUT->addRiskyTest($test, new \Exception(), 0.1);

        return $this;
    }

    protected function callTestSkipped(\PHPUnit_Framework_Test $test)
    {
        $this->SUT->addSkippedTest($test, new \Exception(), 0.1);

        return $this;
    }

    protected function createOutputMock()
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
        $this->simulatePHPUnitRun();
        $this->SUT->flush();
    }

    abstract protected function simulatePHPUnitRun();
}
