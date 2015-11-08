<?php
// usually i like writing comments, but here - i don't really think they are necessary -
// from my side it's all clear

class Encrypter
{
    private static $instances;

    /**
     * @return EncrypterInterface
     */
    public static function getInstance($strategy)
    {
        if (!isset(self::$instances[$strategy])) {
            $class = 'Encrypter' . ucfirst($strategy);
            if (!class_exists($class) || !in_array('EncrypterInterface', class_implements($class))) {
                throw new \Exception;
            }

            self::$instances[$strategy] = new $class;
        }
        return self::$instances[$strategy];
    }
}

interface EncrypterInterface
{
    function encrypt($value);

    function decrypt($value);
}

class EncrypterKakuna extends EncrypterAbstract implements EncrypterInterface
{
    const STEP = 3;
    const FIRST = 'a';
    const LAST = 'z';

    public function encrypt($value)
    {
        if (!$this->isValid($value)) throw new Exception;

        for ($i = 0; $i < strlen($value); $i ++) {
            $old = ord($value[$i]);
            $new = $old + self::STEP;
            if ($new > ord(self::LAST)) $new = ord(self::FIRST) + ($new - ord(self::LAST)) - 1;
            $value[$i] = chr($new);
        }
        return $value;
    }

    public function decrypt($value)
    {
        if (!$this->isValid($value)) throw new Exception;

        for ($i = 0; $i < strlen($value); $i ++) {
            $old = ord($value[$i]);
            $new = $old - self::STEP;
            if ($new < ord(self::FIRST)) $new = ord(self::LAST) - (ord(self::FIRST) - $new) + 1;
            $value[$i] = chr($new);
        }
        return $value;
    }
}

class EncrypterNumeric extends EncrypterAbstract implements EncrypterInterface
{
    const FIRST = 'a';
    const LAST = 'z';

    public function encrypt($value)
    {
        if (!$this->isValid($value)) throw new Exception;

        $result = '';
        for ($i = 0; $i < strlen($value); $i ++) {
            $number = ord($value[$i]) - ord(self::FIRST) + 1;
            $result .= $number . '-';
        }
        return substr($result, 0, -1);
    }

    public function decrypt($value)
    {
        $result = '';
        foreach (explode('-', $value) as $number) {
            $number = (int)$number;

            if ($number < 1 || $number > ord(self::LAST) - ord(self::FIRST) + 1) throw new Exception;
            $result .= chr(ord(self::FIRST) + $number - 1);
        }
        return $result;
    }
}

abstract class EncrypterAbstract
{
    public function isValid($value)
    {
        return preg_match('/^[a-z]+$/', $value);
    }
}
