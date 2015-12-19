<?php
namespace Momo\TestDoc\PHPUnitDoc\Annotation;

/**
 * @Annotation
 * @Target("METHOD")
 */
class Data
{
    protected $index = null;

    protected $label = null;

    public function __construct(array $values)
    {
        if (!isset($values['value'])
            || !is_array($values['value'])
            || count($values['value']) !== 2
            || !is_int($values['value'][0])
            || !is_string($values['value'][1])
        ) {
            throw new \RuntimeException(sprintf(
                'The value for annotation "%s" should have 2 elements (int, string).',
                get_class($this)
            ));
        }

        $this->index = $values['value'][0];
        $this->label = $values['value'][1];
    }

    public function getIndex()
    {
        return $this->index;
    }

    public function getLabel()
    {
        return $this->label;
    }
}
