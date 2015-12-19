<?php
namespace Momo\TestDoc\PHPUnitDoc\Output\DefaultHtmlPrinter;

class SinglePageHtmlPrinterTest extends HtmlPrinterTestCase
{
    protected function getHtmlPrinter($outputDir)
    {
        return new SinglePageHtmlPrinter($outputDir);
    }

    protected function simulatePHPUnitRun()
    {
        $suite01 = $this->createPHPUnitTestSuite('Momo\TestDoc\PHPUnitDoc\PHPUnit\DummyTestB01');
        $suite01Test01 = $this->createPHPUnitTest('method01');
        $suite01Test02 = $this->createPHPUnitTest('method02');

        $this->callStartTestSuite($suite01);
        $this->callStartTest($suite01Test01)->callEndTest($suite01Test01);
        $this->callStartTest($suite01Test01)->callTestFailure($suite01Test01)->callEndTest($suite01Test01);
        $this->callStartTest($suite01Test02)->callEndTest($suite01Test02);
        $this->callEndTestSuite($suite01);

        $suite02 = $this->createPHPUnitTestSuite('Momo\TestDoc\PHPUnitDoc\PHPUnit\DummyTestB02');
        $suite02Test01 = $this->createPHPUnitTest('method01');
        $suite02Test02 = $this->createPHPUnitTest('method02');

        $this->callStartTestSuite($suite02);
        $this->callStartTest($suite02Test01)->callEndTest($suite02Test01);
        $this->callStartTest($suite02Test02)->callEndTest($suite02Test02);
        $this->callEndTestSuite($suite02);

        $suite03 = $this->createPHPUnitTestSuite('Momo\TestDoc\PHPUnitDoc\PHPUnit\DummyTestB03');
        $suite03Test01 = $this->createPHPUnitTest('method01');
        $suite03Test02 = $this->createPHPUnitTest('method02');

        $this->callStartTestSuite($suite03);
        $this->callStartTest($suite03Test01)->callEndTest($suite03Test01);
        $this->callStartTest($suite03Test02)->callEndTest($suite03Test02);
        $this->callStartTest($suite03Test02)->callEndTest($suite03Test02);
        $this->callEndTestSuite($suite03);
    }

    public function testIndexPageTestTitles()
    {
        $titleElements = $this->filterHtml('index.html', '.test_title');

        $this->assertCount(1, $titleElements);
        $this->assertSame('Unit Test', $titleElements->eq(0)->text());
    }

    public function testIndexPageResultListCount()
    {
        $tr = $this->filterHtml('index.html', '.test_result_table .item');

        $this->assertCount(6, $tr);
    }

    public function testB01Method01()
    {
        $item = $this->filterHtml('index.html', '.test_result_table .item')->eq(0);

        $this->assertSame('item ng', $item->attr('class'));
        $this->assertSame('Momo\TestDoc\PHPUnitDoc\PHPUnit\DummyTestB01::method01', $item->attr('test-source'));
        $this->assertSame('1', $item->filter('.no')->text());
        $this->assertSame('', $item->filter('.given')->text());
        $this->assertSame('Name of method01.', $item->filter('.name')->text());
        $this->assertSame('When of method01.', $item->filter('.when')->text());
        $this->assertSame('Then of method01.', $item->filter('.then')->text());
        $this->assertCount(0, $item->filter('.result .ok'));
        $this->assertCount(1, $item->filter('.result .ng'));
        $this->assertSame('NG', $item->filter('.result')->text());
        $this->assertSame('1/2', $item->filter('.stat')->text());
        $this->assertSame('./_testdata/1.html', $item->filter('.testdata a')->attr('href'));
    }

    public function testB01Method01TestDataPage()
    {
        $html = $this->filterHtml('_testdata/1.html', 'body');

        $summaryBlock = $html->filter('.summary_block');
        $this->assertCount(1, $summaryBlock);
        $this->assertSame('1', $summaryBlock->filter('.no')->text());
        $this->assertSame('Unit Test', $summaryBlock->filter('.title')->text());
        $this->assertSame('Uncategorized', $summaryBlock->filter('.group')->text());
        $this->assertSame('Name of method01.', $summaryBlock->filter('.name')->text());
        $this->assertSame('', $summaryBlock->filter('.given')->text());
        $this->assertSame('When of method01.', $summaryBlock->filter('.when')->text());
        $this->assertSame('Then of method01.', $summaryBlock->filter('.then')->text());

        $testDataBlock = $html->filter('.test_data_block');
        $this->assertCount(1, $testDataBlock);
        $tr = $testDataBlock->filter('.test_data tr');
        $this->assertCount(3, $tr);

        $this->assertSame('Base Data', $tr->eq(0)->filter('th')->eq(0)->text());
        $this->assertSame('Additional Data', $tr->eq(0)->filter('th')->eq(1)->text());
        $this->assertSame('Result', $tr->eq(0)->filter('th')->eq(2)->text());
        $this->assertSame('Data[4]', $tr->eq(0)->filter('th')->eq(3)->text());

        $this->assertSame('', $tr->eq(1)->attr('class'));
        $this->assertSame('1', $tr->eq(1)->filter('td')->eq(0)->text());
        $this->assertSame('1', $tr->eq(1)->filter('td')->eq(1)->text());
        $this->assertSame('2', $tr->eq(1)->filter('td')->eq(2)->text());
        $this->assertSame('foo', $tr->eq(1)->filter('td')->eq(3)->text());

        $this->assertSame('ng', $tr->eq(2)->attr('class'));
        $this->assertSame('100', $tr->eq(2)->filter('td')->eq(0)->text());
        $this->assertSame('99', $tr->eq(2)->filter('td')->eq(1)->text());
        $this->assertSame('200', $tr->eq(2)->filter('td')->eq(2)->text());
        $this->assertSame('bar', $tr->eq(2)->filter('td')->eq(3)->text());

        $tableDataBlock = $html->filter('.table_data_block');
        $this->assertCount(0, $tableDataBlock);
    }

    public function testB01Method02()
    {
        $item = $this->filterHtml('index.html', '.test_result_table .item')->eq(1);

        $this->assertSame('item ok', $item->attr('class'));
        $this->assertSame('Momo\TestDoc\PHPUnitDoc\PHPUnit\DummyTestB01::method02', $item->attr('test-source'));
        $this->assertSame('2', $item->filter('.no')->text());
        $this->assertSame('', $item->filter('.given')->text());
        $this->assertSame('Name of method02.', $item->filter('.name')->text());
        $this->assertSame('When of method02.', $item->filter('.when')->text());
        $this->assertSame('Then of method02.', $item->filter('.then')->text());
        $this->assertCount(1, $item->filter('.result .ok'));
        $this->assertCount(0, $item->filter('.result .ng'));
        $this->assertSame('OK', $item->filter('.result')->text());
        $this->assertSame('1/1', $item->filter('.stat')->text());
        $this->assertSame('./_testdata/2.html', $item->filter('.testdata a')->attr('href'));
    }

    public function testB01Method02TestDataPage()
    {
        $this->assertFileExists($this->getHtmlPath('_testdata/2.html'));
        $html = $this->filterHtml('_testdata/2.html', 'body');

        $tr = $html->filter('table.test_data tr');
        $this->assertCount(2, $tr);

        $this->assertSame('Value', $tr->eq(0)->filter('th')->eq(0)->text());
        $this->assertSame('Result', $tr->eq(0)->filter('th')->eq(1)->text());

        $this->assertSame('', $tr->eq(1)->attr('class'));
        $this->assertSame('1', $tr->eq(1)->filter('td')->eq(0)->text());
        $this->assertSame('foo', $tr->eq(1)->filter('td')->eq(1)->text());
    }

    public function testB02Method01()
    {
        $item = $this->filterHtml('index.html', '.test_result_table .item')->eq(2);

        $this->assertSame('item ok', $item->attr('class'));
        $this->assertSame('Momo\TestDoc\PHPUnitDoc\PHPUnit\DummyTestB02::method01', $item->attr('test-source'));
        $this->assertSame('3', $item->filter('.no')->text());
        $this->assertSame('Given of method01.', $item->filter('.given')->text());
        $this->assertSame('When of method01.', $item->filter('.when')->text());
        $this->assertSame('Then of method01.', $item->filter('.then')->text());
        $this->assertCount(1, $item->filter('.result .ok'));
        $this->assertCount(0, $item->filter('.result .ng'));
        $this->assertSame('OK', $item->filter('.result')->text());
        $this->assertSame('1/1', $item->filter('.stat')->text());
        $this->assertSame('', $item->filter('.testdata')->text());
    }

    public function testB02Method02()
    {
        $item = $this->filterHtml('index.html', '.test_result_table .item')->eq(3);

        $this->assertSame('item ok', $item->attr('class'));
        $this->assertSame('Momo\TestDoc\PHPUnitDoc\PHPUnit\DummyTestB02::method02', $item->attr('test-source'));
        $this->assertSame('4', $item->filter('.no')->text());
        $this->assertSame('Given of method02.', $item->filter('.given')->text());
        $this->assertSame('When of method02.', $item->filter('.when')->text());
        $this->assertSame('Then of method02.', $item->filter('.then')->text());
        $this->assertCount(1, $item->filter('.result .ok'));
        $this->assertCount(0, $item->filter('.result .ng'));
        $this->assertSame('OK', $item->filter('.result')->text());
        $this->assertSame('1/1', $item->filter('.stat')->text());
        $this->assertSame('', $item->filter('.testdata')->text());
    }

    public function testB03Method01TestDataPage()
    {
        $this->assertFileExists($this->getHtmlPath('_testdata/5.html'));
        $html = $this->filterHtml('_testdata/5.html', 'body');

        $this->assertCount(0, $html->filter('.test_data_title'));
        $this->assertCount(1, $html->filter('.table_data_title'));

        $tableBlocks = $html->filter('.table_block');
        $this->assertCount(2, $tableBlocks);

        // user
        $userTable = $tableBlocks->eq(0);

        $this->assertSame('user', $userTable->filter('.table_name')->text());

        $this->assertSame('id', $userTable->filter('.columns .column')->eq(0)->text());
        $this->assertSame('name', $userTable->filter('.columns .column')->eq(1)->text());
        $this->assertSame('age', $userTable->filter('.columns .column')->eq(2)->text());

        $this->assertSame('1', $userTable->filter('.rows')->eq(0)->filter('.row')->eq(0)->text());
        $this->assertSame('user01', $userTable->filter('.rows')->eq(0)->filter('.row')->eq(1)->text());
        $this->assertSame('30', $userTable->filter('.rows')->eq(0)->filter('.row')->eq(2)->text());

        $this->assertSame('2', $userTable->filter('.rows')->eq(1)->filter('.row')->eq(0)->text());
        $this->assertSame('user02', $userTable->filter('.rows')->eq(1)->filter('.row')->eq(1)->text());
        $this->assertSame('[NULL]', $userTable->filter('.rows')->eq(1)->filter('.row')->eq(2)->text());

        // admin
        $adminTable = $tableBlocks->eq(1);

        $this->assertSame('admin', $adminTable->filter('.table_name')->text());

        $this->assertCount(1, $adminTable->filter('.no_data'));
    }

    public function testB03Method02TestDataPage()
    {
        $this->assertFileExists($this->getHtmlPath('_testdata/6.html'));
        $html = $this->filterHtml('_testdata/6.html', 'body');

        $this->assertCount(1, $html->filter('.test_data_title'));
        $this->assertCount(1, $html->filter('.table_data_title'));
    }
}
