<?php

class AuthModel extends SZ_Kennel
{
    /**
     * Autoload signature property
     */
    protected $db;

    /**
     * Password stretching times
     */
    const STRETCHING_TIMES = 100;

    /**
     * Generate salt and encrypt password
     *
     * @public
     * @param string $password
     * @return stdClass $enc
     */
    public function encryptPassword($password)
    {
        $enc = new stdClass;
        $enc->salt     = sha1(openssl_random_pseudo_bytes(32));
        $enc->password = $this->_stretchPassword($enc->salt, $password);

        return $enc;
    }

    /**
     * Stretching password
     *
     * @protected
     * @param string $salt
     * @param string $password
     * @retrun string
     */
    protected function _stretchPassword($salt, $password)
    {
        for ( $i = 0; $i < self::STRETCHING_TIMES; ++$i )
        {
            $password = sha1($salt . $password);
        }

        return $password;
    }
}
