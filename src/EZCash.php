<?php
/**
 * Factory class for package
 */
namespace SZ\EZCash;

use SZ\EZCash\Key\PrivateKey;
use SZ\EZCash\Key\PublicKey;

class EZCash
{
    protected $endpoint = 'https://ipg.dialog.lk/ezCashIPGExtranet/servlet_sentinal';
    
    /**
     * Path to public key file
     * @var string
     */
    protected $public_key;

    /**
     * Path to private key file
     * @var string
     */
    protected $private_key;

    public function __construct($public_key, $private_key)
    {
        $this->public_key  = new PublicKey($public_key);
        $this->private_key = new PrivateKey($private_key);
    }

    public function getEndpoint()
    {
        return $endpoint;
    }

    /**
     * Make and get encrypted invoice using parameter array
     * @param  array  $params ['transaction' => '', 'amount' => '20.00', 'url' => 'http://']
     * @return string
     */
    public function getInvoice(array $params)
    {
        $req = new Request;
        $req->setMerchantCode($params['merchant']);
        $req->setTransactionId($params['transaction_id']);
        $req->setAmount($params['amount']);
        $req->setReturnUrl($params['url']);

        $c = new Crypter;
        $c->setKey($this->public_key);
        
        return $c->process($req);
    }

    public function getInvoiceForm()
    {

    }

    public function getReceipt($response)
    {
        $res     = new Response($response);
        $c       = new Crypter;
        $c->setKey(new PrivateKey('mypublicKey.key'));
        
        $data    = $c->process($req);
        $receipt = new Receipt($data);
        $receipt->validate();

        return $receipt;
    }
}