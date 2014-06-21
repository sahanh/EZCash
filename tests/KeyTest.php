<?php
use SZ\EZCash\Key\PublicKey;
use SZ\EZCash\Key\PrivateKey;

class KeyTest extends PHPUnit_Framework_Testcase
{
    public function testPublicKey()
    {
        $key = new PublicKey(__DIR__.'/shared/public_key.key');
        $this->assertSame(file_get_contents(__DIR__.'/shared/public_key_formatted.key'), (string) $key);
    }

    public function testPrivateKey()
    {
        $key = new PrivateKey(__DIR__.'/shared/private_key.key');
        $this->assertSame(file_get_contents(__DIR__.'/shared/private_key_formatted.key'), (string) $key);
    }
}