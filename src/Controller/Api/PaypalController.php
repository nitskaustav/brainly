<?php
//require_once (ROOT.'/vendor/paypal/vendor/autoload.php');
namespace App\Controller\Api;
use Cake\Event\Event;
use Cake\Network\Exception\UnauthorizedException;
use Cake\Utility\Security;
use Firebase\JWT\JWT;
use Cake\ORM\TableRegistry;
use Cake\Routing\Router;
use Cake\Mailer\Email;

use PayPal\Api\Amount; 
use PayPal\Api\FuturePayment; 
use PayPal\Api\Payer; 
use PayPal\Api\RedirectUrls; 
use PayPal\Api\Transaction;

class PaypalController extends AppController {

    public function initialize()
    {
        parent::initialize();
        $this->Auth->allow(['payment']);
        $this->loadComponent('RequestHandler');
    }
    
    public function payment()
    {
        //error_reporting(1);
        require_once (ROOT.'/vendor/paypal/vendor/autoload.php');
        //require_once (ROOT.'/vendor/paypal/vendor/bootstrap.php');
        //echo ROOT.'/vendor/paypal/vendor/autoload.php';
//        $apiContext =  new ApiContext(
//        new OAuthTokenCredential(
//                    'AbKYYcGj0JLuMliopXDIljj_5TLEjF4zCJWQbWg5NQdlc_SAe8hV1KsnPjTVPAcvBS00tm46sAO9ChnE',     // ClientID
//                    'EGR3_rsu5mD-HpEW-o5BTtlbn2WQbyHrr8G4wo00VRvlFwXrky_w1cssKHrf-8lbcLnft8rgObdSKpGV'      // ClientSecret
//                )
//        );
//        $apiContext->setConfig(
//        array(
//            'mode' => 'sandbox',
//            'log.LogEnabled' => true,
//            'log.FileName' => '../PayPal.log',
//            'log.LogLevel' => 'DEBUG', // PLEASE USE `INFO` LEVEL FOR LOGGING IN LIVE ENVIRONMENTS
//            'cache.enabled' => true,
//            // 'http.CURLOPT_CONNECTTIMEOUT' => 30
//            // 'http.headers.PayPal-Partner-Attribution-Id' => '123123123'
//            //'log.AdapterFactory' => '\PayPal\Log\DefaultLogFactory' // Factory class implementing \PayPal\Log\PayPalLogFactory
//        )
   // );
        $apiContext = new \PayPal\Rest\ApiContext(
        new \PayPal\Auth\OAuthTokenCredential(
            'AbKYYcGj0JLuMliopXDIljj_5TLEjF4zCJWQbWg5NQdlc_SAe8hV1KsnPjTVPAcvBS00tm46sAO9ChnE',     // ClientID
                    'EGR3_rsu5mD-HpEW-o5BTtlbn2WQbyHrr8G4wo00VRvlFwXrky_w1cssKHrf-8lbcLnft8rgObdSKpGV'      // ClientSecret
        )
);
        $apiContext->setConfig(
      array(
              'log.LogEnabled' => true,
    'log.FileName' => 'PayPal.log',
    'log.LogLevel' => 'FINE'
      )
);
        $payer = new Payer(); 
        $payer->setPaymentMethod("paypal");
        
        $amount = new Amount(); 
        $amount->setCurrency("USD") ->setTotal("0.17");
        
        $transaction = new Transaction(); 
        $transaction->setAmount($amount) ->setDescription("Payment description");
        
        
        $redirectUrls = new RedirectUrls(); 
        $redirectUrls->setReturnUrl("https://developer.paypal.com/") 
                ->setCancelUrl("https://developer.paypal.com/");
        
        $payment = new FuturePayment(); 
        $payment->setIntent("authorize") 
                ->setPayer($payer) 
                ->setRedirectUrls($redirectUrls) 
                ->setTransactions(array($transaction));
        $authorizationCode = 'mock_code_EJhi9jOPswug9TDOv93qg4Y28xIlqPDpAoqd7biDLpeGCPvORHjP1Fh4CbFPgKMGCHejdDwe9w1uDWnjPCp1lkaFBjVmjvjpFtnr6z1YeBbmfZYqa9faQT_71dmgZhMIFVkbi4yO7hk0LBHXt_wtdsw';
        $clientMetadataId = '123123456';
        $refreshToken = FuturePayment::getRefreshToken($authorizationCode, $apiContext);
           // $payment->updateAccessToken($refreshToken, $apiContext);
            var_dump($refreshToken);
            exit;
        
        try
        {
            $refreshToken = FuturePayment::getRefreshToken($authorizationCode, $apiContext);
            $payment->updateAccessToken($refreshToken, $apiContext);
            $request = clone $payment;
            $payment->create($apiContext, $clientMetadataId);
            var_dump($payment);
        } catch (Exception $ex) {
           print_r($ex);
        }
        exit;
    }
}