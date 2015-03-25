EZCash
======
Easy to use PHP Client for Dialog EZCash implementation. Compatible with PHP 5.3+. Unit tests are available under `tests/`, run `phpunit`

More info - http://www.ezcash.lk/

### Installing
Package can be installed via composer.

###Install Composer
```bash
curl -sS https://getcomposer.org/installer | php
```

Next, update your project's composer.json file to include EZCash:

```javascript
{
    "require": {
        "sahanh/ezcash": "~1.0"
    }
}
```

After installing, you need to require Composer's autoloader:

```php
require 'vendor/autoload.php';
```
### Prerequisites
Once signed up with EZCash, Dialog will provide 2 keys for data encryption and decryption. You'll need these 2 keys to process transactions through the gateway.

PHP Client requires openssl extesion.

### Transaction Flow
Generate a Form (Submit) -> Process Transaction at Dialog -> Redirected to our site

### Create Transaction Request
Transaction request is done by using a HTML form, an encrypted data about the transaction is stored as `invoice` and submmited to `https://ipg.dialog.lk/ezCashIPGExtranet/servlet_sentinal`. Dialog will process the transaction and redirect user back to our site with some details.

```php
use SZ\EZCash\EZCash;

//create a new EZCash instace by prvoding the key files.
$ez = new EZCash(__DIR__.'/keys/publicKey.key', __DIR__.'/keys/myprivateKey.key');

$params = array(
    'merchant'       => 'TESTMERCHANT', //id of the merchant
    'transaction_id' => 'TX_6729', //id for the transaction, typically an invoice id
    'amount'         => '100.00', //amount
    'url'            => 'http://mysite.com/process.php' //url to redirect after processing
);

//form (simple form with a submit button)
echo $ez->getInvoiceForm($params);
```

To use with a custom form use `getInvoice` to generate encrypted invoice and use it with a hidden field called `"invoice"`
```php
//get the encrypted transaction data to use in form field
$invoice = $ez->getInvoice($params);
```

    <input type="hidden" name="invoice" value="<?php echo $invoice; ?>" />

### Get Merchant Receipt

Once the transaction processing is complete Dialog will redirect user to the url provided when creating the transaction. The result of the transaction is included along with the redirect as `merchantReciept` form field. If the transaction status is under "failed", client will throw an InvalidTransactionException.

```php
use SZ\EZCash\EZCash;
use SZ\EZCash\Exception\InvalidTransactionException;
use SZ\EZCash\Exception\EZCashException;

//create a new EZCash instace by prvoding the key files.
$ez = new EZCash(__DIR__.'/keys/publicKey.key', __DIR__.'/keys/myprivateKey.key');

try {

    $receipt = $ez->getReceipt($_POST['merchantReciept']);
    print_r($receipt->toArray());

} catch (InvalidTransactionException as $e) {

    echo $e->getMessage();

} catch (EZCashException as $e) {

    //Something went wrong, please retry

}
```

#### Receipt Object
The `Receipt` object (returned from `$ez->getReceipt($encrypted)`) has number of data associated with the purchase.
```php
echo $receipt->getTransactionId();
echo $receipt->getMerchantCode();
echo $receipt->getStatusDescription();
echo $receipt->getTransactionAmount();
echo $receipt->getWalletReferenceId();

print_r($receipt->toArray());
```

This is not an official client
