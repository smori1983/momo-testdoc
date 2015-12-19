<?php
namespace Momo\TestDoc\PHPUnitDoc;

class TestDoc
{
    private $classDoc = null;

    private $methodDocs = array();

    /**
     * @param ClassDoc $classDoc
     * @param MethodDoc[] $methodDocs
     */
    public function __construct(ClassDoc $classDoc, array $methodDocs)
    {
        $this->setClassDoc($classDoc);
        $this->setMethodDocs($methodDocs);
    }

    private function setClassDoc(ClassDoc $classDoc)
    {
        if ($classDoc->validate()) {
            $this->classDoc = $classDoc;
        }
    }

    private function setMethodDocs(array $methodDocs)
    {
        foreach ($methodDocs as $methodDoc) {
            $this->addMethodDoc($methodDoc);
        }
    }

    private function addMethodDoc(MethodDoc $methodDoc)
    {
        if ($methodDoc->validate()) {
            $this->methodDocs[] = $methodDoc;
        }
    }

    /**
     * @return bool
     */
    public function validate()
    {
        return !is_null($this->getClassDoc())
            && count($this->getMethodDocs()) > 0;
    }

    /**
     * @return ClassDoc
     */
    public function getClassDoc()
    {
        return $this->classDoc;
    }

    /**
     * @return MethodDoc[]
     */
    public function getMethodDocs()
    {
        return $this->methodDocs;
    }

    /**
     * @param string $methodName
     *
     * @return bool
     */
    public function hasMethodDocOf($methodName)
    {
        $methodDoc = $this->searchMethodDocOf($methodName);

        return ($methodDoc instanceof MethodDoc);
    }

    /**
     * @param string $methodName
     *
     * @return MethodDoc
     * @throw RuntimeException
     */
    public function getMethodDocOf($methodName)
    {
        $methodDoc = $this->searchMethodDocOf($methodName);

        if ($methodDoc instanceof MethodDoc) {
            return $methodDoc;
        }

        throw new \RuntimeException(sprintf('MethodDoc for %s not found.', $methodName));
    }

    private function searchMethodDocOf($methodName)
    {
        foreach ($this->getMethodDocs() as $methodDoc) {
            if ($methodDoc->getMethodName() === $methodName) {
                return $methodDoc;
            }
        }

        return null;
    }
}
