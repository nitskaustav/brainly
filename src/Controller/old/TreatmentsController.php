<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Core\Configure;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use Cake\ORM\TableRegistry;
use Cake\Datasource\ConnectionManager;

 
/**
 * Customers Controller
 *
 * @property \App\Model\Table\CustomersTable $Customers
 */
/*
 * Frontend treatment Management
 * 
 */
class TreatmentsController extends AppController {

    public function initialize() {
        parent::initialize();
        $this->Auth->allow(['treatmentdetail', 'medicinedetail','treatmentprice','cart','deletefromcart', 'addtocart', 'deletecart','allprices']); 
    }    
    
    
    public function exdetail() {
        
        $this->loadModel('Treatments');
        //$this->viewBuilder()->layout('admin');
        $treatment = $this->paginate($this->Treatments,['limit' => 10, 'conditions' => ['Treatments.parent_id' => 0]]);
        $this->set(compact('treatment'));
        $this->set('_serialize', ['treatment']);        

    }

    // Treatment Details with Medicines and Questions
    public function treatmentdetail($slug = null, $datap = null) {

        $this->loadModel('Treatments');
        $this->loadModel('TreatmentQuestions');
        $this->loadModel('QuestionCheckboxes');
        $this->loadModel('Medicines');
        $this->loadModel('Orders');
        $this->loadModel('Orderdetails');
        $this->loadModel('Pilprices');
        $this->loadModel('Pils');
               
        $treatment = $this->Treatments->find()
                                      ->contain(['Medicines' => function($q) {
                                            return $q->where(['Medicines.is_active' => '1']); }])
                                      ->contain(['Categories','Medicines.Pils' => ['sort' => ['Pils.title' => 'ASC']],'Medicines.Pils.Pilprices','TreatmentQuestions','TreatmentQuestions.Questions','TreatmentQuestions.Questions.QuestionCheckboxes'])
                                      ->where(['Treatments.slug' => $slug])
                                      ->first()->toArray();

        $questionlistarr = $this->TreatmentQuestions->find()
                        ->hydrate(false)
                        ->where(['TreatmentQuestions.tid' => $treatment['id']])
                        ->contain(['Questions' => function($q) { return $q->select(); }])->toArray();
            
                        
        //pr($questionlistarr); //exit;                
                        
        $questionlist = array();
        $i = 1;
        foreach($questionlistarr as $qla){
            //pr($qla); exit;
            $questionlist[$i]['id'] = $qla['Questions']['id'];
            $questionlist[$i]['question'] = $qla['Questions']['question'];
            $questionlist[$i]['answer'] = $qla['Questions']['answer'];
            $questionlist[$i]['note'] = $qla['Questions']['note'];
            $questionlist[$i]['warning'] = $qla['Questions']['warning'];
            $questionlist[$i]['answer_type'] = $qla['Questions']['answer_type'];
            $questionlist[$i]['valcheck'] = $qla['valcheck'];
            $questionlist[$i]['is_active'] = $qla['Questions']['is_active'];
            if($qla['Questions']['answer_type'] != "y"){
                $valconid = $qla['Questions']['id'];
                $questionlist[$i]['checkboxlist'] = $this->QuestionCheckboxes->find('all')
                                                                                  ->hydrate(false)
                                                                                  ->where(['QuestionCheckboxes.qid' => $valconid])->toArray();
            }
            $i ++;
        }
        
        
        //pr($questionlist); exit; 
        
        if($this->request->session()->check('Auth.User')){
            $uid = $this->request->session()->read('Auth.User.id');
            $orderExist = $this->Orders->find()->contain(['Orderdetails'])->where(['Orders.user_id' => $uid,'Orders.treatment_id' => $treatment['id'],'Orders.is_complete' => 0])->first();
        } else {
            $curIp = $_SERVER['REMOTE_ADDR'];
            $orderExist = $this->Orders->find()->contain(['Orderdetails'])->where(['Orders.client_ip' => $curIp,'Orders.treatment_id' => $treatment['id'],'Orders.is_complete' => 0])->first();
        }

        $SiteSettings = $this->site_setting();
        
        if ($this->request->is('post')) {
              //pr($this->request->data); 
              $question = array();
              for($cnt = 1; $cnt < $this->request->data['count']; $cnt++){
                  if( isset($this->request->data['checkbox'.$cnt]) && $this->request->data['field'.$cnt] == "checkbox"){
                      $question[$cnt]['q'] = $this->request->data['fieldq'.$cnt];
                      $question[$cnt]['a'] = $this->request->data['checkbox'.$cnt];
                  } else {
                    $question[$cnt]['q'] = $this->request->data['field'.$cnt];
                    if(isset($this->request->data['isread'.$cnt]) && $this->request->data['isread'.$cnt] == 0){
                        $question[$cnt]['a'] = "No";
                    } else if(isset($this->request->data['isread'.$cnt]) && $this->request->data['isread'.$cnt] == 1){
                      $question[$cnt]['a'] = "Yes";
                    }                      
                  }
              }
            $orderTable = TableRegistry::get('Orders');
            $order = $orderTable->newEntity();
            if($this->request->session()->check('Auth.User') == true){
                
                $pfees = $this->site_setting();
                $order->is_login = 1;
                $order->client_ip = $_SERVER['REMOTE_ADDR'];
                $order->user_id = $this->Auth->user('id'); 
                $order->name = $this->Auth->user('first_name')." ".$this->Auth->user('last_name');
                $order->email = $this->Auth->user('email');
                $order->contact = $this->Auth->user('phone');
                $order->billing_address = $this->Auth->user('address');
            } else {
                $order->is_login = 0;
                $order->client_ip = $_SERVER['REMOTE_ADDR'];
                $order->user_id = 0;
                $order->name = "";
                $order->email = "";
                $order->contact = "";
                $order->billing_address = "";
            }            
            $order->prescription_fee = $this->request->data['prescription_fee'];
            $order->treatment_id = $this->request->data['treatment_id'];	
            $order->question = json_encode($question);
            $order->date = gmdate('Y-m-d H:i:s');
            $order->is_active = 1;
            
            //pr($order); exit;
            if ($orderTable->save($order)) {
                $id = $order->id;
                $this->Cookie->config(['expires' => '+30 days', 'httpOnly' => true]); 

            }
            return $this->redirect(['action' => 'treatmentprice', $treatment['slug'],  base64_encode($id)]);
        }         

        foreach($treatment['Medicines'] as $trMed){
            foreach($trMed['pils'] as $trPilList){
                $trPils[] = $trPilList;
            }
        }
        
        
        //pr($treatment); exit;
        //pr($this->params); exit; 
        
        $pageSeo['site_meta_title'] = $treatment['meta_title'];
        $pageSeo['site_meta_description'] = $treatment['meta_description'];
        $pageSeo['site_meta_key'] = $treatment['meta_key'];        
        
        $this->set(compact('treatment','questionlist','orderExist','trPils','pageSeo','datap'));
        $this->set('_serialize', ['treatment']);        
    }   
    
    //Pills price list for treatments
    
    public function treatmentprice($slug = null, $orderid = null, $update = null) {
        
        $this->loadModel('Treatments');
        $this->loadModel('Orders');
        $this->loadModel('Orderdetails');
        $this->loadModel('Medicines');
        $this->loadModel('Pils');

        if ($this->request->is('post')) {
            //pr($this->request->data); exit; 
            if(!empty($this->request->data)){
                if($update != ''){
                    $oldOrderList = $this->Orders->get(base64_decode($orderid) , ['contain' => ['Orderdetails']])->toArray();
                    foreach($oldOrderList['orderdetails'] as $delOrd){
                        $orderdetaildt = $this->Orderdetails->get($delOrd['id']);
                        $this->Orderdetails->delete($orderdetaildt);
                    }                 
                }

                if(!empty($this->request->data['checkbox'])){       
                    foreach($this->request->data['checkbox'] as $k=>$v){
                        $dt =  explode("|,|", $v);
                        $ordid = $dt[0];
                        //pr($dt); exit;
                        $orderdetailTable = TableRegistry::get('Orderdetails');
                        $orderdetail = $orderdetailTable->newEntity();                
                        $orderdetail->ord_id = $dt[0];
                        $orderdetail->treatment_id = $dt[1];
                        $orderdetail->medicine_id = $dt[2];
                        $orderdetail->pil_id = $dt[3];
                        $orderdetail->pil_name = $dt[4];
                        $orderdetail->pil_qty = $dt[5];
                        $orderdetail->pil_price = $dt[6];
                        if ($orderdetailTable->save($orderdetail)) {
                            $id = $orderdetail->id;
                        }                
                    }
                    
                    $tableRegObj = TableRegistry::get('Orders');
                    $query = $tableRegObj->query();
                    $query->update()->set(['is_cart' => 1])->where(['id' => $ordid])->execute();                    
                }
                return $this->redirect(['action' => 'cart']);     
            } else {
                $this->Flash->error(__('Please Select Pil.'));
            }
        }

        $treatment = $this->Treatments->find()
                                      ->contain(['Categories', 'Medicines','Medicines.Pils','TreatmentQuestions','TreatmentQuestions.Questions','TreatmentQuestions.Questions.QuestionCheckboxes'])
                                      ->where(['Treatments.slug' => $slug])
                                      ->first()->toArray();

        $order_id = base64_decode($orderid);            
        $medicine_list = $treatment['Medicines'];
        $medicine = array();
        $ik = 1;
        foreach($medicine_list as $mlist){
            $pil = $this->Pils->find()->hydrate(false)->where(['Pils.mid' => $mlist['id']])->toArray();            
            if(!empty($pil)){
                $medicine[$ik]['Mediciine']['id'] = $mlist['id'];
                $medicine[$ik]['Mediciine']['title'] = $mlist['title'];
                $medicine[$ik]['Pils'] = $pil;
            }
            $ik++;
        }
        
        if($update != ''){
            $order = $this->Orders->get($order_id , ['contain' => ['Orderdetails']])->toArray();
            $inOrder = array(); $totAmt = 0;
            foreach($order['orderdetails'] as $orddt){ $inOrder[] = $orddt['pil_id']; $totAmt = $totAmt + $orddt['pil_price']; }
        } else {
            $totAmt = 0.00;
        }       

        $this->set(compact('treatment','questionlist','order_id','medicine','order','inOrder','update','totAmt'));
        $this->set('_serialize', ['treatment']);         
    }     
    
    
    
    // Medicines details page
    public function medicinedetail($slug = null) {
        
        $this->loadModel('Medicines');
        $this->loadModel('MedicineQuestions');
        $this->loadModel('QuestionCheckboxes');
        $this->loadModel('Orders');
        $this->loadModel('Orderdetails');
        $this->loadModel('Treatments');
        $this->loadModel('Pilprices');
        $this->loadModel('Pils');
        $this->loadModel('Reviews');
        
        $mData = $this->Medicines->find()->where(['Medicines.slug' => $slug])->toArray();
        //echo $mData[0]->id; pr($mData); exit;
        $medicine = $this->Medicines->get($mData[0]->id , ['contain' => ['Treatment','Pils' => ['sort' => ['Pils.title' => 'ASC']],'Pils.Pilprices']])->toArray();          
        $treatmentdata = $this->Treatments->get($medicine['Treatments']['id'] , ['contain' => ['Medicines']])->toArray();
        
        //pr($medicine); 
        
        $review = $this->Reviews->find()
                    ->select(['id','rate','is_active'])
                    ->where([ 'medicines LIKE' => '%' . $medicine['id'] . '%', 'is_active' => 1 ])  
                    ->all()->toArray();        
        
        //pr($review); exit;
        
        $pageSeo['site_meta_title'] = $medicine['meta_title'];
        $pageSeo['site_meta_description'] = $medicine['meta_descriptiion'];
        $pageSeo['site_meta_key'] = $medicine['meta_key'];
        
        
        
        $this->set(compact('medicine','treatmentdata','review','pageSeo'));
        $this->set('_serialize', ['medicine']);        
    }     
    
    // Users cart. Showing saved details
    public function cart() {
        
        if ($this->request->session()->check('Auth.Doctor')) {
            $this->Flash->error('Please Login as Patient.');//Checking if user is a doctor
            return $this->redirect('/'); 
        }        
        
        
        $this->loadModel('Treatments');
        $this->loadModel('Orders');
        $this->loadModel('Orderdetails');
        $this->loadModel('Medicines');
        $this->loadModel('Pils');
        $is_login = '';
        if($this->request->session()->check('Auth.User')){
            $is_login = 1;
            $uid = $this->request->session()->read('Auth.User.id');
            $orderExist = $this->Orders->find()->contain(['Treatments','Orderdetails','Orderdetails.Medicines'])->where(['Orders.user_id' => $uid,'Orders.is_complete' => 0])->all();
        } else {
            $is_login = 0;
            $curIp = $_SERVER['REMOTE_ADDR'];//Finding Cart by IP for temporary cart
            $orderExist = $this->Orders->find()->contain(['Treatments','Orderdetails','Orderdetails.Medicines'])->where(['Orders.client_ip' => $curIp,'Orders.is_login' => 0, 'Orders.is_complete' => 0])->all();
        }

        $cartData = $orderExist->toArray();
        //pr($cartData); exit;
        if(empty($cartData)){
            $this->Flash->error('Your Cart is empty.');
            return $this->redirect('/'); 
        }
        
        
        
        $this->set(compact('orderExist','cartData','is_login'));
        $this->set('_serialize', ['cartData']);         
        
    }     
    
    // Delete from cart
    public function deletecart($ordid = null) {
        $this->loadModel('Orders');
        $this->loadModel('Orderdetails');
        $id = base64_decode($ordid);
        $order = $this->Orders->get($id);
        if ($this->Orders->delete($order)) {
            $this->Orderdetails->query()->delete()->where(['ord_id' => $id])->execute();          
            $this->Flash->success(__('Cart Item has been deleted.'));
        } else {
            $this->Flash->error(__('Cart Item could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'cart']);         
    }     
    
    public function deletecartdetail($ordid = null) {
        $this->loadModel('Orders');
        $this->loadModel('Orderdetails');
        //$id = base64_decode($ordid);
        $orderdetail = $this->Orderdetails->get($ordid);
        if ($this->Orderdetails->delete($orderdetail)) {
            $this->Orderdetails->query()->delete()->where(['id' => $ordid])->execute();          
            $this->Flash->success(__('Cart Item has been deleted.'));
        } else {
            $this->Flash->error(__('Cart Item could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'cart']);         
    }
    
    
  
    
    
    
    
    //Add Medicines in Cart
    public function addtocart() {
        
        $this->viewBuilder()->layout('');
        //pr($_POST); exit;
        
        
        $session = $this->request->session();
        
        
        //$session->write('mycart','');
        //$session->write('amount','');
        
        $precart = $session->read('mycart');
        
        if(!empty($precart)){
            $cartData['tid'] = $_POST['tid'];
            $cartData['mid'] = $_POST['mid'];
            $cartData['pid'] = $_POST['pid'];
            $cartData['qt'] = $_POST['qt'];
            $cartData['price'] = $_POST['price'];
            $precart[$_POST['pid']]=$cartData;
            //pr($precart); exit;
            $toprice = 0; foreach($precart as $crt){ $toprice = $toprice + $crt['price']; }

            //array_merge($precart,$cartData);
            $session->write('mycart',$precart);
            $session->write('amount',$toprice);
            echo count($precart)."-".$toprice; exit;
        } else {
            $cartData1['tid'] = $_POST['tid'];
            $cartData1['mid'] = $_POST['mid'];
            $cartData1['pid'] = $_POST['pid'];
            $cartData1['qt'] = $_POST['qt'];
            $cartData1['price'] = $_POST['price'];     
            
            $cartData[$_POST['pid']] = $cartData1;
            $session->write('mycart',$cartData);
            $session->write('amount',$_POST['price']);
            echo "1-".$_POST['price']; exit;
        }
        
        
        //pr($session->read('mycart')); exit;
        $this->autoRender = false;
    }    
    
    
    public function deletefromcart() {
        $this->viewBuilder()->layout('');
        //pr($_POST); exit;
        $session = $this->request->session();
        $precart = $session->read('mycart');
        unset($precart[$_POST['pid']]);
        if(!empty($precart)){
            $toprice = 0; foreach($precart as $crt){ $toprice = $toprice + $crt['price']; }
            $cnt = count($precart);
            $session->write('mycart',$precart);
            $session->write('amount',$toprice);            
            echo $cnt."-".$toprice; exit;
        } else {
            echo "0-0.00"; exit;
        }
        $this->autoRender = false;
    }     
    
    // Price list of Medicines
    public function allprices() {
        $this->viewBuilder()->layout('default');
        
        
        $this->loadModel('Medicines');
        $this->loadModel('MedicineQuestions');
        $this->loadModel('QuestionCheckboxes');
        $this->loadModel('Orders');
        $this->loadModel('Orderdetails');
        $this->loadModel('Treatments');
        $this->loadModel('Pilprices');
        $this->loadModel('Pils');
        $this->loadModel('Reviews');        
        
        
        $treatment = $this->Treatments->find()
                                      ->select(['id','name','slug'])
                                      ->contain(['Pils' => function($q) { return $q->select(['Pils.id','Pils.tid','Pils.title','Pils.quantity','Pils.cost']); }])
                                      ->where(['Treatments.is_active' => 1])
                                      ->all()->toArray();        

        //pr($treatment); exit;

        $this->set(compact('treatment'));
        $this->set('_serialize', ['treatment']);        
        
        
    } 
    
}