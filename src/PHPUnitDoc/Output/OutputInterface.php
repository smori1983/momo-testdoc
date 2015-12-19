<?php
namespace Momo\TestDoc\PHPUnitDoc\Output;

use Momo\TestDoc\PHPUnitDoc\TestDocContainer;

/**
 * Interface that test result output module should implement.
 */
interface OutputInterface
{
    /**
     * Execute the test result output.
     *
     * @param TestDocContainer $container
     */
    public function execute(TestDocContainer $container);
}
