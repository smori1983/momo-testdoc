<?php
namespace Momo\TestDoc\PHPUnitDoc\Output\DefaultHtmlPrinter;

class MultiPagesHtmlPrinter_indexTest extends HtmlPrinterTestCase
{
    protected function getHtmlPrinter($outputDir)
    {
        return new MultiPagesHtmlPrinter($outputDir);
    }

    protected function simulatePHPUnitRun()
    {
        $suite01 = $this->createPHPUnitTestSuite('Momo\TestDoc\PHPUnitDoc\Output\DummyTestB01');
        $suite01Test01 = $this->createPHPUnitTest('method01');
        $suite01Test02 = $this->createPHPUnitTest('method02');
        $suite01Test03 = $this->createPHPUnitTest('method03');

        $this->callStartTestSuite($suite01);
        $this->callStartTest($suite01Test01)->callEndTest($suite01Test01);
        $this->callStartTest($suite01Test02)->callEndTest($suite01Test02);
        $this->callStartTest($suite01Test03)->callEndTest($suite01Test03);
        $this->callEndTestSuite($suite01);

        $suite02 = $this->createPHPUnitTestSuite('Momo\TestDoc\PHPUnitDoc\Output\DummyTestB02');
        $suite02Test01 = $this->createPHPUnitTest('method01');
        $suite02Test02 = $this->createPHPUnitTest('method02');
        $suite02Test03 = $this->createPHPUnitTest('method03');

        $this->callStartTestSuite($suite02);
        $this->callStartTest($suite02Test01)->callTestFailure($suite02Test01)->callEndTest($suite02Test01);
        $this->callStartTest($suite02Test02)->callEndTest($suite02Test02);
        $this->callStartTest($suite02Test03)->callEndTest($suite02Test03);
        $this->callEndTestSuite($suite02);
    }

    public function testItemCount()
    {
        $items = $this->filterHtml('index.html', '.test_list .item');
        $this->assertCount(2, $items);
    }

    public function testItemName()
    {
        $items = $this->filterHtml('index.html', '.test_list .item');

        $this->assertSame('TestType01', $items->eq(0)->filter('.name')->text());
        $this->assertSame('TestType02', $items->eq(1)->filter('.name')->text());
    }

    public function testItemLink()
    {
        $items = $this->filterHtml('index.html', '.test_list .item');

        $this->assertSame('./1.html', $items->eq(0)->filter('.name a')->attr('href'));
        $this->assertSame('./2.html', $items->eq(1)->filter('.name a')->attr('href'));
    }

    public function testItemResult()
    {
        $items = $this->filterHtml('index.html', '.test_list .item');

        $this->assertSame('item ok', $items->eq(0)->attr('class'));
        $this->assertSame('OK', $items->eq(0)->filter('.result')->text());

        $this->assertSame('item ng', $items->eq(1)->attr('class'));
        $this->assertSame('NG', $items->eq(1)->filter('.result')->text());
    }

    public function testItemStat()
    {
        $items = $this->filterHtml('index.html', '.test_list .item');

        $this->assertSame('3/3', $items->eq(0)->filter('.stat')->text());
        $this->assertSame('2/3', $items->eq(1)->filter('.stat')->text());
    }
}
