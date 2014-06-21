<?php
namespace SZ\EZCash;

use InvalidArgumentException;

class Request implements Cryptable
{
    /**
     * The merchant code provided by dialog
     * for testing use TESTMERCHANT
     * @var string
     */
    protected $merchant_code;

    /**
     * The unique transaction id to send, dialog will do a unique check
     * @var string
     */
    protected $transaction_id;

    /**
     * Amount to charge.
     * @var string|int
     */
    protected $amount;

    /**
     * Return URL, dialog will return the customer with a
     * POST request to this URL
     * @var string
     */
    protected $url;


    public function setMerchantCode($code)
    {
        $this->merchant_code = $code;
        return $this;  
    }

    public function setTransactionId($id)
    {
        $this->transaction_id = $id;
        return $this;
    }

    /**
     * Set amount
     * @param integer|string $amount should be a valid payment, xxxx.xx format
     */
    public function setAmount($amount)
    {
        $matched = array();
        if (!preg_match('/^\d+(\.\d{1,2})?$/', $amount, $matched)) {
            throw new InvalidArgumentException('Amount should be a valid payment value, valid format XXXXXX.XX');
        }

        $this->amount = array_shift($matched);
        return $this;
    }

    public function setReturnUrl($url)
    {
        if (filter_var($url, FILTER_VALIDATE_URL) === false) {
            throw new InvalidArgumentException('Invalid return url');
        }

        $this->url = $url;
        return $this;
    }

    public function getCryptableData()
    {
        $values    = get_object_vars($this);
        $non_empty = array_filter($values, 'strlen');

        if ($empty_array = array_diff_key($values, $non_empty)) {
            $empty_keys = implode(', ', array_keys($empty_array));
            throw new InvalidArgumentException("{$empty_keys} should not be null");
        }

        $data   = array();
        $data[] = $this->merchant_code;
        $data[] = $this->transaction_id;
        $data[] = $this->amount;
        $data[] = $this->url;

        return implode('|', $data);
    }
}