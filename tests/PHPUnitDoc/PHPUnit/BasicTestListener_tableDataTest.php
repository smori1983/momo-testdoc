<?php
namespace Momo\TestDoc\PHPUnitDoc\PHPUnit;

class BasicTestListener_tableDataTest extends TestListenerTestCase
{
    protected function simulatePHPUnitRun()
    {
        $suite04 = $this->createPHPUnitTestSuite('Momo\TestDoc\PHPUnitDoc\PHPUnit\DummyTestA04');
        $suite04Test01 = $this->createPHPUnitTest('method01');

        $suite05 = $this->createPHPUnitTestSuite('Momo\TestDoc\PHPUnitDoc\PHPUnit\DummyTestA05');
        $suite05Test01 = $this->createPHPUnitTest('method01');

        $this->callStartTestSuite($suite04);
        $this->callStartTest($suite04Test01)->callEndTest($suite04Test01);
        $this->callEndTestSuite($suite04);

        $this->callStartTestSuite($suite05);
        $this->callStartTest($suite05Test01)->callEndTest($suite05Test01);
        $this->callEndTestSuite($suite05);
    }

    public function testTestDocsCount()
    {
        $testDocs = $this->SUT->getTestDocs();

        $this->assertCount(2, $testDocs);
    }

    public function testTestDocWithTableData()
    {
        $testDocs = $this->SUT->getTestDocs();
        $methodDocs = $testDocs[0]->getMethodDocs();

        $this->assertCount(1, $methodDocs);
        $this->assertTrue($methodDocs[0]->getReport()->hasTableData());

        $tableData = array(
            'user' => array(
                'columns' => array('id', 'name'),
                'rows' => array(
                    array('id' => 1, 'name' => 'user01'),
                    array('id' => 2, 'name' => 'user02'),
                ),
            ),
        );
        $this->assertEquals($tableData, $methodDocs[0]->getReport()->getTableData());
    }

    public function testTestDocWithoutTableData()
    {
        $testDocs = $this->SUT->getTestDocs();
        $methodDocs = $testDocs[1]->getMethodDocs();

        $this->assertCount(1, $methodDocs);
        $this->assertFalse($methodDocs[0]->getReport()->hasTableData());
    }
}
