<?php
namespace Momo\TestDoc\PHPUnitDoc;

use Momo\TestDoc\PHPUnitDoc\Annotation\Name;
use Momo\TestDoc\PHPUnitDoc\Annotation\Given;
use Momo\TestDoc\PHPUnitDoc\Annotation\When;
use Momo\TestDoc\PHPUnitDoc\Annotation\Then;
use Momo\TestDoc\PHPUnitDoc\Annotation\Data;
use Momo\TestDoc\PHPUnitDoc\PHPUnit\TestReport;

class MethodDoc
{
    /**
     * @var string
     */
    private $methodName = null;

    /**
     * @var string
     */
    private $name = null;

    /**
     * @var string[]
     */
    private $given = array();

    /**
     * @var string[]
     */
    private $when = array();

    /**
     * @var string[]
     */
    private $then = array();

    /**
     * @var string[]
     */
    private $dataLabel = array();

    /**
     * @var TestReport
     */
    private $report = null;

    /**
     * @param string $methodName
     * @param array $values
     */
    public function __construct($methodName, array $values)
    {
        $this->setMethodName($methodName);
        $this->setValues($values);

        $this->report = new TestReport();
    }

    private function setMethodName($methodName)
    {
        $this->methodName = $methodName;
    }

    private function setValues(array $values)
    {
        foreach ($values as $value) {
            if ($value instanceof Name) {
                $this->setName($value);
            } elseif ($value instanceof Given) {
                $this->addGiven($value);
            } elseif ($value instanceof When) {
                $this->addWhen($value);
            } elseif ($value instanceof Then) {
                $this->addThen($value);
            } elseif ($value instanceof Data) {
                $this->addData($value);
            }
        }
    }

    private function setName(Name $name)
    {
        $this->name = $name->getValue();
    }

    private function addGiven(Given $given)
    {
        $this->given[] = $given->getValue();
    }

    private function addWhen(When $when)
    {
        $this->when[] = $when->getValue();
    }

    private function addThen(Then $then)
    {
        $this->then[] = $then->getValue();
    }

    private function addData(Data $data)
    {
        if ($data->getIndex() >= 0) {
            $this->dataLabel[$data->getIndex()] = $data->getLabel();
        }
    }

    /**
     * @return bool
     */
    public function validate()
    {
        return count($this->getWhen()) > 0
            && count($this->getThen()) > 0;
    }

    /**
     * @return string
     */
    public function getMethodName()
    {
        return $this->methodName;
    }

    /**
     * @return bool
     */
    public function hasName()
    {
        return is_string($this->getName());
    }

    /**
     * @return string|null
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return bool
     */
    public function hasGiven()
    {
        return count($this->getGiven()) > 0;
    }

    /**
     * @return string[]
     */
    public function getGiven()
    {
        return $this->given;
    }

    /**
     * @return string[]
     */
    public function getWhen()
    {
        return $this->when;
    }

    /**
     * @return string[]
     */
    public function getThen()
    {
        return $this->then;
    }

    /**
     * @return bool
     */
    public function hasDataLabel()
    {
        return count($this->dataLabel) > 0;
    }

    /**
     * @return string[]
     */
    public function getDataLabel()
    {
        return $this->dataLabel;
    }

    /**
     * @return TestReport
     */
    public function getReport()
    {
        return $this->report;
    }
}
