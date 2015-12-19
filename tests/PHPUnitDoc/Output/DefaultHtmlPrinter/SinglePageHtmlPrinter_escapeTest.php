<?php
namespace Momo\TestDoc\PHPUnitDoc\Output\DefaultHtmlPrinter;

class SinglePageHtmlPrinter_escapeTest extends HtmlPrinterTestCase
{
    protected function getHtmlPrinter($outputDir)
    {
        return new SinglePageHtmlPrinter($outputDir);
    }

    protected function simulatePHPUnitRun()
    {
        $suite01 = $this->createPHPUnitTestSuite('Momo\TestDoc\PHPUnitDoc\Output\DummyTestC01');
        $suite01Test01 = $this->createPHPUnitTest('method01');

        $this->callStartTestSuite($suite01);
        $this->callStartTest($suite01Test01)->callEndTest($suite01Test01);
        $this->callEndTestSuite($suite01);
    }

    public function testTitle()
    {
        $title = $this->filterHtml('index.html', '.test_title')->html();
        $this->assertSame('&lt;UnitTest&gt;', $title);
    }

    public function testGroup()
    {
        $group = $this->filterHtml('index.html', '.test_group_name')->html();
        $this->assertSame('&lt;Group&gt;', $group);
    }

    public function testName()
    {
        $name = $this->filterHtml('index.html', '.test_result_table .name')->html();
        $this->assertSame('&lt;method01&gt;', $name);
    }

    public function testGiven()
    {
        $given = $this->filterHtml('index.html', '.test_result_table .given')->html();
        $this->assertSame('&lt;Given01&gt;<br>'.PHP_EOL.'&lt;Given02&gt;', $given);
    }

    public function testWhen()
    {
        $when = $this->filterHtml('index.html', '.test_result_table .when')->html();
        $this->assertSame('&lt;When01&gt;<br>'.PHP_EOL.'&lt;When02&gt;', $when);
    }

    public function testThen()
    {
        $then = $this->filterHtml('index.html', '.test_result_table .then')->html();
        $this->assertSame('&lt;Then01&gt;<br>'.PHP_EOL.'&lt;Then02&gt;', $then);
    }
}
