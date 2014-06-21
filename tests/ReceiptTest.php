<?php
use SZ\EZCash\Receipt;

class ReceiptTest extends PHPUnit_Framework_Testcase
{
    /**
     * @expectedException SZ\EZCash\Exception\InvalidTransactionException
     * @expectedExceptionMessage Insufficient balance in your eZ Cash account.
     */
    public function testFailedTransaction()
    {
        $expected = array('transaction_id' => 'TX_1403351950', 'status_code' => '14', 'status_description' => 'Insufficient balance in your eZ Cash account.', 'transaction_amount' => '20.00', 'merchant_code' => 'TESTMERCHANT', 'wallet_reference_id' => NULL);
        $receipt  = new Receipt(implode('|', $expected));
        $receipt->validate();
    }

    public function testSuccessTransaction()
    {
        $expected = array('transaction_id' => 'TX_1403351950', 'status_code' => '2', 'status_description' => 'Insufficient balance in your eZ Cash account.', 'transaction_amount' => '20.00', 'merchant_code' => 'TESTMERCHANT', 'wallet_reference_id' => NULL);
        $receipt  = new Receipt(implode('|', $expected));
        $receipt->validate();
    }

    public function testGettersSetters()
    {
        $expected = array('transaction_id' => 'TX_1403351950', 'status_code' => '2', 'status_description' => 'Insufficient balance in your eZ Cash account.', 'transaction_amount' => '20.00', 'merchant_code' => 'TESTMERCHANT', 'wallet_reference_id' => '123');
        $r  = new Receipt(implode('|', $expected));
        
        $this->assertEquals('TX_1403351950', $r->getTransactionId());
        $this->assertEquals('2', $r->getStatusCode());
        $this->assertEquals('Insufficient balance in your eZ Cash account.', $r->getStatusDescription());
        $this->assertEquals('20.00', $r->getTransactionAmount());
        $this->assertEquals('TESTMERCHANT', $r->getMerchantCode());
        $this->assertEquals('123', $r->getWalletReferenceId());

    }
}