<?php
namespace Momo\TestDoc\PHPUnitDoc\Output\DefaultHtmlPrinter;

class SinglePageHtmlPrinter_structureTest extends HtmlPrinterTestCase
{
    protected function getHtmlPrinter($outputDir)
    {
        return new SinglePageHtmlPrinter($outputDir);
    }

    protected function simulatePHPUnitRun()
    {
        $suite01 = $this->createPHPUnitTestSuite('Momo\TestDoc\PHPUnitDoc\PHPUnit\DummyTestD01');
        $suite01Test01 = $this->createPHPUnitTest('method01');

        $this->callStartTestSuite($suite01);
        $this->callStartTest($suite01Test01)->callEndTest($suite01Test01);
        $this->callEndTestSuite($suite01);

        $suite02 = $this->createPHPUnitTestSuite('Momo\TestDoc\PHPUnitDoc\PHPUnit\DummyTestD02');
        $suite02Test01 = $this->createPHPUnitTest('method01');

        $this->callStartTestSuite($suite02);
        $this->callStartTest($suite02Test01)->callEndTest($suite02Test01);
        $this->callEndTestSuite($suite02);
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
     * index.htmlにテスト名の数だけテスト結果ブロックが出力されている。
     */
    public function testIndexPageTestBlocks()
    {
        $testBlocks = $this->filterHtml('index.html', '.test_block');
        $this->assertCount(2, $testBlocks);
    }

    /**
     * index.htmlのテスト結果ブロックにテスト名が出力されている。
     */
    public function testIndexPageTestTitles()
    {
        $testBlocks = $this->filterHtml('index.html', '.test_block');

        $this->assertCount(1, $testBlocks->eq(0)->filter('.test_title'));
        $this->assertCount(1, $testBlocks->eq(1)->filter('.test_title'));
    }

    /**
     * index.htmlのテスト結果ブロックにテストグループのブロックが出力されている。
     *
     * @dataProvider groupBlockSpecDataProvider
     */
    public function testIndexPageTestGroups($testBlockIndex, $groupCount)
    {
        $testBlocks = $this->filterHtml('index.html', '.test_block');

        $this->assertCount($groupCount, $testBlocks->eq($testBlockIndex)->filter('.test_group_block'));
        $this->assertCount($groupCount, $testBlocks->eq($testBlockIndex)->filter('.test_group_name'));
        $this->assertCount($groupCount, $testBlocks->eq($testBlockIndex)->filter('.test_result_table'));
        $this->assertCount($groupCount, $testBlocks->eq($testBlockIndex)->filter('.test_result_table .label'));
        $this->assertCount($groupCount, $testBlocks->eq($testBlockIndex)->filter('.test_result_table .item'));
    }

    public function groupBlockSpecDataProvider()
    {
        return array(
            array(0, 1),
            array(1, 1),
        );
    }
}
