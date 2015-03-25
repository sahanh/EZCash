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

    /**
     * Get API Endpoint URL
     * @return string
     */
    public function getEndpoint()
    {
        return $this->endpoint;
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

    /**
     * Generate a simple html form to submit
     * @param  array $params parameters for invoice
     * @return string
     */
    public function getInvoiceForm($params)
    {
        $url     = $this->getEndpoint();
        $invoice = htmlentities($this->getInvoice($params));

        return "<form action=\"{$url}\" method=\"POST\">
            <input type=\"hidden\" name=\"merchantInvoice\" value=\"{$invoice}\" />      
            <input type=\"submit\" />
        </form>";
    }

    /**
     * Get receipt object from an encrypted response
     * @param  string $response
     * @return Receipt
     */
    public function getReceipt($response)
    {
        $res     = new Response($response);
        $c       = new Crypter;
        $c->setKey($this->private_key);
        
        $data    = $c->process($res);
        $receipt = new Receipt($data);
        $receipt->validate();

        return $receipt;
    }
}
