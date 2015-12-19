<?php
namespace Momo\TestDoc\PHPUnitDoc\Output\DefaultHtmlPrinter;

use Momo\TestDoc\PHPUnitDoc\MethodDoc;
use Momo\TestDoc\PHPUnitDoc\Output\DefaultHtmlPrinter\TestResult\Builder;
use Momo\TestDoc\PHPUnitDoc\Output\DefaultHtmlPrinter\TestResult\Group;
use Momo\TestDoc\PHPUnitDoc\Output\DefaultHtmlPrinter\TestResult\Item;
use Momo\TestDoc\PHPUnitDoc\Output\DefaultHtmlPrinter\TestResult\Root;
use Momo\TestDoc\PHPUnitDoc\Output\DefaultHtmlPrinter\TestResult\Set;
use Momo\TestDoc\PHPUnitDoc\Output\DefaultHtmlPrinter\Util\TestDataExpression;
use Momo\TestDoc\PHPUnitDoc\Output\DefaultHtmlPrinter\Util\TestDataPage;
use Momo\TestDoc\PHPUnitDoc\Output\OutputInterface;
use Momo\TestDoc\PHPUnitDoc\TestDocContainer;

abstract class AbstractHtmlPrinter implements OutputInterface
{
    private $outputDir = null;

    private $testResultBuilder = null;

    private $testDataExpr = null;
    private $testDataPage = null;

    public function __construct($outputDir = null)
    {
        $this->setOutputDir($this->resolveOutputDir($outputDir));
        $this->testResultBuilder = new Builder();
        $this->testDataExpr = new TestDataExpression();
        $this->testDataPage = new TestDataPage();
    }

    protected function resolveOutputDir($outputDir = null)
    {
        if (is_string($envDir = getenv('PHPUNITDOC_OUTPUTDIR')) && is_dir($envDir)) {
            return $envDir;
        }

        if (is_string($outputDir) && is_dir($outputDir)) {
            return $outputDir;
        }

        throw new \RuntimeException('Output directory not found.');
    }

    protected function setOutputDir($outputDir)
    {
        $this->outputDir = $outputDir;
    }

    protected function getOutputDir()
    {
        return $this->outputDir;
    }

    public function execute(TestDocContainer $container)
    {
        $this->createAppendixDirectory();
        $this->copyResources();

        $testResult = $this->testResultBuilder->build($container);

        $this->writeTestResultPages($testResult);
        $this->writeAppendixPages($testResult);
    }

    abstract protected function writeTestResultPages(Root $root);

    private function createAppendixDirectory()
    {
        if (!is_dir($directory = sprintf('%s/%s', $this->getOutputDir(), $this->testDataPage->getDirectory()))) {
            mkdir($directory);
        }
    }

    private function copyResources()
    {
        if (!is_dir($directory = sprintf('%s/resources', $this->getOutputDir()))) {
            mkdir($directory);
        }
        if (!is_dir($directory = sprintf('%s/resources/js', $this->getOutputDir()))) {
            mkdir($directory);
        }

        $src = __DIR__ . '/resources/js/jquery-1.11.2.min.js';
        $dst = sprintf('%s/resources/js/jquery-1.11.2.min.js', $this->getOutputDir());
        copy($src, $dst);

        $src = __DIR__ . '/resources/js/htmlPrinter.js';
        $dst = sprintf('%s/resources/js/htmlPrinter.js', $this->getOutputDir());
        copy($src, $dst);
    }

    protected function createTestResultHtml(Set $set)
    {
        $html = array();

        $html[] = '<div class="test_block">';
        $html[] = '<h1 class="test_title">' . $this->e($set->getName()) . '</h1>';

        foreach ($set->getGroups() as $group) {
            $html[] = '<div class="test_group_block">';
            $html[] = '<h2 class="test_group_name">' . $this->e($group->getName()) . '</h2>';
            $html[] = '<table class="test_result_table full_width">';
            $html[] = '<tr class="label">';
            $html[] = '<th class="col_no">No</th>';
            $html[] = '<th class="col_name">Test Name</th>';
            $html[] = '<th class="col_given">Given</th>';
            $html[] = '<th class="col_when">When</th>';
            $html[] = '<th class="col_then">Then</th>';
            $html[] = '<th class="col_result">Result</th>';
            $html[] = '<th class="col_stat">Rate</th>';
            $html[] = '<th class="col_link">Test Data</th>';
            $html[] = '</tr>';

            foreach ($group->getItems() as $item) {
                $html[] = sprintf('<tr class="item %s" test-source="%s">', $item->isAllSuccess() ? 'ok' : 'ng', $this->e($item->getSourceExpression()));
                $html[] = sprintf('<td class="no right">%d</td>', $item->getTestNo());
                $html[] = sprintf('<td class="name">%s</td>', $this->e($item->getName()));
                $html[] = sprintf('<td class="given">%s</td>', $this->ebr($item->getGiven()));
                $html[] = sprintf('<td class="when">%s</td>', $this->ebr($item->getWhen()));
                $html[] = sprintf('<td class="then">%s</td>', $this->ebr($item->getThen()));
                $html[] = sprintf('<td class="result bold center">%s</td>', $item->isAllSuccess() ? '<span class="ok">OK</span>' : '<span class="ng">NG</span>');
                $html[] = sprintf('<td class="stat right">%d/%d</td>', $item->getSuccessCount(), $item->getTestCount());
                $html[] = sprintf('<td class="testdata">%s</td>', $this->createAppendixLink($item));
                $html[] = '</tr>';
            }
            $html[] = '</table>';
            $html[] = '</div>';
        }
        $html[] = '</div>';

        return implode($html, PHP_EOL);
    }

    private function createAppendixLink(Item $item)
    {
        if ($item->hasTestData()) {
            return sprintf('<a href="./%s" target="_blank">Show</a>', $this->testDataPage->getHref($item->getTestNo()));
        }

        return '';
    }

    private function writeAppendixPages(Root $root)
    {
        foreach ($root->getSets() as $set) {
            foreach ($set->getGroups() as $group) {
                foreach ($group->getItems() as $item) {
                    if ($item->hasTestData()) {
                        $this->writeAppendixPage($set, $group, $item);
                    }
                }
            }
        }
    }

    private function writeAppendixPage(Set $set, Group $group, Item $item)
    {
        $path = sprintf('%s/%s', $this->getOutputDir(), $this->testDataPage->getHref($item->getTestNo()));
        $html = $this->createAppendixPage($set, $group, $item);
        file_put_contents($path, $html);
    }

    private function createAppendixPage(Set $set, Group $group, Item $item)
    {
        $html = array();

        $html[] = '<html>';
        $html[] = $this->createHtmlHead();
        $html[] = '<body>';
        $html[] = $this->createAppendixSummaryBlock($set, $group, $item);
        $html[] = $this->createAppendixTestDataBlock($item);
        $html[] = $this->createAppendixTableDataBlock($item);
        $html[] = '</body>';
        $html[] = '</html>';

        return implode($html, PHP_EOL);
    }

    private function createAppendixSummaryBlock(Set $set, Group $group, Item $item)
    {
        $html = array();

        $html[] = '<div class="summary_block">';
        $html[] = sprintf('<h1 class="title">%s</h1>', $this->e($set->getName()));
        $html[] = sprintf('<h2 class="group">%s</h2>', $this->e($group->getName()));
        $html[] = '<table>';
        $html[] = sprintf('<tr><td>No</td><td class="no">%d</td></tr>', $item->getTestNo());
        $html[] = sprintf('<tr><td>Test Name</td><td class="name">%s</td></tr>', $this->e($item->getName()));
        $html[] = sprintf('<tr><td>Given</td><td class="given">%s</td></tr>', $this->ebr($item->getGiven()));
        $html[] = sprintf('<tr><td>When</td><td class="when">%s</td></tr>', $this->ebr($item->getWhen()));
        $html[] = sprintf('<tr><td>Then</td><td class="then">%s</td></tr>', $this->ebr($item->getThen()));
        $html[] = '</table>';
        $html[] = '</div>';

        return implode($html, PHP_EOL);
    }

    private function createAppendixTestDataBlock(Item $item)
    {
        $methodDoc = $item->getMethodDoc();

        if (!$methodDoc->getReport()->hasProvidedData()) {
            return '';
        }

        $html = array();

        $html[] = '<div class="test_data_block">';
        $html[] = '<h1 class="test_data_title">Test Data</h1>';
        $html[] = '<table class="test_data">';
        $html[] = '<tr>';
        foreach ($this->makeTestDataLabel($methodDoc) as $label) {
            $html[] = sprintf('<th>%s</th>', $this->e($label));
        }
        $html[] = '</tr>';

        foreach ($methodDoc->getReport()->getProvidedData() as $idx => $data) {
            $html[] = sprintf('<tr class="%s">', $methodDoc->getReport()->isSuccessAt($idx) ? '' : 'ng');
            foreach ($data as $value) {
                $html[] = sprintf('<td>%s</td>', $this->e($this->testDataExpr->get($value)));
            }
            $html[] = '</tr>';
        }

        $html[] = '</table>';
        $html[] = '</div>';

        return implode($html, PHP_EOL);
    }

    /**
     * 前提: MethodDocがデータプロバイダのデータを保持していること。
     */
    private function makeTestDataLabel(MethodDoc $methodDoc)
    {
        $providedData = $methodDoc->getReport()->getProvidedData();
        $dataLabel = $methodDoc->getDataLabel();

        $result = array();

        foreach (array_keys($providedData[0]) as $index) {
            if (array_key_exists($index, $dataLabel)) {
                $result[] = $dataLabel[$index];
            } else {
                $result[] = sprintf('Data[%d]', $index + 1);
            }
        }

        return $result;
    }

    private function createAppendixTableDataBlock(Item $item)
    {
        $methodDoc = $item->getMethodDoc();

        if (!$methodDoc->getReport()->hasTableData()) {
            return '';
        }

        $tableData = $methodDoc->getReport()->getTableData();

        $html = array();

        $html[] = '<div class="table_data_block">';
        $html[] = '<h1 class="table_data_title">Initial Data of Table(s)</h1>';

        foreach ($tableData as $tableName => $tableSpec) {
            $html[] = '<div class="table_block">';
            $html[] = sprintf('<h2 class="table_name">%s</h2>', $this->e($tableName));

            if (count($tableSpec['rows']) > 0) {
                $html[] = '<table class="table_rows">';
                $html[] = '<tr class="columns">';
                foreach ($tableSpec['columns'] as $column) {
                    $html[] = sprintf('<th class="column">%s</th>', $this->e($column));
                }
                $html[] = '</tr>';

                foreach ($tableSpec['rows'] as $row) {
                    $html[] = '<tr class="rows">';
                    foreach ($row as $column) {
                        $html[] = sprintf('<td class="row">%s</td>', $this->e($this->testDataExpr->get($column)));
                    }
                    $html[] = '</tr>';
                }

                $html[] = '</table>';
            } else {
                $html[] = '<p class="no_data">No Record</p>';
            }

            $html[] = '</div>';
        }

        $html[] = '</div>';

        return implode($html, PHP_EOL);
    }

    protected function createHtmlHead()
    {
        $html = array();

        $html[] = '<head>';
        $html[] = '<meta charset="utf-8" />';
        $html[] = '<style type="text/css">';
        $html[] = 'body, table { font-size: 12px; }';
        $html[] = 'a { color: #0044cc; }';
        $html[] = '.left { text-align: left; }';
        $html[] = '.right { text-align: right; }';
        $html[] = '.center { text-align: center; }';
        $html[] = '.bold { font-weight: bold; }';
        $html[] = 'table { border-collapse: collapse; cell-spacing: 0; }';
        $html[] = 'table.full_width { width: 100%; }';
        $html[] = 'tr { border-top: 1px solid #000000; border-left: 1px solid #000000; }';
        $html[] = 'th, td { border-right: 1px solid #000000; border-bottom: 1px solid #000000; }';
        $html[] = 'th, td { padding: 2px 10px; }';
        $html[] = 'th { background-color: #999999; }';
        $html[] = 'th.col_no { width: 5%; }';
        $html[] = 'th.col_given { width: 20%; }';
        $html[] = 'th.col_when { width: 20%; }';
        $html[] = 'th.col_then { width: 20%; }';
        $html[] = 'th.col_result { width: 5%; }';
        $html[] = 'th.col_stat { width: 5%; }';
        $html[] = 'th.col_link { width: 10%; }';
        $html[] = 'span.ok { color: #000000; }';
        $html[] = 'span.ng { color: #ff0000; }';
        $html[] = 'tr.ng > td { background-color: #f2dede; }';
        $html[] = '</style>';
        $html[] = '</head>';

        return implode($html, PHP_EOL);
    }

    protected function createTestResultPageJavaScript()
    {
        $html = array();

        $html[] = '<style type="text/css">';
        $html[] = '#js_test_source {';
        $html[] = 'position: fixed;';
        $html[] = 'top: 0px;';
        $html[] = 'left: 0px;';
        $html[] = 'width: 100%;';
        $html[] = 'height: 50px;';
        $html[] = 'line-height: 50px;';
        $html[] = 'text-align: center;';
        $html[] = 'font-family: monospace;';
        $html[] = 'background-color: #cccccc;';
        $html[] = 'border-bottom: 1px solid #888888;';
        $html[] = 'display: none;';
        $html[] = '}';
        $html[] = '#js_test_source_test_no {';
        $html[] = 'float: left;';
        $html[] = 'border-right: 1px solid #888888;';
        $html[] = 'padding: 0px 20px;';
        $html[] = '}';
        $html[] = '#js_test_source_close {';
        $html[] = 'cursor: pointer;';
        $html[] = 'float: right;';
        $html[] = 'height: 50px;';
        $html[] = 'line-height: 50px;';
        $html[] = 'background-color: #d46a6a;';
        $html[] = 'padding: 0px 20px;';
        $html[] = '}';
        $html[] = '</style>';
        $html[] = '<script type="text/javascript" src="./resources/js/jquery-1.11.2.min.js"></script>';
        $html[] = '<script type="text/javascript" src="./resources/js/htmlPrinter.js"></script>';
        $html[] = '<div id="js_test_source">';
        $html[] = '<div id="js_test_source_test_no"></div>';
        $html[] = '<div id="js_test_source_close">CLOSE</div>';
        $html[] = '<div id="js_test_source_content"></div>';
        $html[] = '</div>';

        return implode($html, PHP_EOL);
    }

    protected function e($value)
    {
        return htmlspecialchars($value);
    }

    protected function ebr(array $values)
    {
        $escaped = array();

        foreach ($values as $value) {
            $escaped[] = $this->e($value);
        }

        return implode($escaped, '<br>' . PHP_EOL);
    }
}
