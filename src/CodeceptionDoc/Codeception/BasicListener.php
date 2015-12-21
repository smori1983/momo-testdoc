<?php
namespace Momo\TestDoc\CodeceptionDoc\Codeception;

use Codeception\Configuration;
use Codeception\Extension;
use Codeception\Events;
use Codeception\Event\StepEvent;
use Codeception\Event\SuiteEvent;
use Codeception\Event\TestEvent;
use Codeception\Event\PrintResultEvent;

class BasicListener extends Extension
{
    public static $events = array(
        Events::MODULE_INIT => 'initModule',
        Events::SUITE_INIT => 'initSuite',
        Events::SUITE_BEFORE => 'beforeSuite',
        Events::SUITE_AFTER => 'afterSuite',
        Events::TEST_START => 'startTest',
        Events::TEST_BEFORE => 'beforeTest',
        Events::STEP_BEFORE => 'beforeStep',
        Events::STEP_AFTER => 'afterStep',
        Events::TEST_END => 'endTest',
        Events::RESULT_PRINT_AFTER => 'afterPrintResult',
    );

    public function initModule(SuiteEvent $e)
    {
    }

    public function initSuite(SuiteEvent $e)
    {
    }

    public function beforeSuite(SuiteEvent $e)
    {
    }

    public function afterSuite(SuiteEvent $e)
    {
    }

    public function startTest(TestEvent $e)
    {
        $test = $e->getTest();
        $testClass = $test->getTestClass();
    }

    public function beforeTest(TestEvent $e)
    {
    }

    public function beforeStep(StepEvent $e)
    {
        $step = $e->getStep();
        $action = $step->getAction();
        $arguments = $step->getArguments();
    }

    public function afterStep(StepEvent $e)
    {
    }

    public function endTest(TestEvent $e)
    {
    }

    public function afterPrintResult(PrintResultEvent $e)
    {
        $outputDir = Configuration::outputDir();
    }
}
