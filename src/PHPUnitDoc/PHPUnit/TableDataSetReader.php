<?php
namespace Momo\TestDoc\PHPUnitDoc\PHPUnit;

class TableDataSetReader
{
    public function read(\ReflectionClass $targetClass)
    {
        if (!$targetClass->hasMethod('getDataSet')) {
            return null;
        }

        $refMethod = new \ReflectionMethod($targetClass->getName(), 'getDataSet');

        if ($refMethod->getNumberOfParameters() > 0) {
            return null;
        }

        $retValue = $refMethod->invoke($targetClass->newInstance());

        if (!($retValue instanceof \PHPUnit_Extensions_Database_DataSet_IDataSet)) {
            return null;
        }

        return $this->readInternal($retValue);
    }

    private function readInternal(\PHPUnit_Extensions_Database_DataSet_IDataSet $dataSet)
    {
        $result = array();

        foreach ($dataSet->getTableNames() as $tableName) {
            $table = $dataSet->getTable($tableName);

            $result[$tableName] = array(
                'columns' => $table->getTableMetaData()->getColumns(),
                'rows' => $this->prepareTableRows($table),
            );
        }

        return $result;
    }

    private function prepareTableRows(\PHPUnit_Extensions_Database_DataSet_ITable $table)
    {
        $result = array();

        for ($row = 0, $size = $table->getRowCount(); $row < $size; $row++) {
            $result[] = $table->getRow($row);
        }

        return $result;
    }
}
