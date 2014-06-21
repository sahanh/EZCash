<?php
/**
 * Factory class for package
 */
namespace SZ\EZCash;

class EZCash
{
    protected $endpoint = 'https://ipg.dialog.lk/ezCashIPGExtranet/servlet_sentinal';
    
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
        $req->setTransactionId($params['transaction']);
        $req->setAmount($params['amount']);
        $req->setReturnUrl($params['url']);

        $c = new Crypter;
        $c->setKey(new Publickey('mypublicKey.key'));
        
        return $c->process($req);
    }

    public function getInvoiceForm()
    {

    }

    public function getReceipt($response)
    {
        $res = new Response($response);
        $c = new Crypter;
        $c->setKey(new PrivateKey('mypublicKey.key'));
        
        $data = $c->process($req);
        
        return new Receipt($data);
    }
}