<?php
use SZ\EZCash\Crypter;
use SZ\EZCash\Key\PublicKey;
use SZ\EZCash\Key\PrivateKey;

class CrypterTest extends PHPUnit_Framework_Testcase
{
    public function testEncryptDecrypt()
    {
        $public_key  = new PublicKey(__DIR__.'/shared/public_key.key');
        $private_key = new PrivateKey(__DIR__.'/shared/private_key.key');

        $c = new Crypter;
        $c->setKey($public_key);
        $enc = $c->process('test');

        $c->setKey($private_key);
        
        $this->assertEquals('test', $c->process($enc));
    }
}