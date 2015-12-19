<?php
namespace Momo\TestDoc\PHPUnitDoc\Output\DefaultHtmlPrinter\TestResult;

class Group implements AggregatableInterface
{
    private $name = null;

    private $items = array();

    /**
     * @param string $name
     */
    public function __construct($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param Item $item
     */
    public function addItem(Item $item)
    {
        $this->items[$item->getTestNo()] = $item;
    }

    /**
     * @return Item[]
     */
    public function getItems()
    {
        return array_values($this->items);
    }

    public function getTestCount()
    {
        $result = 0;

        foreach ($this->getItems() as $item) {
            $result += $item->getTestCount();
        }

        return $result;
    }

    public function getSuccessCount()
    {
        $result = 0;

        foreach ($this->getItems() as $item) {
            $result += $item->getSuccessCount();
        }

        return $result;
    }

    public function isAllSuccess()
    {
        foreach ($this->getItems() as $item) {
            if (!$item->isAllSuccess()) {
                return false;
            }
        }

        return true;
    }
}
