<?php
namespace Momo\TestDoc\PHPUnitDoc\Output\DefaultHtmlPrinter\TestResult;

use Momo\TestDoc\PHPUnitDoc\ClassDoc;
use Momo\TestDoc\PHPUnitDoc\MethodDoc;

class Item implements AggregatableInterface
{
    private $testNo = null;

    private $classDoc = null;

    private $methodDoc = null;

    /**
     * @param int $testNo
     * @param ClassDoc $classDoc
     * @param MethodDoc $methodDoc
     */
    public function __construct($testNo, ClassDoc $classDoc, MethodDoc $methodDoc)
    {
        $this->testNo = $testNo;
        $this->classDoc = $classDoc;
        $this->methodDoc = $methodDoc;
    }

    /**
     * @return ClassDoc
     */
    public function getClassDoc()
    {
        return $this->classDoc;
    }

    /**
     * @return MethodDoc
     */
    public function getMethodDoc()
    {
        return $this->methodDoc;
    }

    /**
     * @return int
     */
    public function getTestNo()
    {
        return $this->testNo;
    }

    /**
     * @return string
     */
    public function getName()
    {
        if ($this->getMethodDoc()->hasName()) {
            return $this->getMethodDoc()->getName();
        } else {
            return '';
        }
    }

    /**
     * @return string[]
     */
    public function getGiven()
    {
        return $this->getMethodDoc()->getGiven();
    }

    /**
     * @return string[]
     */
    public function getWhen()
    {
        return $this->getMethodDoc()->getWhen();
    }

    /**
     * @return string[]
     */
    public function getThen()
    {
        return $this->getMethodDoc()->getThen();
    }

    /**
     * @return string
     */
    public function getSourceExpression()
    {
        return sprintf(
            '%s::%s',
            $this->getClassDoc()->getClassName(),
            $this->getMethodDoc()->getMethodName()
        );
    }

    public function getTestCount()
    {
        return $this->methodDoc->getReport()->getTestCount();
    }

    public function getSuccessCount()
    {
        return $this->methodDoc->getReport()->getSuccessCount();
    }

    public function isAllSuccess()
    {
        return $this->methodDoc->getReport()->isAllSuccess();
    }

    public function hasTestData()
    {
        $report = $this->methodDoc->getReport();

        return $report->hasProvidedData() || $report->hasTableData();
    }
}
