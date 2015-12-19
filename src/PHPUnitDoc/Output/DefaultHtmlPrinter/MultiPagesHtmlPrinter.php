<?php
namespace Momo\TestDoc\PHPUnitDoc\Output\DefaultHtmlPrinter;

use Momo\TestDoc\PHPUnitDoc\Output\DefaultHtmlPrinter\TestResult\Root;
use Momo\TestDoc\PHPUnitDoc\Output\DefaultHtmlPrinter\TestResult\Set;

class MultiPagesHtmlPrinter extends AbstractHtmlPrinter
{
    private $testList = array();

    protected function writeTestResultPages(Root $root)
    {
        $this->setUpTestList($root);
        $this->writeIndexPage($root);
        $this->writeTestResultItemPages($root);
    }

    private function setUpTestList(Root $root)
    {
        $index = 0;

        foreach ($root->getSets() as $set) {
            $this->testList[$set->getName()] = (++$index);
        }
    }

    private function writeIndexPage(Root $root)
    {
        $path = sprintf('%s/index.html', $this->getOutputDir());
        $html = $this->createIndexHtml($root);
        file_put_contents($path, $html);
    }

    private function createIndexHtml(Root $root)
    {
        $html = array();

        $html[] = '<html>';
        $html[] = $this->createHtmlHead();
        $html[] = '<body>';
        $html[] = '<h1 class="test_list_title">Test List</h1>';
        $html[] = '<table class="test_list">';
        $html[] = '<tr class="label">';
        $html[] = '<th>Test Name</th>';
        $html[] = '<th>Result</th>';
        $html[] = '<th>Rate</th>';
        $html[] = '</tr>';

        foreach ($this->testList as $name => $index) {
            $set = $root->getSet($name);

            $html[] = sprintf('<tr class="item %s">', $set->isAllSuccess() ? 'ok' : 'ng');
            $html[] = sprintf('<td class="name"><a href="./%s">%s</a></td>', $this->getTestResultPageFileName($index), $this->e($name));
            $html[] = sprintf('<td class="result bold center">%s</td>', $set->isAllSuccess() ? '<span class="ok">OK</span>' : '<span class="ng">NG</span>');
            $html[] = sprintf('<td class="stat right">%d/%d</td>', $set->getSuccessCount(), $set->getTestCount());
            $html[] = '</tr>';
        }

        $html[] = '</table>';
        $html[] = '</body>';
        $html[] = '</html>';

        return implode($html, PHP_EOL);
    }

    private function writeTestResultItemPages(Root $root)
    {
        foreach ($root->getSets() as $set) {
            $path = sprintf('%s/%s', $this->getOutputDir(), $this->getTestResultPageFileName($this->testList[$set->getName()]));
            $html = $this->createTestResultItemPage($set);
            file_put_contents($path, $html);
        }
    }

    private function createTestResultItemPage(Set $set)
    {
        $html = array();

        $html[] = '<html>';
        $html[] = $this->createHtmlHead();
        $html[] = '<body>';
        $html[] = $this->createTestResultHtml($set);
        $html[] = $this->createTestResultPageJavaScript();
        $html[] = '</body>';
        $html[] = '</html>';

        return implode($html, PHP_EOL);
    }

    private function getTestResultPageFileName($index)
    {
        return sprintf('%d.html', $index);
    }
}
