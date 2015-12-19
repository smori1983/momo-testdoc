<?php
namespace Momo\TestDoc\PHPUnitDoc\Output\DefaultHtmlPrinter\TestResult;

interface AggregatableInterface
{
    public function getTestCount();

    public function getSuccessCount();

    public function isAllSuccess();
}
