<?php
namespace Momo\TestDoc\PHPUnitDoc\Annotation;

abstract class AbstractSingleValue
{
    protected $value = null;

    public function __construct(array $values)
    {
        if (!isset($values['value'])) {
            throw new \RuntimeException(sprintf(
                'The value for annotation "%s" cannot be empty.',
                get_class($this)
            ));
        }

        if (!is_string($values['value']) && !is_numeric($values['value'])) {
            throw new \RuntimeException(sprintf(
                'The value for annotation "%s" should be single value, %s given.',
                get_class($this),
                gettype($values['value'])
            ));
        }

        $this->value = $values['value'];
    }

    public function getValue()
    {
        return $this->value;
    }
}
