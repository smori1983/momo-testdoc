<?php
namespace Momo\TestDoc\PHPUnitDoc\PHPUnit;

use Momo\TestDoc\PHPUnitDoc\Output\OutputInterface;
use Momo\TestDoc\PHPUnitDoc\Reader;
use Momo\TestDoc\PHPUnitDoc\TestDocContainer;

class BasicTestListener extends \PHPUnit_Util_Printer implements \PHPUnit_Framework_TestListener
{
    /**
     * @var OutputInterface
     */
    private $output = null;

    /**
     * @var Reader
     */
    private $reader = null;

    /**
     * @var TableDataSetReader
     */
    private $tableDataSetReader = null;

    /**
     * @var TestDoc[]
     */
    private $testDocs = array();

    private $currentClassName = null;
    private $currentMethodName = null;

    private $currentTestDoc = null;
    private $currentTableData = null;

    public function __construct(OutputInterface $output)
    {
        $this->output = $output;

        $this->reader = new Reader();
        $this->tableDataSetReader = new TableDataSetReader();
    }

    public function addError(\PHPUnit_Framework_Test $test, \Exception $e, $time)
    {
        $methodName = $test->getName(false);

        if ($this->currentTestDoc->hasMethodDocOf($methodName)) {
            $this->currentTestDoc->getMethodDocOf($methodName)->getReport()->markError();
        }
    }

    public function addFailure(\PHPUnit_Framework_Test $test, \PHPUnit_Framework_AssertionFailedError $e, $time)
    {
        $methodName = $test->getName(false);

        if ($this->currentTestDoc->hasMethodDocOf($methodName)) {
            $this->currentTestDoc->getMethodDocOf($methodName)->getReport()->markFailure();
        }
    }

    public function addIncompleteTest(\PHPUnit_Framework_Test $test, \Exception $e, $time)
    {
        $methodName = $test->getName(false);

        if ($this->currentTestDoc->hasMethodDocOf($methodName)) {
            $this->currentTestDoc->getMethodDocOf($methodName)->getReport()->markIncomplete();
        }
    }

    public function addRiskyTest(\PHPUnit_Framework_Test $test, \Exception $e, $time)
    {
        $methodName = $test->getName(false);

        if ($this->currentTestDoc->hasMethodDocOf($methodName)) {
            $this->currentTestDoc->getMethodDocOf($methodName)->getReport()->markRisky();
        }
    }

    public function addSkippedTest(\PHPUnit_Framework_Test $test, \Exception $e, $time)
    {
        $methodName = $test->getName(false);

        if ($this->currentTestDoc->hasMethodDocOf($methodName)) {
            $this->currentTestDoc->getMethodDocOf($methodName)->getReport()->markSkipped();
        }
    }

    public function startTestSuite(\PHPUnit_Framework_TestSuite $suite)
    {
        $className = $suite->getName();

        if (class_exists($className) && $this->currentClassName !== $className) {
            $this->currentClassName = $className;
            $this->currentMethodName = null;

            $refClass = new \ReflectionClass($className);
            $this->currentTestDoc = $this->reader->read($refClass);
            $this->currentTableData = $this->tableDataSetReader->read($refClass);
        }
    }

    public function endTestSuite(\PHPUnit_Framework_TestSuite $suite)
    {
        $className = $suite->getName();

        if (class_exists($className) && $this->currentClassName === $className) {
            if ($this->currentTestDoc->validate()) {
                $this->testDocs[] = $this->currentTestDoc;
            }
        }
    }

    public function startTest(\PHPUnit_Framework_Test $test)
    {
        $methodName = $test->getName(false);

        if ($this->currentTestDoc->hasMethodDocOf($methodName)) {
            $this->currentTestDoc->getMethodDocOf($methodName)->getReport()->startTest();

            if ($this->currentMethodName !== $methodName) {
                $this->currentMethodName = $methodName;

                $providedData = \PHPUnit_Util_Test::getProvidedData($this->currentClassName, $methodName);

                if (is_array($providedData)) {
                    $this->currentTestDoc->getMethodDocOf($methodName)->getReport()->setProvidedData($providedData);
                }

                if (is_array($this->currentTableData)) {
                    $this->currentTestDoc->getMethodDocOf($methodName)->getReport()->setTableData($this->currentTableData);
                }
            }
        }
    }

    public function endTest(\PHPUnit_Framework_Test $test, $time)
    {
        $methodName = $test->getName(false);

        if ($this->currentTestDoc->hasMethodDocOf($methodName)) {
            $this->currentTestDoc->getMethodDocOf($methodName)->getReport()->endTest();
        }
    }

    public function flush()
    {
        $this->output->execute(new TestDocContainer($this->testDocs));
    }

    /**
     * For test.
     */
    public function getTestDocs()
    {
        return $this->testDocs;
    }
}
