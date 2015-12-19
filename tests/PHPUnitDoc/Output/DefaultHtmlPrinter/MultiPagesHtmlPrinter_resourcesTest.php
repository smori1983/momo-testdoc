<?php
namespace Momo\TestDoc\PHPUnitDoc\Output\DefaultHtmlPrinter;

class MultiPagesHtmlPrinter_resourcesTest extends HtmlPrinterTestCase
{
    protected function getHtmlPrinter($outputDir)
    {
        return new MultiPagesHtmlPrinter($outputDir);
    }

    protected function simulatePHPUnitRun()
    {
        $suite01 = $this->createPHPUnitTestSuite('Momo\TestDoc\PHPUnitDoc\PHPUnit\DummyTestE01');
        $suite01Test01 = $this->createPHPUnitTest('method01');

        $this->callStartTestSuite($suite01);
        $this->callStartTest($suite01Test01)->callEndTest($suite01Test01);
        $this->callEndTestSuite($suite01);
    }

    public function testJavaScriptFilesShouldExist()
    {
        $this->assertFileExists($this->getHtmlPath('resources/js/jquery-1.11.2.min.js'));
        $this->assertFileExists($this->getHtmlPath('resources/js/htmlPrinter.js'));
    }
}
