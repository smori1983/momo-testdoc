<?php
namespace Momo\TestDoc\PHPUnitDoc;

use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\AnnotationRegistry;

class Reader
{
    private $annotationReader = null;

    private $ignores = array(
        'after',
        'afterClass',
        'backupGlobals',
        'backupStaticAttributes',
        'before',
        'beforeClass',
        'covers',
        'coversDefaultClass',
        'coversNothing',
        'dataProvider',
        'depends',
        'expectedException',
        'expectedExceptionCode',
        'expectedExceptionMessage',
        'expectedExceptionMessageRegExp',
        'group',
        'large',
        'medium',
        'preserveGlobalState',
        'requires',
        'runTestsInSeparateProcesses',
        'runInSeparateProcess',
        'small',
        'test',
        'testdox',
        'ticket',
        'uses',
    );

    public function __construct()
    {
        $this->setUpAnnotationReader();
    }

    private function setUpAnnotationReader()
    {
        AnnotationRegistry::registerFile(__DIR__ . '/Annotation/Name.php');
        AnnotationRegistry::registerFile(__DIR__ . '/Annotation/Group.php');
        AnnotationRegistry::registerFile(__DIR__ . '/Annotation/Given.php');
        AnnotationRegistry::registerFile(__DIR__ . '/Annotation/When.php');
        AnnotationRegistry::registerFile(__DIR__ . '/Annotation/Then.php');
        AnnotationRegistry::registerFile(__DIR__ . '/Annotation/Data.php');

        $reader = new AnnotationReader();

        foreach ($this->ignores as $name) {
            $reader->addGlobalIgnoredName($name);
        }

        $this->annotationReader = $reader;
    }

    /**
     * @return TestDoc
     */
    public function read(\ReflectionClass $targetClass)
    {
        $classDoc = $this->createClassDoc($targetClass);
        $methodDocs = $this->createMethodDocs($targetClass);

        return $this->createTestDoc($classDoc, $methodDocs);
    }

    private function createClassDoc(\ReflectionClass $targetClass)
    {
        $classAnnotations = $this->annotationReader->getClassAnnotations($targetClass);

        return new ClassDoc($targetClass->getName(), $classAnnotations);
    }

    private function createMethodDocs(\ReflectionClass $targetClass)
    {
        $result = array();

        foreach ($this->collectMethodDocs($targetClass) as $methodDoc) {
            if ($methodDoc->validate()) {
                $result[] = $methodDoc;
            }
        }

        return $result;
    }

    private function collectMethodDocs(\ReflectionClass $targetClass)
    {
        $result = array();

        foreach ($targetClass->getMethods(\ReflectionMethod::IS_PUBLIC) as $reflectionMethod) {
            $result[] = $this->createMethodDoc($reflectionMethod);
        }

        return $result;
    }

    private function createMethodDoc(\ReflectionMethod $reflectionMethod)
    {
        $methodAnnotations = $this->annotationReader->getMethodAnnotations($reflectionMethod);

        return new MethodDoc($reflectionMethod->getName(), $methodAnnotations);
    }

    private function createTestDoc(ClassDoc $classDoc, array $methodDocs)
    {
        return new TestDoc($classDoc, $methodDocs);
    }
}
