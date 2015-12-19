<?php
namespace Momo\TestDoc\PHPUnitDoc\Output\DefaultHtmlPrinter;

use Momo\TestDoc\PHPUnitDoc\PHPUnit\BasicTestListener;
use Momo\TestDoc\PHPUnitDoc\PHPUnit\Output\OutputInterface;
use org\bovigo\vfs\vfsStream;
use org\bovigo\vfs\vfsStreamWrapper;
use org\bovigo\vfs\vfsStreamDirectory;
use Symfony\Component\DomCrawler\Crawler;

abstract class HtmlPrinterTestCase extends \PHPUnit_Framework_TestCase
{
    protected $listener = null;

    protected function createPHPUnitTestSuite($name)
    {
        $mock = $this->getMock('PHPUnit_Framework_TestSuite');
        $mock->expects($this->any())
             ->method('getName')
             ->will($this->returnValue($name));

        return $mock;
    }

    protected function createPHPUnitTest($name)
    {
        $mock = $this->getMock('PHPUnit_Framework_TestCase');
        $mock->expects($this->any())
             ->method('getName')
             ->will($this->returnValue($name));

        return $mock;
    }

    protected function callStartTestSuite(\PHPUnit_Framework_TestSuite $suite)
    {
        $this->listener->startTestSuite($suite);

        return $this;
    }

    protected function callEndTestSuite(\PHPUnit_Framework_TestSuite $suite)
    {
        $this->listener->endTestSuite($suite);

        return $this;
    }

    protected function callStartTest(\PHPUnit_Framework_Test $test)
    {
        $this->listener->startTest($test);

        return $this;
    }

    public function callTestFailure(\PHPUnit_Framework_Test $test)
    {
        $error = $this->getMock('PHPUnit_Framework_AssertionFailedError');
        $this->listener->addFailure($test, $error, 0.1);

        return $this;
    }

    protected function callEndTest(\PHPUnit_Framework_Test $test)
    {
        $this->listener->endTest($test, 0.1);

        return $this;
    }

    private function setUpTestListener()
    {
        $this->listener = new BasicTestListener($this->getHtmlPrinter(vfsStream::url('rootDir')));
    }

    /**
     * @return OutputInterface
     */
    abstract protected function getHtmlPrinter($outputDir);

    private function flushTestListener()
    {
        $this->listener->flush();
    }

    abstract protected function simulatePHPUnitRun();

    public function setUp()
    {
        vfsStreamWrapper::register();
        vfsStreamWrapper::setRoot(new vfsStreamDirectory('rootDir'));

        $this->setUpTestListener();
        $this->simulatePHPUnitRun();
        $this->flushTestListener();
    }

    protected function getHtmlPath($path)
    {
        return vfsStream::url(sprintf('rootDir/%s', $path));
    }

    protected function getHtml($path)
    {
        return file_get_contents($this->getHtmlPath($path));
    }

    protected function filterHtml($path, $selector)
    {
        $crawler = new Crawler($this->getHtml($path));

        return $crawler->filter($selector);
    }
}
