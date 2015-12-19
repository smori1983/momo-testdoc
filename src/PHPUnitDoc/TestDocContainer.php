<?php
namespace Momo\TestDoc\PHPUnitDoc;

class TestDocContainer
{
    private $testDocs = array();

    public function __construct(array $testDocs)
    {
        $this->setTestDocs($testDocs);
        $this->freezeMethodDocReports();
    }

    private function setTestDocs(array $testDocs)
    {
        foreach ($testDocs as $testDoc) {
            if (!is_object($testDoc) || !($testDoc instanceof TestDoc)) {
                throw new \InvalidArgumentException(
                    'The elements should be instance of TestDoc.'
                );
            }
        }

        $this->testDocs = $testDocs;
    }

    private function freezeMethodDocReports()
    {
        foreach ($this->testDocs as $testDoc) {
            foreach ($testDoc->getMethodDocs() as $methodDoc) {
                $methodDoc->getReport()->freeze();
            }
        }
    }

    public function getTestDocs()
    {
        return $this->testDocs;
    }
}
