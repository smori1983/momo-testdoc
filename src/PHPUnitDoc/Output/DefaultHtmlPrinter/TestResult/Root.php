<?php
namespace Momo\TestDoc\PHPUnitDoc\Output\DefaultHtmlPrinter\TestResult;

class Root implements AggregatableInterface
{
    private $sets = array();

    /**
     * @param Set $set
     * @throw RuntimeException
     */
    public function addSet(Set $set)
    {
        if ($this->hasSet($set->getName())) {
            throw new \RuntimeException(sprintf(
                'TestResult Set already exists: %s',
                $set->getName()
            ));
        }

        $this->sets[$set->getName()] = $set;
    }

    /**
     * @param string $setName
     *
     * @return bool
     */
    public function hasSet($setName)
    {
        return !is_null($this->getSet($setName));
    }

    /**
     * @param string $setName
     *
     * @return Set|null
     */
    public function getSet($setName)
    {
        if (array_key_exists($setName, $this->sets)) {
            return $this->sets[$setName];
        }

        return null;
    }

    /**
     * @return Set[]
     */
    public function getSets()
    {
        return array_values($this->sets);
    }

    public function getTestCount()
    {
        $result = 0;

        foreach ($this->getSets() as $item) {
            $result += $item->getTestCount();
        }

        return $result;
    }

    public function getSuccessCount()
    {
        $result = 0;

        foreach ($this->getSets() as $item) {
            $result += $item->getSuccessCount();
        }

        return $result;
    }

    public function isAllSuccess()
    {
        foreach ($this->getSets() as $item) {
            if (!$item->isAllSuccess()) {
                return false;
            }
        }

        return true;
    }
}
