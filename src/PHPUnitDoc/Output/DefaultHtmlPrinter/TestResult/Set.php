<?php
namespace Momo\TestDoc\PHPUnitDoc\Output\DefaultHtmlPrinter\TestResult;

class Set implements AggregatableInterface
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
     * @param Group $group
     * @throw RuntimeException
     */
    public function addGroup(Group $group)
    {
        if ($this->hasGroup($group->getName())) {
            throw new \RuntimeException(sprintf(
                'TestResult Group already exists: %s',
                $group->getName()
            ));
        }

        $this->items[$group->getName()] = $group;
    }

    /**
     * @param string $groupName
     *
     * @return bool
     */
    public function hasGroup($groupName)
    {
        return !is_null($this->getGroup($groupName));
    }

    /**
     * @param string $groupName
     *
     * @return Group|null
     */
    public function getGroup($groupName)
    {
        if (array_key_exists($groupName, $this->items)) {
            return $this->items[$groupName];
        }

        return null;
    }

    /**
     * @return Group[]
     */
    public function getGroups()
    {
        return array_values($this->items);
    }

    public function getTestCount()
    {
        $result = 0;

        foreach ($this->getGroups() as $item) {
            $result += $item->getTestCount();
        }

        return $result;
    }

    public function getSuccessCount()
    {
        $result = 0;

        foreach ($this->getGroups() as $item) {
            $result += $item->getSuccessCount();
        }

        return $result;
    }

    public function isAllSuccess()
    {
        foreach ($this->getGroups() as $item) {
            if (!$item->isAllSuccess()) {
                return false;
            }
        }

        return true;
    }
}
