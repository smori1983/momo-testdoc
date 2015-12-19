<?php
namespace Momo\TestDoc\PHPUnitDoc\Output\DefaultHtmlPrinter;

use Momo\TestDoc\PHPUnitDoc\Output\DefaultHtmlPrinter\TestResult\Root;

class SinglePageHtmlPrinter extends AbstractHtmlPrinter
{
    protected function writeTestResultPages(Root $root)
    {
        $this->writeIndexPage($root);
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

        foreach ($root->getSets() as $set) {
            $html[] = $this->createTestResultHtml($set);
        }

        $html[] = $this->createTestResultPageJavaScript();
        $html[] = '</body>';
        $html[] = '</html>';

        return implode($html, PHP_EOL);
    }
}
