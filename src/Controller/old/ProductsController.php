<?php
namespace App\Controller;
use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Core\Configure;
use Cake\Mailer\Email;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Api\ExecutePayment;
use PayPal\Api\PaymentExecution;


/**
 * Products Controller
 *
 * @property \App\Model\Table\ProductsTable $Products
 */
class ProductsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
        public function initialize() {
        parent::initialize();
        $this->Auth->allow(['index','payment',"success","successDb","cancell"]);
        $this->loadComponent('Paginator');
    }

    
    public function index(){
        $product = $this->Products->get(1, [
            'contain' => ["Productimages"]
        ]);
       // pr($product);exit;
        $this->set(compact('product','menus',"doctors"));
        $this->set('_serialize', ['product','doctors']);
        
    }

    /**
     * View method
     *
     * @param string|null $id Product id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null){
        $product = $this->Products->get($id, [
            'contain' => ['Suppliers', 'Orderdetails']
        ]);

        $this->set('product', $product);
        $this->set('_serialize', ['product']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    

    /**
     * Edit method
     *
     * @param string|null $id Product id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null){
        $product = $this->Products->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $product = $this->Products->patchEntity($product, $this->request->data);
            if ($this->Products->save($product)) {
                $this->Flash->success(__('The product has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The product could not be saved. Please, try again.'));
            }
        }
        $suppliers = $this->Products->Suppliers->find('list', ['limit' => 200]);
        $this->set(compact('product', 'suppliers'));
        $this->set('_serialize', ['product']);
    }
    
    public function payment(){
        
        $this->loadModel("Users");
        $this->loadModel("Billings");
        $this->loadModel("Products");
        $this->loadModel("Orders");
        $product=$this->Products->find()->where(["id"=>1])->first();
        $user = $this->Users->newEntity();
        $billing = $this->Billings->newEntity();
        $order = $this->Orders->newEntity();
        if ($this->request->is(['patch', 'post', 'put'])) {
            $email=$this->request->data["email"];
            $userExist =  $this->Users->find()->where(['email' => $email])->first();
            if(!empty($userExist))
            {
            $user = $this->Users->patchEntity($userExist, $this->request->data);
            }
            else{
            $this->request->data['created'] = gmdate("Y-m-d h:i:s");
            $this->request->data['modified'] = gmdate("Y-m-d h:i:s"); 
            $this->request->data['utype'] = 1; 
            $this->request->data['password'] = 123456;     
            $user = $this->Users->patchEntity($user, $this->request->data);
            }
            try {
                
                $normaluser=$this->Users->save($user);
                $last_id=$normaluser->id;
                $billingExist =  $this->Billings->find()->where(['user_id' => $last_id])->first();
                $this->request->data["user_id"]=$last_id;
                if(!empty($billingExist))
                {
                $billing = $this->Users->patchEntity($billingExist, $this->request->data);
                }
                
                else
                {
                $billing = $this->Users->patchEntity($billing, $this->request->data);
                }
                $bill=$this->Billings->save($billing);
                $shipping_id=$bill->id;

                $this->request->data["client_ip"]=$ip= isset($_SERVER['HTTP_X_FORWARDED_FOR']) ? 
                $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR']; 
                $this->request->data["user_id"]=$last_id;
                $this->request->data["amt"]=$product["price"];
                $this->request->data["date"]= gmdate("Y-m-d H:i:s");
                $this->request->data["shipping_id"]= $shipping_id;
                $order = $this->Orders->patchEntity($order, $this->request->data);
                $currentorder=$this->Orders->save($order);
                require_once(ROOT .DS.'vendor/bootstrap.php');
                $last_orderid=$currentorder->id;
                $SITE_URL=Configure::read('SITEURL');
                $product_name = $product['title'];
                $product_price = $product["price"];
                $product_currency = "USD";
                // ### Payer
                // A resource representing a Payer that funds a payment
                // For paypal account payments, set payment method
                // to 'paypal'.
                $payer = new Payer();
                $payer->setPaymentMethod("paypal");

                // ### Itemized information
                // (Optional) Lets you specify item wise
                // information
                $item1 = new Item();
                $item1->setName($product_name)
                        ->setCurrency($product_currency)
                        ->setQuantity(1)
                        ->setPrice($product_price);

                $itemList = new ItemList();
                $itemList->setItems(array($item1));

                // ### Additional payment details
                // Use this optional field to set additional
                // payment information such as tax, shipping
                // charges etc.
                $details = new Details();
                $details->setShipping(0)
                        ->setTax(0)
                        ->setSubtotal($product_price);

                // ### Amount
                // Lets you specify a payment amount.
                // You can also specify additional details
                // such as shipping, tax.
                $amount = new Amount();
                $amount->setCurrency($product_currency)
                        ->setTotal($product_price)
                        ->setDetails($details);

                // ### Transaction
                // A transaction defines the contract of a
                // payment - what is the payment for and who
                // is fulfilling it. 
                $transaction = new Transaction();
                $transaction->setAmount($amount)
                        ->setItemList($itemList)
                        ->setDescription("Payment description")
                        ->setInvoiceNumber(uniqid());

                // ### Redirect urls
                // Set the urls that the buyer must be redirected to after 
                // payment approval/ cancellation.
                $baseUrl = getBaseUrl();
                $redirectUrls = new RedirectUrls();
                $redirectUrls->setReturnUrl($SITE_URL.'products/success_db/'.$last_orderid)
                             ->setCancelUrl($SITE_URL.'products/cancell/');

                // ### Payment
                // A Payment Resource; create one using
                // the above types and intent set to 'sale'
                $payment = new Payment();
                $payment->setIntent("sale")
                        ->setPayer($payer)
                        ->setRedirectUrls($redirectUrls)
                        ->setTransactions(array($transaction));


                // For Sample Purposes Only.
                $request = clone $payment;

    // ### Create Payment
    // Create a payment by calling the 'create' method
    // passing it a valid apiContext.
    // (See bootstrap.php for more on `ApiContext`)
    // The return object contains the state and the
    // url to which the buyer must be redirected to
    // for payment approval
    try {
        $payment->create($apiContext);
        
        
        
    } catch (Exception $ex) {
        
        
        print_r($ex);
       
        //ResultPrinter::printError("Created Payment Using PayPal. Please visit the URL to Approve.", "Payment", null, $request, $ex);
        exit(1);
    }

    // ### Get redirect url
    // The API response provides the url that you must redirect
    // the buyer to. Retrieve the url from the $payment->getApprovalLink()
    // method
    $approvalUrl = $payment->getApprovalLink();
    header('Location: ' . $approvalUrl);
    exit;
                
                
                
                
            } catch (Exception $ex) {
                
                print_r($ex);
                
            }
            
            
           
        }
        $this->set(compact('product', 'suppliers'));
        $this->set('_serialize', ['product']);
        
       
    }
    
    function  successDb($id=null)
    {
       require_once(ROOT .DS.'vendor/bootstrap.php');
       $this->loadModel("Orders");
       $this->loadModel("SiteSettings");
       $siteSettings=$this->SiteSettings->find()->where(["id"=>1])->first();
       $product=$this->Products->find()->where(["id"=>1])->first();
       $order=$this->Orders->find()->contain(['Users'])->where(["Orders.id"=>$id])->first();
       $paymentId = $_GET['paymentId'];
//       $payment = Payment::get($paymentId, $apiContext);
//       $execution = new PaymentExecution();
//       $execution->setPayerId($_GET['PayerID']);
//       $result = $payment->execute($execution, $apiContext);
//       $obj = json_decode($payment);
       $this->request->data["transaction_id"]=$paymentId;
       $this->request->data["is_paid"]=1;
       $order = $this->Orders->patchEntity($order, $this->request->data);
       $this->Orders->save($order);
       $mail_content="<p>Hello</p>";
       $mail_content.="<p>".$order->user->first_name.' '.$order->user->last_name."</p>";
       $mail_content.="<p>Your payment has been received successfully </p>";
       $mail_content.="<table style='width:100%'>";
       $mail_content.="<tr><td>Product</td><td>Quantity</td><td>Price</td></tr>";
       $mail_content.="<tr><td>".$product->title."</td><td>1</td><td>$".number_format($product->price, 2, ',', ' ')."</td></tr>";
       $mail_content.="<tr><td colspan=2>Total</td><td>$".number_format($product->price, 2, ',', ' ')."</td></tr>";
       $mail_content.="</table>";
       $mail_subject="Payment Confirmation";
       $email = new Email('default');
       $mail_To=$order->user->email;
       try {
           
           $email->emailFormat('html')->from(['info@perfectshade.com' => 'PerfectShade'])
        ->to($mail_To)
        ->subject($mail_subject)
        ->send($mail_content);  
       return $this->redirect(['controller' =>'products', 'action' => 'success']);
           
       } catch (Exception $ex) {
           print_r($ex);
           
       }
       
       
       exit;
       
       
       

       
    }
            
    
    
    function success($id=null)
    {
       
       

    }
    
    function cancell($id=null)
    {
       
       

    }
    

    /**
     * Delete method
     *
     * @param string|null $id Product id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null, $sid = null, $sname = null){
        $this->request->allowMethod(['post', 'delete']);
        $product = $this->Products->get($id);
        if ($this->Products->delete($product)) {
            $this->Flash->success(__('The product has been deleted.'));
        } else {
            $this->Flash->error(__('The product could not be deleted. Please, try again.'));
        }
        return $this->redirect(['controller' =>'suppliers', 'action' => 'productlist', $sid, $sname]);
    }
}
