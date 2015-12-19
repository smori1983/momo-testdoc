<?php
namespace Momo\TestDoc\PHPUnitDoc\Output\DefaultHtmlPrinter\Util;

class TestDataPage
{
    public function getDirectory()
    {
        return '_testdata';
    }

    public function getHref($testDataPage)
    {
        return sprintf('%s/%d.html', $this->getDirectory(), $testDataPage);
    }
}
