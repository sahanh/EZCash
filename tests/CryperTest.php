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

        $to_encrypt  = m::mock('SZ\EZCash\Cryptable')
                        ->shouldReceive('getCryptableData')
                        ->andReturn('test')
                        ->getMock();

        $c = new Crypter;
        $c->setKey($public_key);
        $enc = $c->process($to_encrypt);

        $to_decrypt  = m::mock('SZ\EZCash\Cryptable')
                        ->shouldReceive('getCryptableData')
                        ->andReturn($enc)
                        ->getMock();

        $c->setKey($private_key);
        
        $this->assertEquals('test', $c->process($to_decrypt));
    }

    /**
     * @expectedException SZ\EZCash\Exception\CrypterException
     */
    public function testInvalidCryptingOperation()
    {
        $public_key = m::mock('SZ\EZCash\Key\PublicKey', array(__DIR__.'/shared/public_key.key'))
                        ->shouldReceive('getFormattedKey')
                        ->times(1)
                        ->andReturn('invalid_key')
                        ->getMock();
        
        $c = new Crypter;
        $c->setKey($public_key);

        $to_encrypt  = m::mock('SZ\EZCash\Cryptable')
                        ->shouldReceive('getCryptableData')
                        ->andReturn('test')
                        ->getMock();

        $c->process($to_encrypt);
    }

    public function tearDown()
    {
        m::close();
    }
}