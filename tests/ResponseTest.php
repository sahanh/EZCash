<?php
/**
 * Note, this test covers some edge cases besides the actual response class
 */
use SZ\EZCash as E;
use SZ\EZCash\Key\PublicKey;
use SZ\EZCash\Receipt;
use Mockery as m;


class ResponseTest extends PHPUnit_Framework_Testcase
{
    protected $private_key;

    public function setUp()
    {
        $this->private_key = m::mock('SZ\EZCash\Key\PrivateKey', array(__DIR__.'/shared/private_key.key'))
                        ->shouldReceive('getFormattedKey')
                        ->times(1)
                        ->andReturn(file_get_contents(__DIR__.'/shared/private_key_formatted.key'))
                        ->getMock();
    }

    public function testSample()
    {
        $receipt     = 'xbWNp6KqkCcTC81uvniHfWUt9C3+LspvPTTCajzkSlPXod4hYDDOOsXF/Dq/hT3RWRgQJ6hA1DcRqAvYZ/Xm8fgqJGhtlPmv/OSDcfo4H+Yn63cLYAX2IJ5bfNaPDoEppS6atohYoZ3RPoxwLa8ESMy5nj3rboxEjBEIk08UP18=';
        
        $to_decrypt  = m::mock('SZ\EZCash\Cryptable')
                        ->shouldReceive('getCryptableData')
                        ->andReturn($receipt)
                        ->getMock();

        $c = new E\Crypter;
        $c->setKey($this->private_key);
        $receipt_data = $c->process($to_decrypt);
        
        $receipt  = new Receipt($receipt_data);
        $expected = array('transaction_id' => 'TX_1403351950', 'status_code' => '14', 'status_description' => 'Insufficient balance in your eZ Cash account.', 'transaction_amount' => '20.00', 'merchant_code' => 'TESTMERCHANT', 'wallet_reference_id' => NULL);
        
        $this->assertEquals($expected, $receipt->toArray());
    }

    public function tearDown()
    {
        m::close();
    }
}