<?php
namespace Momo\TestDoc\PHPUnitDoc;

use Momo\TestDoc\PHPUnitDoc\Annotation\Group;
use Momo\TestDoc\PHPUnitDoc\Annotation\Name;

class ClassDoc
{
    /**
     * @var string
     */
    private $className = null;

    /**
     * @var string
     */
    private $name = null;

    /**
     * @var string
     */
    private $group = null;

    /**
     * @param string $className
     * @param array $values
     */
    public function __construct($className, array $values)
    {
        $this->setClassName($className);
        $this->setValues($values);
    }

    private function setClassName($className)
    {
        $this->className = $className;
    }

    private function setValues(array $values)
    {
        foreach ($values as $value) {
            if ($value instanceof Name) {
                $this->setName($value);
            } elseif ($value instanceof Group) {
                $this->setGroup($value);
            }
        }
    }

    private function setName(Name $name)
    {
        $this->name = $name->getValue();
    }

    private function setGroup(Group $group)
    {
        $this->group = $group->getValue();
    }

    /**
     * @return bool
     */
    public function validate()
    {
        return is_string($this->getName());
    }

    /**
     * @return string
     */
    public function getClassName()
    {
        return $this->className;
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
    public function hasGroup()
    {
        return is_string($this->getGroup());
    }

    /**
     * @return string|null
     */
    public function getGroup()
    {
        return $this->group;
    }
}
