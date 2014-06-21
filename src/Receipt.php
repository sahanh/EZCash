<?php
namespace SZ\EZCash;

use SZ\EZCash\Exception\InvalidTransactionException;

class Receipt
{
    /**
     * Unique reference for the transaction
     * @var mixed
     */
    public $transaction_id;

    /**
     * Status of the requested transaction
     * @var int
     */
    public $status_code;

    /**
     * Status description
     * @var string
     */
    public $status_description;

    /**
     * Amount of the transaction
     * @var numeric
     */
    public $transaction_amount;

    /**
     * This is a unique value which is given from the eZ Cash 
     * system for each integrated application
     * @var string
     */
    public $merchant_code;

    /**
     * Unique reference number which is given from the eZ Cash 
     * system to the particular transaction
     * @var string
     */
    public $wallet_reference_id;

    public function __construct($receipt)
    {
        $this->parse($receipt);
    }

    public function getTransactionId()
    {
        return $this->transaction_id;
    }

    public function getStatusCode()
    {
        return $this->status_code;
    }

    public function getStatusDescription()
    {
        return $this->status_description;
    }

    public function getTransactionAmount()
    {
        return $this->transaction_amount;
    }

    public function getMerchantCode()
    {
        return $this->merchant_code;
    }

    public function getWalletReferenceId()
    {
        return $this->wallet_reference_id;
    }

    public function toArray()
    {
        return get_object_vars($this);
    }

    /**
     * Validate transaction using status
     */
    public function validate()
    {
        if ($this->status_code != 2)
            throw new InvalidTransactionException($this->status_description, $this->status_code);
    }

    /**
     * Decryted the recipt and assign values to the propreties
     * TX_1403351950|14|Insufficient balance in your eZ Cash account.|20.00|TESTMERCHANT
     * @param  string $receipt
     */
    protected function parse($receipt)
    {
        $data = explode('|', $receipt);

        $properties = array (
            0 => 'transaction_id',
                 'status_code',
                 'status_description',
                 'transaction_amount',
                 'merchant_code',
                 'wallet_reference_id'
        );

        foreach ($data as $index => $value) {
            
            if (isset($properties[$index]))
                $property = $properties[$index];
                $this->{$property} = $value;
        }
    }
}