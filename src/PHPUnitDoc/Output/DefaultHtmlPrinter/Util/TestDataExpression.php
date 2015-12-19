<?php
namespace Momo\TestDoc\PHPUnitDoc\Output\DefaultHtmlPrinter\Util;

class TestDataExpression
{
    public function get($value)
    {
        return $this->getInternal($value);
    }

    private function getInternal($value, $arrayRecursive = false)
    {
        if (is_null($value)) {
            return $this->getNull();
        }

        if (is_bool($value)) {
            return $this->getBool($value);
        }

        if (is_object($value)) {
            return $this->getObject();
        }

        if (is_string($value)) {
            return $this->getString($value);
        }

        if (is_numeric($value)) {
            return $this->getNumeric($value);
        }

        if (is_array($value)) {
            return $this->getArray($value, $arrayRecursive);
        }

        return $value;
    }

    private function getNull()
    {
        return '[NULL]';
    }

    private function getBool($value)
    {
        return $value ? '[TRUE]' : '[FALSE]';
    }

    private function getObject()
    {
        return '[OBJECT]';
    }

    private function getString($value)
    {
        return $value;
    }

    private function getNumeric($value)
    {
        return sprintf('%s', $value);
    }

    private function getArray($value, $recursive)
    {
        if ($recursive) {
            return '[ARRAY]';
        }

        $array = array();

        foreach ($value as $index => $element) {
            $array[] = sprintf(
                '%s => %s',
                $this->getInternal($index, true),
                $this->getInternal($element, true)
            );
        }

        return sprintf('[ARRAY] (%s)', implode($array, ', '));
    }
}
