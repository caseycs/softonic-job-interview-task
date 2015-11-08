<?php
class KakunaTest extends PHPUnit_Framework_TestCase
{
    const STRATEGY = 'kakuna';

    public function provider_encrypt()
    {
        return array(
            array('abc', 'def'),
            array('wxyz', 'zabc'),
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
    public function test_decrypt_invalid()
    {
        Encrypter::getInstance(self::STRATEGY)->decrypt('}');
    }
}
