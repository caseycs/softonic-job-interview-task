<?php
class EncrypterTest extends PHPUnit_Framework_TestCase
{
    public function provider_GetInstance()
    {
        return array(
            array('kakuna'),
            array('numeric'),
        );
    }

    /**
     * @dataProvider provider_GetInstance
     */
    public function test_GetInstance($name)
    {
        $item1 = Encrypter::getInstance($name);
        $this->assertInstanceOf('EncrypterInterface', $item1);
        $item2 = Encrypter::getInstance($name);
        $this->assertSame($item1, $item2);
    }

    /**
     * @expectedException Exception
     */
    public function test_GetInstanceFail()
    {
        Encrypter::getInstance('xxx');
    }
}

