<?php
use SZ\EZCash\Request;

class RequestTest extends PHPUnit_Framework_Testcase
{

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage transaction_id, amount, url should not be null
     * @return [type] [description]
     */
    public function testInvalidArguments()
    {
        $req = new Request;
        $req->setMerchantCode('TESTMERCHANT');
        $req->getCryptableData();
    }

    public function testCryptableData()
    {
        $req = new Request;
        $req->setMerchantCode('TESTMERCHANT')
            ->setTransactionId('TX_22323')
            ->setAmount('20.23')
            ->setReturnUrl('http://google.com');

        $this->assertSame('TESTMERCHANT|TX_22323|20.23|http://google.com', $req->getCryptableData());
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Amount should be a valid payment value, valid format XXXXXX.XX
     */
    public function testInvalidAmount()
    {
        $req = new Request;
        $req->setAmount('yeps');
    }

    public function testUsableAmounts()
    {
        $req = new Request;
        $req->setAmount('20.00');
        $this->assertEquals(20, PHPUnit_Framework_Assert::readAttribute($req, 'amount'));

        $req->setAmount('20.29');
        $this->assertEquals('20.29', PHPUnit_Framework_Assert::readAttribute($req, 'amount'));
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Invalid return url
     */
    public function testInvalidReturnUrl()
    {
        $req = new Request;
        $req->setReturnUrl('invalid');
    }
}