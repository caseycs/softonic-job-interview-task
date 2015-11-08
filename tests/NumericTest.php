<?php
class NumericTest extends PHPUnit_Framework_TestCase
{
    const STRATEGY = 'numeric';
    
    public function provider_encrypt()
    {
        return array(
            array('abc', '1-2-3'),
            array('xyz', '24-25-26'),
        );
    }

    /**
     * @dataProvider provider_encrypt
     */
    public function test_encrypt($original, $encrypted)
    {
        $tmp1 = Encrypter::getInstance(self::STRATEGY)->encrypt($original);
        $this->assertEquals($encrypted, $tmp1);
        $decrypted = Encrypter::getInstance(self::STRATEGY)->decrypt($tmp1);
        $this->assertEquals($original, $decrypted);
    }

    /**
     * @expectedException Exception
     */
    public function test_encrypt_invalid()
    {
        Encrypter::getInstance(self::STRATEGY)->encrypt('1');
    }

    /**
     * @expectedException Exception
     */
    public function test_decrypt_invalid1()
    {
        Encrypter::getInstance(self::STRATEGY)->decrypt('0');
    }

    /**
     * @expectedException Exception
     */
    public function test_decrypt_invalid2()
    {
        Encrypter::getInstance(self::STRATEGY)->decrypt('27');
    }
}
