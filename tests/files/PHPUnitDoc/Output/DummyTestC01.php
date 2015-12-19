<?php
namespace Momo\TestDoc\PHPUnitDoc\Output;

use Momo\TestDoc\PHPUnitDoc\Annotation as Doc;

/**
 * @Doc\Name("<UnitTest>")
 * @Doc\Group("<Group>")
 */
class DummyTestC01
{
    /**
     * @Doc\Name("<method01>")
     * @Doc\Given("<Given01>")
     * @Doc\Given("<Given02>")
     * @Doc\When("<When01>")
     * @Doc\When("<When02>")
     * @Doc\Then("<Then01>")
     * @Doc\Then("<Then02>")
     */
    public function method01()
    {
    }
}
