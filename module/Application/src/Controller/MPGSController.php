<?php

declare(strict_types=1);

namespace Application\Controller;

use Laminas\Mvc\Controller\AbstractActionController;

class MPGSController extends AbstractActionController
{
    private $gatewayUrl = "";
    private $version = "";
    private $merchantId = "";
    private $password = "";
    private $apiUsername = "";
    private $returnUrl = "";

    /*
	 The constructor takes a config array. The structure of this array is defined 
	 at the top of this page.
	*/
    function __construct($configArray)
    {
        if (array_key_exists("gatewayUrl", $configArray))
            $this->gatewayUrl = $configArray["gatewayUrl"];

        if (array_key_exists("version", $configArray))
            $this->version = $configArray["version"];

        if (array_key_exists("merchantId", $configArray))
            $this->merchantId = $configArray["merchantId"];

        if (array_key_exists("password", $configArray))
            $this->password = $configArray["password"];

        if (array_key_exists("apiUsername", $configArray))
            $this->apiUsername = $configArray["apiUsername"];

        if (array_key_exists("returnUrl", $configArray))
            $this->returnUrl = $configArray["returnUrl"];

        if (array_key_exists("orderId", $configArray))
            $this->orderId = $configArray["orderId"];

        if (array_key_exists("amount", $configArray))
            $this->amount = $configArray["amount"];

        if (array_key_exists("currency", $configArray))
            $this->currency = $configArray["currency"];
    }

    // get methods to return a specific value
    public function getGatewayUrl()
    {
        return $this->gatewayUrl;
    }
    public function getVersion()
    {
        return $this->version;
    }
    public function getMerchantId()
    {
        return $this->merchantId;
    }
    public function getPassword()
    {
        return $this->password;
    }
    public function getApiUsername()
    {
        return $this->apiUsername;
    }
    public function getReturnUrl()
    {
        return $this->returnUrl;
    }
    public function getOrderId()
    {
        return $this->orderId;
    }
    public function getOrderAmount()
    {
        return $this->amount;
    }
    public function getOrderCurrency()
    {
        return $this->currency;
    }

    // Set methods to set a value
    public function SetGatewayUrl($newGatewayUrl)
    {
        $this->gatewayUrl = $newGatewayUrl;
    }
    public function SetVersion($newVersion)
    {
        $this->version = $newVersion;
    }
    public function SetMerchantId($merchantId)
    {
        $this->merchantId = $merchantId;
    }
    public function SetPassword($password)
    {
        $this->password = $password;
    }
    public function SetApiUsername($apiUsername)
    {
        $this->apiUsername = $apiUsername;
    }
    public function SetReturnUrl($returnUrl)
    {
        $this->returnUrl = $returnUrl;
    }
    public function SetOrderId($orderId)
    {
        $this->orderId = $orderId;
    }
    public function SetOrderAmount($amount)
    {
        $this->amount = $amount;
    }
    public function SetOrderCurrency($currency)
    {
        $this->currency = $currency;
    }

    public function createCheckoutSession()
    {
        $return = false;
        $curlUrl = $this->getGatewayUrl() . $this->getVersion();
        $curlPostFields = http_build_query([
            'apiOperation' => "CREATE_CHECKOUT_SESSION",
            'apiPassword' => $this->getPassword(),
            'apiUsername' => "merchant." . $this->getApiUsername(),
            'merchant' => $this->getMerchantId(),
            'interaction.returnUrl' => $this->getReturnUrl(),
            'order.id' => $this->getOrderId(),
            'order.amount' => $this->getOrderAmount(),
            'order.currency' => $this->getOrderCurrency(),
        ]);
        $headers = [];
        $headers[] = 'Content-Type: application/x-www-form-urlencoded';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $curlUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        //curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // this should be set to true in production
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $curlPostFields);

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);

        if (curl_errno($ch)) {
            echo "ERROR: " . curl_error($ch);
        } else {
            parse_str($result, $output);
            $return = $output;
        }
        curl_close($ch);

        return $return;
    }
}
