<?php
use SZ\EZCash\Crypter;
use SZ\EZCash\Key\PublicKey;
use SZ\EZCash\Key\PrivateKey;

use Mockery as m;

class CrypterTest extends PHPUnit_Framework_Testcase
{
    public function testEncryptDecrypt()
    {
        $public_key = m::mock('SZ\EZCash\Key\PublicKey', array(__DIR__.'/shared/public_key.key'))
                        ->shouldReceive('getFormattedKey')
                        ->times(1)
                        ->andReturn(file_get_contents(__DIR__.'/shared/public_key_formatted.key'))
                        ->getMock();

        $private_key = m::mock('SZ\EZCash\Key\PrivateKey', array(__DIR__.'/shared/private_key.key'))
                        ->shouldReceive('getFormattedKey')
                        ->times(1)
                        ->andReturn(file_get_contents(__DIR__.'/shared/private_key_formatted.key'))
                        ->getMock();

        $c = new Crypter;
        $c->setKey($public_key);
        $enc = $c->process('test');

        $c->setKey($private_key);
        
        $this->assertEquals('test', $c->process($enc));
    }

    public function tearDown()
    {
        m::close();
    }
}