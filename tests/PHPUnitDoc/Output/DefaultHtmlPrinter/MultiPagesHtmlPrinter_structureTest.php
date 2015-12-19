<?php
namespace Momo\TestDoc\PHPUnitDoc\Output\DefaultHtmlPrinter;

class MultiPagesHtmlPrinter_structureTest extends HtmlPrinterTestCase
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

    /**
     * index.htmlが生成されている。
     */
    public function testIndexPageShouldExist()
    {
        $this->assertFileExists($this->getHtmlPath('index.html'));
    }

    /**
     * index.htmlに<head>タグが出力されている。
     */
    public function testIndexPageShouldHaveHeadTag()
    {
        $this->assertCount(1, $this->filterHtml('index.html', 'head'));
    }

    /**
     * index.htmlのページタイトルを確認する。
     */
    public function testIndexPageTitle()
    {
        $this->assertSame('テスト一覧', $this->filterHtml('index.html', '.test_list_title')->text());
    }

    /**
     * index.htmlにテスト一覧が生成されている。
     */
    public function testIndexPageTestList()
    {
        $this->assertCount(1, $this->filterHtml('index.html', '.test_list'));
    }

    /**
     * index.htmlのテスト一覧にテスト結果ページへのリンクが生成されている。
     */
    public function testIndexPageTestItemLink()
    {
        $items = $this->filterHtml('index.html', '.test_list > .item');

        $this->assertCount(1, $items);
        $this->assertSame('./1.html', $items->eq(0)->filter('.item a')->attr('href'));
    }

    /**
     * テスト結果ページのHTMLが生成されている。
     */
    public function testTestResultPageShouldExist()
    {
        $this->assertFileExists($this->getHtmlPath('1.html'));
    }

    /**
     * テスト結果ページのHTMLに<head>タグが出力されている。
     */
    public function testTestResultPageShouldHaveHeadTag()
    {
        $this->assertCount(1, $this->filterHtml('1.html', 'head'));
    }

    /**
     * テスト結果ページにテスト名が出力されている。
     */
    public function testTestResultPageTestTitle()
    {
        $testBlocks = $this->filterHtml('1.html', '.test_block');

        $this->assertCount(1, $testBlocks->eq(0)->filter('.test_title'));
    }

    /**
     * テスト結果ページにテストグループのブロックが出力されている。
     */
    public function testTestResultPageTestGroupBlock()
    {
        $testBlocks = $this->filterHtml('1.html', '.test_block');

        $this->assertCount(1, $testBlocks->eq(0)->filter('.test_group_block'));
    }

    /**
     * テスト結果ページのテストグループブロックにグループ名が出力されている。
     */
    public function testTestResultPageGroupName()
    {
        $testBlocks = $this->filterHtml('1.html', '.test_block');

        $this->assertCount(1, $testBlocks->eq(0)->filter('.test_group_name'));
    }

    /**
     * テスト結果ページのテストグループブロックにテスト結果テーブルが出力されている。
     */
    public function testTestResultPageResultTable()
    {
        $testBlocks = $this->filterHtml('1.html', '.test_block');

        $this->assertCount(1, $testBlocks->eq(0)->filter('.test_result_table'));
        $this->assertCount(1, $testBlocks->eq(0)->filter('.test_result_table .label'));
        $this->assertCount(1, $testBlocks->eq(0)->filter('.test_result_table .item'));
    }
}
