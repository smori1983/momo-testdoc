<?php
namespace Momo\TestDoc\PHPUnitDoc\Output\DefaultHtmlPrinter;

class MultiPagesHtmlPrinter_groupNameTest extends HtmlPrinterTestCase
{
    protected function getHtmlPrinter($outputDir)
    {
        return new MultiPagesHtmlPrinter($outputDir);
    }

    protected function simulatePHPUnitRun()
    {
        $suite01 = $this->createPHPUnitTestSuite('Momo\TestDoc\PHPUnitDoc\PHPUnit\DummyTestF01');
        $suite01Test01 = $this->createPHPUnitTest('method01');

        $suite02 = $this->createPHPUnitTestSuite('Momo\TestDoc\PHPUnitDoc\PHPUnit\DummyTestF02');
        $suite02Test02 = $this->createPHPUnitTest('method01');

        $this->callStartTestSuite($suite01);
        $this->callStartTest($suite01Test01)->callEndTest($suite01Test01);
        $this->callEndTestSuite($suite01);

        $this->callStartTestSuite($suite02);
        $this->callStartTest($suite02Test02)->callEndTest($suite02Test02);
        $this->callEndTestSuite($suite02);
    }

    /**
     * @dataProvider resultPageDataProvider
     */
    public function testGroupNamesInTestResultPages($path, $groupBlockCount, $index, $result)
    {
        $this->assertFileExists($this->getHtmlPath($path));

        $groupBlocks = $this->filterHtml($path, '.test_block .test_group_block');

        $this->assertCount($groupBlockCount, $groupBlocks);
        $this->assertSame($result, $groupBlocks->eq($index)->filter('.test_group_name')->text());
    }

    public function resultPageDataProvider()
    {
        return array(
            array('1.html', 2, 0, 'Group01'),
            array('1.html', 2, 1, 'Uncategorized'),
        );
    }

    /**
     * @dataProvider dataPageDataProvider
     */
    public function testGroupNameInTestDataPages($filePath, $result)
    {
        $this->assertFileExists($this->getHtmlPath($filePath));
        $this->assertSame($result, $this->filterHtml($filePath, '.summary_block .group')->text());
    }

    public function dataPageDataProvider()
    {
        return array(
            array('_testdata/1.html', 'Group01'),
            array('_testdata/2.html', 'Uncategorized'),
        );
    }
}
