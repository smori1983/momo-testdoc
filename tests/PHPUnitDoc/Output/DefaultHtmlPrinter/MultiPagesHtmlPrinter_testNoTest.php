<?php
namespace Momo\TestDoc\PHPUnitDoc\Output\DefaultHtmlPrinter;

class MultiPagesHtmlPrinter_testNoTest extends HtmlPrinterTestCase
{
    protected function getHtmlPrinter($outputDir)
    {
        return new MultiPagesHtmlPrinter($outputDir);
    }

    protected function simulatePHPUnitRun()
    {
        $suite01 = $this->createPHPUnitTestSuite('Momo\TestDoc\PHPUnitDoc\Output\DummyTestA01');
        $suite01Test01 = $this->createPHPUnitTest('method01');
        $suite01Test02 = $this->createPHPUnitTest('method02');
        $suite01Test03 = $this->createPHPUnitTest('method03');

        $this->callStartTestSuite($suite01);
        $this->callStartTest($suite01Test01)->callEndTest($suite01Test01);
        $this->callStartTest($suite01Test02)->callEndTest($suite01Test02);
        $this->callStartTest($suite01Test03)->callEndTest($suite01Test03);
        $this->callEndTestSuite($suite01);

        $suite02 = $this->createPHPUnitTestSuite('Momo\TestDoc\PHPUnitDoc\Output\DummyTestA02');
        $suite02Test01 = $this->createPHPUnitTest('method01');
        $suite02Test02 = $this->createPHPUnitTest('method02');
        $suite02Test03 = $this->createPHPUnitTest('method03');

        $this->callStartTestSuite($suite02);
        $this->callStartTest($suite02Test01)->callEndTest($suite02Test01);
        $this->callStartTest($suite02Test02)->callEndTest($suite02Test02);
        $this->callStartTest($suite02Test03)->callEndTest($suite02Test03);
        $this->callEndTestSuite($suite02);
    }

    public function test()
    {
        $testGroups = $this->filterHtml('1.html', '.test_group_block');
        $this->assertCount(2, $testGroups);

        $group1Items = $testGroups->eq(0)->filter('.item');
        $this->assertCount(3, $group1Items);

        $this->assertSame('1', $group1Items->eq(0)->filter('.no')->text());
        $this->assertSame('2', $group1Items->eq(1)->filter('.no')->text());
        $this->assertSame('3', $group1Items->eq(2)->filter('.no')->text());

        $group2Items = $testGroups->eq(1)->filter('.item');
        $this->assertCount(3, $group2Items);

        $this->assertSame('4', $group2Items->eq(0)->filter('.no')->text());
        $this->assertSame('5', $group2Items->eq(1)->filter('.no')->text());
        $this->assertSame('6', $group2Items->eq(2)->filter('.no')->text());
    }
}
