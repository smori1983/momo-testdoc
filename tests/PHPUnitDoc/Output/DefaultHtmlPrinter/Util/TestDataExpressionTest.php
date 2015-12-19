<?php
namespace Momo\TestDoc\PHPUnitDoc\Output\DefaultHtmlPrinter\Util;

class TestDataExpressionTest extends \PHPUnit_Framework_TestCase
{
    private $SUT = null;

    public function setUp()
    {
        $this->SUT = new TestDataExpression();
    }

    public function testNull()
    {
        $this->assertSame('[NULL]', $this->SUT->get(null));
    }

    public function testBool()
    {
        $this->assertSame('[TRUE]', $this->SUT->get(true));
        $this->assertSame('[FALSE]', $this->SUT->get(false));
    }

    public function testObject()
    {
        $this->assertSame('[OBJECT]', $this->SUT->get(new \StdClass()));
    }

    public function testString()
    {
        $this->assertSame('', $this->SUT->get(''));
        $this->assertSame('hoge', $this->SUT->get('hoge'));
        $this->assertSame('10kg', $this->SUT->get('10kg'));
    }

    public function testNumeric()
    {
        $this->assertSame('0.1', $this->SUT->get(0.1));
        $this->assertSame('199', $this->SUT->get(199));
        $this->assertSame('1.0', $this->SUT->get('1.0'));
    }

    /**
     * @dataProvider arrayDataProvider
     */
    public function testArray($input, $result)
    {
        $this->assertSame($result, $this->SUT->get($input));
    }

    public function arrayDataProvider()
    {
        return array(
            array(array(), '[ARRAY] ()'),
            array(array(null, null), '[ARRAY] (0 => [NULL], 1 => [NULL])'),
            array(array(true, false), '[ARRAY] (0 => [TRUE], 1 => [FALSE])'),
            array(array(new \StdClass(), new \StdClass()), '[ARRAY] (0 => [OBJECT], 1 => [OBJECT])'),
            array(array('a', 'b'), '[ARRAY] (0 => a, 1 => b)'),
            array(array(1, 0.1), '[ARRAY] (0 => 1, 1 => 0.1)'),
            array(array(array(), array()), '[ARRAY] (0 => [ARRAY], 1 => [ARRAY])'),

            array(array('key' => 'value'), '[ARRAY] (key => value)'),
            array(array('name' => 'foo', 'tags' => array('a', 'b')), '[ARRAY] (name => foo, tags => [ARRAY])'),
        );
    }
}
