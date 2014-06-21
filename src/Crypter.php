<?php
/**
 * Encrypts/Decrypts request and response objects using public and private keys 
 */
namespace SZ\EZCash;

use SZ\EZCash\Key\PrivateKey;
use SZ\EZCash\Key\PublicKey;
use SZ\EZCash\Key\Key;
use SZ\EZCash\Exception\CrypterException;

class Crypter
{
    /**
     * Key
     * @var SplFileObject
     */
    protected $key;

    public function setKey(Key $key)
    {
        $this->key = $key;
        return $this;
    }

    public function process($data)
    {
        if ($this->key instanceOf PublicKey) {
            return $this->encryptPublic($data);
        } elseif ($this->key instanceOf PrivateKey) {
            return $this->decryptPrivate($data);
        }
    }

    protected function encryptPublic($source)
    {
        //clear error stack
        while ($msg = openssl_error_string()) {};

        @openssl_public_encrypt($source, $crypted, (string) $this->key);
        
        if (!$crypted) {

            if ($error = openssl_error_string())
                throw new CrypterException($error);

        }

        return base64_encode($crypted);
    }

    protected function decryptPrivate($source)
    {
        $source = base64_decode($source);

        //clear error stack
        while ($msg = openssl_error_string()) {};

        @openssl_private_decrypt($source, $decrypted, (string) $this->key);
        
        if (!$decrypted) {

            if ($error = openssl_error_string())
                throw new CrypterException($error);

        }

        return $decrypted;
    }
}