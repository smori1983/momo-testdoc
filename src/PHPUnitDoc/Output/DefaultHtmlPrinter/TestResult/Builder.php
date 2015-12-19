<?php
namespace Momo\TestDoc\PHPUnitDoc\Output\DefaultHtmlPrinter\TestResult;

use Momo\TestDoc\PHPUnitDoc\ClassDoc;
use Momo\TestDoc\PHPUnitDoc\TestDocContainer;

class Builder
{
    /**
     * @param TestDocContainer $container
     *
     * @return Root
     */
    public function build(TestDocContainer $container)
    {
        $root = new Root();

        $testNo = 0;

        foreach ($container->getTestDocs() as $testDoc) {
            $classDoc = $testDoc->getClassDoc();
            $setName = $this->prepareSetName($classDoc);
            $groupName = $this->prepareGroupName($classDoc);

            if (!$root->hasSet($setName)) {
                $root->addSet(new Set($setName));
            }

            if (!$root->getSet($setName)->hasGroup($groupName)) {
                $root->getSet($setName)->addGroup(new Group($groupName));
            }

            foreach ($testDoc->getMethodDocs() as $methodDoc) {
                $item = new Item(++$testNo, $classDoc, $methodDoc);
                $root->getSet($setName)->getGroup($groupName)->addItem($item);
            }
        }

        return $root;
    }

    private function prepareSetName(ClassDoc $classDoc)
    {
        return $classDoc->getName();
    }

    private function prepareGroupName(ClassDoc $classDoc)
    {
        return $classDoc->hasGroup() ? $classDoc->getGroup() : 'Uncategorized';
    }
}
