<?php
namespace App\Controller\Api;
use Cake\Event\Event;
use Cake\Network\Exception\UnauthorizedException;
use Cake\Utility\Security;
use Firebase\JWT\JWT;
use Cake\ORM\TableRegistry;
use Cake\Routing\Router;
use Cake\Mailer\Email;
class ProductsController extends AppController
{
    public function initialize()
    {
        parent::initialize();
        $this->Auth->allow(['categories','addbike','bikeimageinsert','removeimage','listproduct','productdelete','bikedetails','bikeimagedetails','searchbike','bikeShowdetails','sendmessage','sendrequest','addwish','addgear','gearimageinsert','listgear','geardelete','geardetails','removegearimage','searchgear','gearShowdetails','addcart','cart','updatecart','removefromcart','addratingreview','orderlist','orderdetails','orderlistseller','orderdetailsseller','bikelisting','bikeresult','categorylisting','categorylisting']);
        $this->loadComponent('RequestHandler');
    }
    

    public function categories()
    {
        $this->loadModel('Categories');
        $this->loadModel('Models');
        $this->loadModel('Makes');
        $this->loadModel('Colours');
        $this->loadModel('EngineSizes');
        $this->loadModel('Sizes');
        $this->loadModel('Brands');
        
        $brands=$this->Brands->find()->where(['Brands.status'=>1])->toArray();
        $sizes=$this->Sizes->find()->where(['Sizes.status'=>1])->toArray();
        $categorys=$this->Categories->find()->where(['Categories.status'=>1])->toArray();
        $models=$this->Models->find()->where(['Models.status'=>1])->toArray();
        $makes=$this->Makes->find()->where(['Makes.status'=>1])->toArray();
        $colours=$this->Colours->find()->where(['Colours.status'=>1])->toArray();
        $engins=$this->EngineSizes->find()->where(['EngineSizes.status'=>1])->toArray();

        $this->set([
                'category' => $categorys,
                'model' => $models,
                'make' => $makes,
                'colour' => $colours,
                'engin' => $engins,
                'size' => $sizes,
                'link'=>Router::url('/', true).'category_img/',
                'brand' => $brands,
                '_serialize' => ['category','model','make','colour','engin','size','brand','link']
            ]);
    }


public function addbike()
{
    $this->loadModel('Products');
        
        //print_r($this->request->data);exit;
        $product = $this->Products->newEntity();
        
            $tableRegObj = TableRegistry::get('Products');
           
                  //$this->request->data['seller_id']=$id;                 
                
                $product = $this->Products->patchEntity($product, $this->request->data);
                if ($rs=$this->Products->save($product)) {                 
                    //$this->redirect(['action' => 'addproduct2/'.$rs->id]);
                     $this->set([
                'id' => $rs->id,
                'ack' => 1,
                'message' => 'bike added',
                '_serialize' => ['id','ack','message']
            ]);
                }
                else
                {
                     $this->set([
                'id' =>'',
                'ack' => 0,
                'message' => 'bike not added',
                '_serialize' => ['id','ack','message']
            ]);
                }
        
}
  

public function addgear()
{
    $this->loadModel('Gears');
    $this->loadModel('Gearsimages');
        
        //print_r($this->request->data);exit;
        $product = $this->Gears->newEntity();
        
            $tableRegObj = TableRegistry::get('Gears');
           
                  //$this->request->data['seller_id']=$id;     
                  $gearimage = $this->request->data['image']; 
                  unset($this->request->data['image']) ;   
                  if($gearimage)
                  {

                    $this->request->data['upload'] = $gearimage[0];
                  }       
                $this->request->data['colour_id'] = implode(",",$this->request->data['colour_id']);
                $product = $this->Gears->patchEntity($product, $this->request->data);
                if ($rs=$this->Gears->save($product)) {



                if($gearimage)
                {
                  foreach($gearimage as $img)
                  {

                   // print_r($rs->id);exit;
                    $value['gear_id'] = $rs->id;
                    $value['name'] = $img;
                    $geariamge = $this->Gearsimages->newEntity();
                     $geariamge = $this->Gearsimages->patchEntity($geariamge, $value);
                     $ty = $this->Gearsimages->save($geariamge);
                     //print_r($ty);exit;
                  }
                }                 
                    //$this->redirect(['action' => 'addproduct2/'.$rs->id]);
                     $this->set([
                'id' => $rs->id,
                'ack' => 1,
                'message' => 'bike added',
                '_serialize' => ['id','ack','message']
            ]);
                }
                else
                {
                     $this->set([
                'id' =>'',
                'ack' => 0,
                'message' => 'bike not added',
                '_serialize' => ['id','ack','message']
            ]);
                }
        
}



public function sendmessage()
{
    $this->loadModel('Messages');
        $this->loadModel('EmailTemplates');
        $this->loadModel('Products');
        //print_r($this->request->data);exit;
      $product = $this->Products->find()->where(['Products.id'=>$this->request->data['prod_id']])->toArray();
       // print_r($product);exit;
        $message = $this->Messages->newEntity();
        
            $tableRegObj = TableRegistry::get('Messages');
           
                  //$this->request->data['seller_id']=$id;                 
                
                $message = $this->Messages->patchEntity($message, $this->request->data);
                if ($rs=$this->Messages->save($message)) {   
//print_r($this->request->data['prod_id']);exit;
//$product = $this->Products->find()->where(['Products.id' => $this->request->data['prd_id']])->first();
//$product = $this->Products->find()->where(['Products.id'=>$this->request->data['prd_id']])->first();
//print_r($product);exit;
//$makes=$this->Makes->find()->where(['Makes.status'=>1])->toArray();

$etRegObj = TableRegistry::get('EmailTemplates');
            $emailTemp = $etRegObj->find()->where(['id' => 4])->first()->toArray();            
            $name = $this->request->data['name'];
            $emailfrom = $this->request->data['email'];
            $phone = $this->request->data['phone'];            
            $message = $this->request->data['message'];
            $mail_To = $product[0]['contact_email'];
         //   $mail_To = 'palash@natitsolved.com';
            $mailusername = 'Biketory';
            //$mail_CC = '';
            $mail_subject = $emailTemp['subject'];
            $url = Router::url('/', true);


            $mail_body = str_replace(array('[NAME]', '[EMAIL]', '[PHONE]', '[MESSAGE]'), array($name, $emailfrom, $phone, $message), $emailTemp['content']);
            //echo $mail_body; exit;


            $email = new Email('default');
            $email->emailFormat('html')->from([$emailfrom => $mailusername])
                    ->to($mail_To)
                    ->subject($mail_subject)
                    ->send($mail_body);


                    //$this->redirect(['action' => 'addproduct2/'.$rs->id]);
                     $this->set([
                'ack' => 1,
                'message' => 'bike added',
                '_serialize' => ['id','ack','message']
            ]);
                }
                else
                {
                     $this->set([
                'id' =>'',
                'ack' => 0,
                'message' => 'bike not added',
                '_serialize' => ['id','ack','message']
            ]);
                }
        
}



public function sendrequest()
{
  $this->loadModel('Requests');
        $this->loadModel('EmailTemplates');
        $this->loadModel('Products');
        //print_r($this->request->data);exit;
        $product = $this->Products->find()->contain(['Productsimages','Users','Bikemodels', 'Makes', 'Categories'])->where(['Products.id' => $this->request->data['prod_id']])->first();
       // print_r($product);exit;
        $request = $this->Requests->newEntity();
        
            $tableRegObj = TableRegistry::get('Requests');
           
                  //$this->request->data['seller_id']=$id;                 
                
                $request = $this->Requests->patchEntity($request, $this->request->data);
                if ($rs=$this->Requests->save($request)) {  
//echo $product->contact_email;exit;

$etRegObj = TableRegistry::get('EmailTemplates');
          $emailTemp = $etRegObj->find()->where(['id' => 4])->first()->toArray();            
          $name = $product->Users->first_name." ".$product->Users->last_name;
          $emailfrom = $product->Users->email;
          $phone = $product->Users->phone;            
          $message = "Product request";
          $mail_To = $product->contact_email;
          //$mail_To = 'kaustav@natitsolved.com';
          $mailusername = 'Biketory';
          //$mail_CC = '';
          $mail_subject = $emailTemp['subject'];
          $url = Router::url('/', true);


          $mail_body = str_replace(array('[NAME]', '[EMAIL]', '[PHONE]', '[MESSAGE]'), array($name, $emailfrom, $phone, $message), $emailTemp['content']);
          //echo $mail_body;die; 


          $email = new Email('default');
          $email->emailFormat('html')->from([$emailfrom => $mailusername])
                  ->to($mail_To)
                  ->subject($mail_subject)
                  ->send($mail_body);


                    //$this->redirect(['action' => 'addproduct2/'.$rs->id]);
                     $this->set([
                'ack' => 1,
                'message' => 'Request added',
                '_serialize' => ['id','ack','message']
            ]);
                }
                else
                {
                     $this->set([
                'id' =>'',
                'ack' => 0,
                'message' => 'Request not added',
                '_serialize' => ['id','ack','message']
            ]);
                }
}


public function addwish()
{
  
        $this->loadModel('Wishlists');
        
        $request = $this->Wishlists->newEntity();
        
            $tableRegObj = TableRegistry::get('Wishlists');
           
                       
                
                $request = $this->Wishlists->patchEntity($request, $this->request->data);
                if ($rs=$this->Wishlists->save($request)) {  

                     $this->set([
                'ack' => 1,
                'message' => 'Wish added',
                '_serialize' => ['id','ack','message']
            ]);
                }
                else
                {
                     $this->set([
                'id' =>'',
                'ack' => 0,
                'message' => 'Wish not added',
                '_serialize' => ['id','ack','message']
            ]);
                }
}

public function bikeimageinsert($id = null){
    $id = $this->request->data['bike_id'];
           $this->viewBuilder()->layout('false');
           $this->loadModel('Productsimages');

            if(!empty($_FILES['file']['name'])){
                $no_files = count($_FILES["file"]['name']);
                
                  if ($_FILES["file"]["error"] > 0) {
                      //echo "Error: " . $_FILES["file"]["error"] . "<br>";
                  } else {
                     $pathpart=pathinfo($_FILES["file"]["name"]);                    
                      $ext=$pathpart['extension'];          
                      $uploadFolder = "product_img/";
                      $uploadPath = WWW_ROOT . $uploadFolder;
                      $filename =uniqid().'.'.$ext;
                      $full_flg_path = $uploadPath . '/' . $filename;
                      if (move_uploaded_file($_FILES['file']['tmp_name'], $full_flg_path)) {
                        $data['product_id'] = $id;
                        $data['name'] = $filename;                           
                        $con = $this->Productsimages->newEntity();
                        $images = $this->Productsimages->patchEntity($con, $data);
                        if ($rs = $this->Productsimages->save($images)) {
                           $file = array('filename' => $filename, 'last_id' => $rs->id,'path' => Router::url('/', true).'product_img/'.$filename);
                                                                  
                        }                     
                        
                      } 
                      $bike_image = $this->Productsimages->find()->where(['Productsimages.product_id'=>$id]);
                       // $categorys=$this->Categories->find()->where(['Categories.status'=>1])->toArray();
                      if($bike_image)
                      {
                        $biks = [];
                        foreach($bike_image as $bkg)
                        {
                         // print_r($bkg);exit;
                          $biks[] = array('id'=>$bkg->id,'link'=>Router::url('/', true).'product_img/'.$bkg->name);
                        }
                      }
                      $file_details = $biks;

                  }
                  
                  //$product_images = $this->Productsimages->find()->where(['Productimages.product_id'=>$id])->toArray();
                  // if($product_images)
                  // {  $images = [];
                  //   foreach($product_images as $prdimg)
                  //   {
                  //       //$images[]= Router::url('/', true).'product_img/'.$prdimg['Productsimages']['name'];
                  //   }
                  // }
                  //$categorys=$this->Categories->find()->where(['Categories.status'=>1])->toArray();
              
                $data = array('Ack'=>1, 'data'=>$file_details );
                    
               }
               else {

                 $data = array('Ack'=> 0);
               }
               echo json_encode($data);
              exit();
       }



public function gearimageinsert($id = null){
    $id = $this->request->data['gear_id'];
           $this->viewBuilder()->layout('false');
           $this->loadModel('Gearsimages');

            if(!empty($_FILES['file']['name'])){
                $no_files = count($_FILES["file"]['name']);
                
                  if ($_FILES["file"]["error"] > 0) {
                      //echo "Error: " . $_FILES["file"]["error"] . "<br>";
                  } else {
                     $pathpart=pathinfo($_FILES["file"]["name"]);                    
                      $ext=$pathpart['extension'];          
                      $uploadFolder = "gear_img/";
                      $uploadPath = WWW_ROOT . $uploadFolder;
                      $filename =uniqid().'.'.$ext;
                      $full_flg_path = $uploadPath . '/' . $filename;
                      if (move_uploaded_file($_FILES['file']['tmp_name'], $full_flg_path)) {
                        if($id)
                        {

                        $data['gear_id'] = $id;
                        $data['name'] = $filename;                           
                        $con = $this->Gearsimages->newEntity();
                        $images = $this->Gearsimages->patchEntity($con, $data);
                        if ($rs = $this->Gearsimages->save($images)) {
                           $file = array('filename' => $filename, 'last_id' => $rs->id,'path' => Router::url('/', true).'gear_img/'.$filename);
                                                                  
                        }  

                         $bike_image = $this->Gearsimages->find()->where(['Gearsimages.gear_id'=>$id]);
                       // $categorys=$this->Categories->find()->where(['Categories.status'=>1])->toArray();
                      if($bike_image)
                      {
                        $biks = [];
                        foreach($bike_image as $bkg)
                        {
                         // print_r($bkg);exit;
                          $biks[] = array('id'=>$bkg->id,'link'=>Router::url('/', true).'gear_img/'.$bkg->name);
                        }
                      }

                        }
                        else{                  
                        $biks = array('name'=>$filename,'link'=>Router::url('/', true).'gear_img/'.$filename);
                      }
                      } 
                      else
                      {
                        $biks = 'not upload';
                      }
                      // $bike_image = $this->Productsimages->find()->where(['Productsimages.product_id'=>$id]);
                      //  // $categorys=$this->Categories->find()->where(['Categories.status'=>1])->toArray();
                      // if($bike_image)
                      // {
                      //   $biks = [];
                      //   foreach($bike_image as $bkg)
                      //   {
                      //    // print_r($bkg);exit;
                      //     $biks[] = array('id'=>$bkg->id,'link'=>Router::url('/', true).'product_img/'.$bkg->name);
                      //   }
                      // }
                      $file_details = $biks;

                  }
                  
              
                $data = array('Ack'=>1, 'data'=>$biks );
                    
               }
               else {

                 $data = array('Ack'=> 0);
               }
               echo json_encode($data);
              exit();
       }


  public function removeimage(){          
             $this->viewBuilder()->layout('false');
             $this->loadModel('Productsimages');
             $image = $this->Productsimages->get($this->request->data['id']);
             $id = $this->request->data('product_id');
            if ($this->Productsimages->delete($image)){ 
               $bike_image = $this->Productsimages->find()->where(['Productsimages.product_id'=>$id]);
                       // $categorys=$this->Categories->find()->where(['Categories.status'=>1])->toArray();
                      if($bike_image)
                      {
                        $biks = [];
                        foreach($bike_image as $bkg)
                        {
                         // print_r($bkg);exit;
                          $biks[] =array('id'=>$bkg->id,'link'=>Router::url('/', true).'product_img/'.$bkg->name);
                        }
                      }
                      $file_details = $biks;
             $data = array('Ack'=>1, 'data'=>$file_details );
            }
              else{
                 $data = array('Ack'=> 0);
              }
              echo json_encode($data);
              exit();
       }

 public function removegearimage(){          
             $this->viewBuilder()->layout('false');
             $this->loadModel('Gearsimages');

            // echo $this->request->data['id'];exit;
             $image = $this->Gearsimages->get($this->request->data['id']);
             $id = $this->request->data('gear_id');
             //echo $id;exit;
            if ($this->Gearsimages->delete($image)){ 
               $bike_image = $this->Gearsimages->find()->where(['Gearsimages.gear_id'=>$id]);
                       // $categorys=$this->Categories->find()->where(['Categories.status'=>1])->toArray();
                      if($bike_image)
                      {
                        $biks = [];
                        foreach($bike_image as $bkg)
                        {
                         // print_r($bkg);exit;
                          $biks[] =array('id'=>$bkg->id,'link'=>Router::url('/', true).'gear_img/'.$bkg->name);
                        }
                      }
                      $file_details = $biks;
             $data = array('Ack'=>1, 'data'=>$file_details );
            }
              else{
                 $data = array('Ack'=> 0);
              }
              echo json_encode($data);
              exit();
       }
       public function listproduct() {
        //$this->viewBuilder()->layout('default');
        $uid = $this->request->data('uid');
        
        $this->loadModel('Products');
        $this->loadModel('Users');
        $this->loadModel('Productsimages');
        $this->loadModel('Bikemodels');
        $this->loadModel('Makes');
        $this->loadModel('Categories');
        //$user = $this->Users->get($this->Auth->user('id'));
        //$uid = $this->request->session()->read('Auth.User.id');
        //$utype = $this->request->session()->read('Auth.User.utype');
        //$uverify = $user->check_verified;
        //$conditions = ['Products.seller_id'=>$uid];
           
        // $this->paginate = [
        //     'conditions' => $conditions,
        //     'contain' => ['Productsimages', 'Bikemodels', 'Makes', 'Categories'],
        //     'order' => [ 'id' => 'DESC']
        // ];
        // $products = $this->paginate($this->Products); 

        $products = $this->Products->find()->where(['Products.seller_id'=>$uid])->order(['Products.id'=>'Desc'])->contain(['Productsimages', 'Bikemodels', 'Makes', 'Categories'])->toArray();
        $image_link = Router::url('/', true).'product_img/';
       /* pr($products);
        die;  */    
if($products)
{
$this->set([
                'bikes' =>$products,
                'Ack' => 1,
                'image_link' => $image_link,
                '_serialize' => ['bikes','Ack','image_link']
            ]);
}
else
{
  $this->set([
                'bikes' =>'',
                'Ack' => 0,
                'image_link' => $image_link,
                '_serialize' => ['bikes','Ack','image_link']
            ]);
}

    



        //$this->set(compact('products','image_link'));
        //$this->set('_serialize', ['products','image_link']);
 
    }
    



    

       public function listgear() {
        //$this->viewBuilder()->layout('default');
        $this->loadModel('Gears');
        $this->loadModel('Users');
        $this->loadModel('Categories');
        $this->loadModel('Gearsimages');

        $uid = $this->request->data['uid'];
        $cat_id = $this->request->data['cat_id'];

        if(isset($uid) && !isset($cat_id)){
          $condition = ['Gears.user_id'=>$uid];
        }
        elseif(isset($cat_id) && !isset($uid)){
          $condition = ['Gears.category_id' => $cat_id];
        }
        elseif(isset($uid) && isset($cat_id)){
          $condition = ['user_id' => $uid, 'category_id' => $cat_id];
        }
        else{
          $condition = '';
        }               

        $gears = $this->Gears->find()->where($condition)->order(['Gears.id'=>'Desc'])->contain(['Categories','Gearsimages'])->toArray();



         $image_link = Router::url('/', true).'gear_img/';
        // print_r($gears)
       /* pr($products);
        die;  */    
          if($gears)
          {
          //   if(count($gears['gearsimage'])>0)
          //   {
          // $gears['upload'] = $gears['gearsimage'][0]['name'];
          //   }
          //   else
          //   {
          //     $gears['upload'] = ''; 
          //   }
            
          $this->set([
                          'Ack' => 1,
                          'gears' => $gears,
                          'image_link' => $image_link,
                          '_serialize' => ['Ack','gears','image_link']
                      ]);
          }
          else
          {
            $this->set([
                          'Ack' => 0,
                          'gears' =>'',
                          'image_link' => $image_link,
                          '_serialize' => ['Ack','gears','image_link']
                      ]);
          }

 
    }



   public function productdelete($eid = null) {
        $this->loadModel('Products');
         $eid = $this->request->data('id');
        $product = $this->Products->get($eid);
        //print_r($product);exit;
        if ($this->Products->delete($product)) {
            $this->set([
                'Ack' => 1,
                '_serialize' => ['Ack']
            ]);
        } else {
            $this->set([
                'Ack' => 0,
                '_serialize' => ['Ack']
            ]);
        }
        //return $this->redirect(['action' => 'listproduct']);
    } 




 public function geardelete($eid = null) {
  
        $this->loadModel('Gears');

         $eid = $this->request->data('id');
//echo "here";exit;
        $product = $this->Gears->get($eid);
        
        //print_r($product);exit;
        if ($this->Gears->delete($product)) {
            $this->set([
                'Ack' => 1,
                '_serialize' => ['Ack']
            ]);
        } else {
            $this->set([
                'Ack' => 0,
                '_serialize' => ['Ack']
            ]);
        }
        
        //return $this->redirect(['action' => 'listproduct']);
    } 



public function bikedetails()
{
  $id = $this->request->data('id');
  $this->loadModel('Products');
  $products = $this->Products->find()->where(['Products.id'=>$id])->first();
  //print_r($products);exit;
  if($products)
  {
    $this->set([
                'Ack' => 1,
                'product' => $products,
                '_serialize' => ['Ack','product']
            ]);

    // $this->set([
    //   'Ack'=>1;
    //   'product'=>$products,
    //   '_serialize'=>['Ack','product']
    //   ]);
  }
  else
  {
    $this->set([
                'Ack' => 0,
                'product' => '',
                '_serialize' => ['Ack','product']
            ]);

    // $this->set([
    //   'Ack'=>0;
    //   'product'=>'',
    //   '_serialize'=>['Ack','product']
    //   ]);
  }
}



public function geardetails()
{
  $id = $this->request->data('id');
  $this->loadModel('Gears');
  $this->loadModel('Gearsimages');
  $gears = $this->Gears->find()->where(['Gears.id'=>$id])->contain(['Gearsimages'])->first();
  //print_r($products);exit;
  if($gears)
  {
    $link = [];
    $gears['colour_id'] = explode(",",$gears['colour_id']);
    if($gears['gearsimages'])
    {
      foreach($gears['gearsimages'] as $gimage)
      {
        $link[] =array('id'=> $gimage['id'],'link'=>Router::url('/', true).'gear_img/'.$gimage['name']) ;
      }
    }
    $gears['link'] = $link;
    $this->set([
                'Ack' => 1,
                'gear' => $gears,
                '_serialize' => ['Ack','gear']
            ]);

    // $this->set([
    //   'Ack'=>1;
    //   'product'=>$products,
    //   '_serialize'=>['Ack','product']
    //   ]);
  }
  else
  {
    $this->set([
                'Ack' => 0,
                'gear' => '',
                '_serialize' => ['Ack','gear']
            ]);

    // $this->set([
    //   'Ack'=>0;
    //   'product'=>'',
    //   '_serialize'=>['Ack','product']
    //   ]);
  }
}


public function bikeShowdetails()
{
  $productdetails = [];
  $id = $this->request->data('id');
   $user_id = $this->request->data('user_id');
  $this->loadModel('Products');
  $this->loadModel('Wishlists');
  $this->loadModel('Users');
  $products = $this->Products->find()->where(['Products.id'=>$id])->contain(['Bikemodels','Makes','Users'])->first();
  //print_r($products);exit;

$wishlist_data = $this->Wishlists->find()->where(['prod_id' => $id, 'user_id' => $user_id, 'status' => 'bikes'])->first();
//print_r($wishlist_data);exit;
  if($products)
  {
      $productdetails['user_iamge'] = Router::url('/', true).'user_img/thumb_'.$products->Users->pimg;
     $productdetails['id'] = $products->id;
    $productdetails['reg_number'] = $products->reg_number;
    $productdetails['price']= $products->price; 
    $productdetails['make'] = $products->Makes->make_name;
    $productdetails['cc'] = $products->cc;
    $productdetails['mileage'] = $products->mileage;
    if($products->fuel_type == 'P')
    {
      $fuel_type = 'Petrol';
    }
    elseif($products->fuel_type == 'D')
    {
      $fuel_type = 'Disel';
    }
    elseif($products->fuel_type == 'E')
    {
      $fuel_type = 'Electric';
    }
    else
    {
      $fuel_type = '';
    }
    $productdetails['fuel_type'] = $fuel_type;
    $productdetails['contact_email'] = $products->contact_email;
    $productdetails['contact_number'] = $products->cc;
    $productdetails['year'] = $products->year;
    $productdetails['description'] = $products->description;
    $productdetails['allow_phone'] = $products->allow_phone;
    $productdetails['postal_code'] = $products->postal_code;
    $productdetails['is_allow_phone'] = $products->is_allow_phone;
    $productdetails['no_of_owner'] = $products->no_of_owner;
    $productdetails['licence_type'] = $products->licence_type;
    $productdetails['model'] = $products->Bikemodels->model_name;
if(count($wishlist_data)>0)
{
$productdetails['wish'] = 1;
}
else
{
  $productdetails['wish'] = 0;
}

$productdetails['link'] =  BASE_URL.'/products/details/'.$productdetails['id'];


    $this->set([
                'Ack' => 1,
                'product' => $productdetails,
                '_serialize' => ['Ack','product']
            ]);

    // $this->set([
    //   'Ack'=>1;
    //   'product'=>$products,
    //   '_serialize'=>['Ack','product']
    //   ]);
  }
  else
  {
    $this->set([
                'Ack' => 0,
                'product' => '',
                '_serialize' => ['Ack','product']
            ]);

    // $this->set([
    //   'Ack'=>0;
    //   'product'=>'',
    //   '_serialize'=>['Ack','product']
    //   ]);
  }
}


public function gearShowdetails()
{
  $geardetails = [];
  $id = $this->request->data('id');
   $user_id = $this->request->data('user_id');
  $this->loadModel('Gears');
  $this->loadModel('Wishlists');
  $this->loadModel('Brands');
  $this->loadModel('Categories');
  $this->loadModel('Gearsimages');
  $this->loadModel('Sizes');
  $this->loadModel('Colours');
   $this->loadModel('ReviewRatings');
   $this->loadModel('Users');

  $gears = $this->Gears->find()->where(['Gears.id'=>$id])->contain(['Categories','Brands','Gearsimages','Sizes','Users'])->first();
 // print_r($products);exit;

$wishlist_data = $this->Wishlists->find()->where(['prod_id' => $id, 'user_id' => $user_id, 'status' => 'gears'])->first();

 $review_data = $this->ReviewRatings->find()->where(['prod_id' => $id, 'status' => 1])->contain(['Users'])->toArray();
 if(count($review_data) > 0)
 {
  foreach($review_data as $key=>$rs)
  {
    $rat = $rs['rating'];
    $rat_null = 5 - $rs['rating'];
    $rat_val =array();
    for($i=0;$i<$rs['rating'];$i++)
    {
      $rat_val[] = $i;
    }
    $rat_val_null =array();
    for($i=0;$i<$rat_null;$i++)
    {
      $rat_val_null[] = $i;
    }
    $review_data[$key]['rat_data']=$rat_val;
    $review_data[$key]['rat_data_null'] = $rat_val_null;
  }
 }
//print_r($wishlist_data);exit;
  if($gears)
  {
    $color = [];
     $colour_id = explode(",",$gears['colour_id']);
     if(count($colour_id)>0)
     {  
      foreach($colour_id as $clr)
      {  
        
          $rt = $this->Colours->find()->where(['Colours.id' => $clr])->first();
         
        $color[] = $rt;
      }
     }


// $size = $this->Sizes->find()->where(['Sizes.id' => $gears['size_id']])->first();
// $gears['size'] = $size['size'];

if(count($wishlist_data)>0)
{
$gears['wish'] = 1;
}
else
{
  $gears['wish'] = 0;
}
$gears['colour'] = $color;
$gears['link'] =  BASE_URL.'/products/categorydetails/'.$gears['id'];
$gears['image_link'] = Router::url('/', true).'gear_img/';
$gears['user_image_link'] = Router::url('/', true).'user_img/';

    $this->set([
                'Ack' => 1,
                'gears' => $gears,
                'review_data' =>$review_data,
                '_serialize' => ['Ack','gears','review_data']
            ]);

    // $this->set([
    //   'Ack'=>1;
    //   'product'=>$products,
    //   '_serialize'=>['Ack','product']
    //   ]);
  }
  else
  {
    $this->set([
                'Ack' => 0,
                'gears' => '',
                '_serialize' => ['Ack','gears']
            ]);

    // $this->set([
    //   'Ack'=>0;
    //   'product'=>'',
    //   '_serialize'=>['Ack','product']
    //   ]);
  }
}


public function bikeimagedetails()
{

$this->loadModel('Productsimages');
$id = $this->request->data('id');

  $bike_image = $this->Productsimages->find()->where(['Productsimages.product_id'=>$id])->toArray();
                       //print_r($bike_image);exit;
                      if(count($bike_image)>0)
                      {
                        $biks = [];
                        foreach($bike_image as $bkg)
                        {
                         //print_r($bkg);exit;
                          $biks[] =array('id'=>$bkg->id,'link'=>Router::url('/', true).'product_img/'.$bkg->name);
                        }
                        //print_r($biks);exit;
                        $this->set([
                'Ack' => 1,
                'productimage' => $biks,
                '_serialize' => ['Ack','productimage']
            ]);
                      }
                      else
                      {
                          $this->set([
                'Ack' => 0,
                'productimage' => '',
                '_serialize' => ['Ack','productimage']
            ]);
                      }
                      

}


       public function searchbike() {
        //$this->viewBuilder()->layout('default');
        //$uid = $this->request->data('uid');
        $serval = $this->request->data('ser_val');
        $color = $this->request->data('color');
        $fuel_tpe = $this->request->data('fuel_tpe');
        $make_id = $this->request->data('make_id');
        $max_cc = $this->request->data('max_cc');
        $min_cc = $this->request->data('min_cc');
        $max_milage = $this->request->data('max_milage');
        $min_milage = $this->request->data('min_milage');
        $max_price = $this->request->data('max_price');
        $min_price = $this->request->data('min_price');
        $model_id = $this->request->data('model_id');
        $post_by = $this->request->data('post_by');
        $postal_code = $this->request->data('postal_code');
        $max_year = $this->request->data('max_year');
        $min_year = $this->request->data('min_year');
        $sortby = $this->request->data('sort_by');


//print_r($this->request->data);exit;
        $this->loadModel('Products');
        $this->loadModel('Users');
        $this->loadModel('Productsimages');
        $this->loadModel('Bikemodels');
        $this->loadModel('Makes');
        $this->loadModel('Categories');
         

        $conditions = "";
         
        //  if($make_id!='')
        // {
        //     $conditions .='u.service_make_id LIKE "%'.$make_id.'%" AND ';
            
            
        // }
         if($serval != "")
         {
          $conditions .='(Products.reg_number LIKE "%'.$serval.'%"  OR  Products.product_name LIKE "%'.$serval.'%" OR Products.description LIKE "%'.$serval.'%") AND ';
         }
         if($color !="")
         {
          $conditions .='Products.color = "'.$color.'"   AND ';
         }
         if($fuel_tpe !="")
         {
          $conditions .='Products.fuel_type = "'.$fuel_tpe.'"   AND ';
         }
         if($make_id !="")
         {
          $conditions .='Products.make_id = "'.$make_id.'"   AND ';
         }
         if($max_cc !="")
         {
          $conditions .='Products.cc <= "'.$max_cc.'"   AND ';
         }
         if($min_cc !="")
         {
          $conditions .='Products.cc >= "'.$min_cc.'"   AND ';
         }
         if($max_milage !="")
         {
          $conditions .='Products.mileage <= "'.$max_milage.'"   AND ';
         }
         if($min_milage !="")
         {
          $conditions .='Products.mileage >= "'.$min_milage.'"   AND ';
         }
         if($max_price !="")
         {
          $conditions .='Products.price <= "'.$max_price.'"   AND ';
         }
         if($min_price !="")
         {
          $conditions .='Products.price >= "'.$min_price.'"   AND ';
         }
         if($model_id !="")
         {
          $conditions .='Products.model_id = "'.$model_id.'"   AND ';
         }
         if($post_by !="")
         {
          $conditions .='Products.licence_type = "'.$post_by.'"   AND ';
         }
         if($postal_code !="")
         {
          $conditions .='Products.postal_code = "'.$postal_code.'"   AND ';
         }
         if($max_year !="")
         {
          $conditions .='Products.year <= "'.$max_year.'"   AND ';
         }
         if($min_year !="")
         {
          $conditions .='Products.year >= "'.$max_year.'"   AND ';
         }
        
       
      $conditions .=' Products.is_active = "Y" ';   
       if($sortby)
         {
            if($sortby == 1)
            {
              $products = $this->Products->find()->where($conditions)->contain(['Productsimages', 'Bikemodels', 'Makes', 'Categories'])->order(['Products.price' => 'ASC'])->toArray();
            }
            else
            {
             // $conditions .='Products.price  ORDER by DESC';
              $products = $this->Products->find()->where($conditions)->contain(['Productsimages', 'Bikemodels', 'Makes', 'Categories'])->order(['Products.price' => 'DESC'])->toArray();
            }
         }
         else
         {
          $products = $this->Products->find()->where($conditions)->contain(['Productsimages', 'Bikemodels', 'Makes', 'Categories'])->toArray();
            
         //  $allservice= $conn->execute("select *,s.id from users as u left join services as s on u.id=s.provider_id left join service_provider_images as spi on spi.serviceprovider_id=u.id  where $conditions s.is_active='1' group by s.id ")->fetchAll('assoc'); 
         }
       
//echo $conditions;exit;

        
        $image_link = Router::url('/', true).'product_img/';
       /* pr($products);
        die;  */    
if($products)
{
$this->set([
                'bikes' =>$products,
                'Ack' => 1,
                'image_link' => $image_link,
                '_serialize' => ['bikes','Ack','image_link']
            ]);
}
else
{
  $this->set([
                'bikes' =>'',
                'Ack' => 0,
                'image_link' => $image_link,
                '_serialize' => ['bikes','Ack','image_link']
            ]);
}

    



        //$this->set(compact('products','image_link'));
        //$this->set('_serialize', ['products','image_link']);
 
    }


public function searchgear()
{



    $this->loadModel('Categories');
      $this->loadModel('Gears');
      $this->loadModel('Brands');
      $this->loadModel('Gearsimages');

      $post_data = $this->request->data;

      $searchgear = $this->request->data['ser_val'];
      $category_select = $this->request->data['cat_id'];
      $sortby = $this->request->data['sort_by'];

//print_r($searchgear);exit;
      if(isset($searchgear) && $searchgear != ''){
        $condition[] = array('Gears.product_name LIKE' => '%'.$searchgear.'%');
      }

      if(isset($category_select) && $category_select != ''){
        $condition[] = array('Gears.category_id' => $category_select);
      }

      if($cat_id != 0){
        $condition[] = array('Gears.category_id' => $cat_id);
        $post_data['category_select'] = $cat_id;
      }

      if(isset($sortby) && $sortby != ""){
        if($sortby == '1'){
          $order_by = "DESC";
        }
        elseif($sortby == '0'){
          $order_by = "ASC";
        }
       }
       else{
        $order_by = "";
       }

      
      $categories = $this->Categories->find()->toArray();
     
      $gears = $this->Gears->find()                        
                        ->where($condition)                        
                        ->order(['Gears.price' => $order_by])
                        ->contain(['Categories', 'Brands','Gearsimages']);



    $image_link = Router::url('/', true).'gear_img/';
       
if(count($gears)>0)
{
$this->set([
                'gears' =>$gears,
                'Ack' => 1,
                'image_link' => $image_link,
                '_serialize' => ['gears','Ack','image_link']
            ]);
}
else
{
  $this->set([
                'gears' =>'',
                'Ack' => 0,
                'image_link' => $image_link,
                '_serialize' => ['gears','Ack','image_link']
            ]);
}

    
}

public function addcart(){
      //echo $product_id;

      $this->viewBuilder()->layout('default');
      $this->loadModel('Users');
      $this->loadModel('Categories');
      $this->loadModel('Gears');
      $this->loadModel('Brands');
      $this->loadModel('Tempcarts');


         $post_data = $this->request->data;

      $product_id = $this->request->data['prod_id'];
      $user_id = $this->request->data['user_id'];
      
        



        
        $gears = $this->Gears->find()->where(['Gears.id' => $product_id])->first();

        //echo "<pre>";print_r($gears);exit;
//print_r($gears->id);exit;
        //foreach ($gears as $gear_val) {
          $seller_id = $gears->user_id;
          $category_name = $gears->category_id;
          $brand_name = $gears->brand_id;
          $size = $gears->size_id;
          $price = $gears->price;
          $description = $gears->description;
          $item_location =$gears->item_location;
          $product_name = $gears->product_name;
          $upload ='';// $gear_val->upload;
        //}
        $upload_array = explode(",", $upload);


        

        $product_exist = $this->Tempcarts->find()->where(['user_id' => $user_id,'prd_id' => $product_id])->toArray();
        // echo "<pre>";
        // print_r($product_exist);die;



        if(!empty($product_exist)){

          foreach ($product_exist as $prod_val) {
            $id = $prod_val->id;
            $product_prev_quantity = $prod_val->quantity;
            $productbase_price = $prod_val->price;
          }
          $new_prd_qty = $product_prev_quantity+1;
          $new_product_price = $productbase_price*$new_prd_qty;

          $temp_cart_data['user_id'] = $user_id;
          $temp_cart_data['seller_id'] = $seller_id;
          $temp_cart_data['prd_id'] = $product_id;
          $temp_cart_data['name'] = $product_name;
          $temp_cart_data['image'] = '';//$upload_array[0];
          $temp_cart_data['price'] = $new_product_price;
          $temp_cart_data['quantity'] = $new_prd_qty;
          // echo "<pre>";
          // print_r($temp_cart_data);die;
          $product_exist = $this->Tempcarts->get($id);
        }
        else{
          $product_exist = $this->Tempcarts->newEntity();
          $temp_cart_data['user_id'] = $user_id;
          $temp_cart_data['seller_id'] = $seller_id;
          $temp_cart_data['prd_id'] = $product_id;
          $temp_cart_data['name'] = $product_name;
          $temp_cart_data['image'] ='';// $upload_array[0];
          $temp_cart_data['price'] = $price;
          $temp_cart_data['quantity'] = 1;
        }


        $temp_data = $this->Tempcarts->patchEntity($product_exist, $temp_cart_data);



        if ($rs=$this->Tempcarts->save($temp_data)) {
          $this->set([
                'Ack' => 1,
                '_serialize' => ['Ack']
            ]);
        }
        else
        {
          $this->set([
                'Ack' => 0,
                '_serialize' => ['Ack']
            ]);
        }


        //return $this->redirect(['action' => 'cart']);
       

    }

    public function cart(){
      $this->loadModel('Users');
      $this->loadModel('Tempcarts');
      $this->loadModel('Gears');
      $this->loadModel('Gearsimages');
      $this->loadModel('Categories');
      $this->loadModel('Brands');
     $user_id = $this->request->data['user_id'];

      $all_temp_cart_data = $this->Tempcarts->find()->where(['Tempcarts.user_id' => $user_id])->contain(['Gears'=>['Gearsimages','Categories','Brands']])->toArray();
//print_r($all_temp_cart_data);exit;
      if(count($all_temp_cart_data)>0)
      { 
        $total_price = 0;
          $total_item = 0;
        foreach($all_temp_cart_data as $key=>$rt)
        {
          $total_price = $total_price + $rt['price'];
          $total_item =   $total_item + 1;
           if($rt['gear']['gearsimages'][0]['name'])
           {
            $all_temp_cart_data[$key]['image'] = Router::url('/', true).'gear_img/'.$rt['gear']['gearsimages'][0]['name'];
           }
           else
           {
            $all_temp_cart_data[$key]['image'] = '';
           }
          
        }
        //$all_temp_cart_data['total_price'] = $total_price;
        //$all_temp_cart_data['total_item'] = $total_item;

      }
     $this->set([
                'Ack' => 1,
                'cart'=>$all_temp_cart_data,
                'total_price'=>$total_price,
                "total_item"=>$total_item,
                '_serialize' => ['Ack','cart','total_price','total_item']
            ]);
    }

    public function updatecart(){
      //$this->viewBuilder()->layout('false');
      $this->loadModel('Users');
      $this->loadModel('Tempcarts');
      $this->loadModel('Gears');


      // if($this->request->is('post')){
      //print_r($this->request->data);exit;
      //echo "hi";
      $qty = $this->request->data['quantity'];
      $id = $this->request->data['id'];
      $increment = $this->request->data['increment'];
      $prd_id = $this->request->data['prd_id'];


       if($increment == 1)
       {
        $qty = $qty - 1;
       }
       else
       {
        $qty = $qty + 1;
       }

//echo $qty;exit;
        $get_price = $this->Gears->find()->select('price')->where(['id' => $prd_id])->toArray();
        foreach ($get_price as $price) {
          $prd_price = $price->price;
        }
//print_r($prd_price);exit;
        //echo $id;exit;
        $product_exist = $this->Tempcarts->get($id);
//print_r($product_exist);exit;
        // foreach ($product_exist as $prod_details) {
        //   $qty = $prod_details->quantity;
        // }

        $new_price = $qty*$prd_price;

        $update_array['quantity'] = $qty;
        $update_array['price'] = $new_price;

        $update_data = $this->Tempcarts->patchEntity($product_exist, $update_array);
      //  print_r( $update_data);exit;

        if ($rs=$this->Tempcarts->save($update_data)) {
         //echo "updated";exit;
          $this->set([
                'Ack' => 1,
                'price'=>$new_price,
                'quantity'=>$qty,
                '_serialize' => ['Ack','price','quantity']
            ]);
        }
        else
        {
          //echo "not updated";exit;
            $this->set([
                'Ack' => 0,
                'price'=>'',
                'quantity'=>'',
                '_serialize' => ['Ack','price','quantity']
            ]);
        }
      //}
//exit;
    }

    function removefromcart(){
      $this->loadModel('Users');
      $this->loadModel('Tempcarts');

      

      $id = $this->request->data['id'];
      //echo $id;exit;
      $temp_data = $this->Tempcarts->get($id);
      //print_r($temp_data);exit;
      if($this->Tempcarts->delete($temp_data))
      {   
        $this->set([
                'Ack' => 1,
                '_serialize' => ['Ack']
            ]);
      }
      else
      { 
         $this->set([
                'Ack' => 0,
                '_serialize' => ['Ack']
            ]);
      }
      
      
    }



public function addratingreview(){
     
      $this->loadModel('Users');
      $this->loadModel('ReviewRatings');
      
      
        $reviewRatings = $this->ReviewRatings->newEntity();
        
        

        
        $rating = $this->request->data['rating'];
        $review = $this->request->data['review'];

        $rating_review['user_id'] = $this->request->data['user_id'];
        $rating_review['prod_id'] = $this->request->data['prod_id'];
        $rating_review['rating'] = $rating;
        $rating_review['review'] = $review;
        $rating_review['review_date'] = date('Y-m-d H:i:s');

        $reviewRating_data = $this->ReviewRatings->patchEntity($reviewRatings, $rating_review);

        if ($rs=$this->ReviewRatings->save($reviewRating_data)) {
          $this->set([
                'Ack' => 1,
                '_serialize' => ['Ack']
            ]);
          //return $this->redirect(['action' => 'addratingreview',$gear_id]);
        }
        else
        {
          $this->set([
                'Ack' => 0,
                '_serialize' => ['Ack']
            ]);
        }
     
    }

    public function orderlist(){
      $this->viewBuilder()->layout('false');
      $this->loadModel('Users');
      $this->loadModel('Orders');
      $this->loadModel('OrderDetails');

      $user_id = $this->request->data['user_id'];

      $orderlist = $this->Orders->find()->select(['id','order_date','total_price'])->where(['user_id' => $user_id])->toArray();

      //$orderlist = json_encode($orderlist);

      if($this->Orders->find()->select(['id','order_date','total_price'])->where(['user_id' => $user_id])->toArray()){
        $orderlist = $this->Orders->find()->select(['id','order_date','total_price'])->where(['user_id' => $user_id])->toArray();
        $this->set([
                'Ack' => 1,
                'orderlist' => $orderlist,
                '_serialize' => ['Ack','orderlist']
            ]);
      }
      else{
        $this->set([
                'Ack' => 0,
                '_serialize' => ['Ack']
            ]);
      }

    }

    public function orderdetails(){
      $this->viewBuilder()->layout('false');
      $this->loadModel('Users');
      $this->loadModel('Orders');
      $this->loadModel('OrderDetails');
      $this->loadModel('Gears');

      $order_id = $this->request->data['order_id'];

      if($this->Orders->find()->where(['id' => $order_id])->contain(['OrderDetails'=>['Gears' => ['Users']]])->toArray()){
        $order_details = $this->Orders->find()->where(['id' => $order_id])->contain(['OrderDetails'=>['Gears' => ['Users']]])->toArray();
        $this->set([
                'Ack' => 1,
                'order_details' => $order_details,
                '_serialize' => ['Ack','order_details']
            ]);

      }
      else{
        $this->set([
                'Ack' => 0,
                '_serialize' => ['Ack']
            ]);
      }

    }

    public function orderlistseller(){

      $this->viewBuilder()->layout('false');
      $this->loadModel('Users');
      $this->loadModel('Orders');
      $this->loadModel('OrderDetails');
      $this->loadModel('Gears');

      $user_id = $this->request->data['user_id'];

            
      if($this->OrderDetails->find()->where(['seller_id' => $user_id])->contain(['Orders'])->group('order_id')->toArray()){

        $order_list_seller = $this->OrderDetails->find()->where(['seller_id' => $user_id])->contain(['Orders'])->group('order_id')->toArray();

        $this->set([
                'Ack' => 1,
                'order_list_seller' => $order_list_seller,
                '_serialize' => ['Ack','order_list_seller']
            ]);

      }
      else{
        $this->set([
                'Ack' => 0,
                '_serialize' => ['Ack']
            ]);
      }
    }

    public function orderdetailsseller(){

      $this->viewBuilder()->layout('false');
      $this->loadModel('Users');
      $this->loadModel('Orders');
      $this->loadModel('OrderDetails');
      $this->loadModel('Gears');

      $order_id = $this->request->data['order_id'];
      $user_id = $this->request->data['user_id'];

      if($this->OrderDetails->find()->where(['order_id' => $order_id,'seller_id' => $user_id])->contain(['Orders' => ['Users'],'Gears'])->toArray()){

        $seller_order_details = $this->OrderDetails->find()->where(['order_id' => $order_id,'seller_id' => $user_id])->contain(['Orders' => ['Users'],'Gears'])->toArray();

        $this->set([
                'Ack' => 1,
                'seller_order_details' => $seller_order_details,
                '_serialize' => ['Ack','seller_order_details']
            ]);

      }
      else{
        $this->set([
                'Ack' => 0,
                '_serialize' => ['Ack']
            ]);

      }

    }

    public function bikelisting(){
      $this->loadModel('Makes');

      if($this->Makes->find()->toArray()){
        $makes = $this->Makes->find()->toArray();
        $this->set([
                'Ack' => 1,
                'makes' => $makes,
                '_serialize' => ['Ack','makes']
            ]);
      }
      else{
        $this->set([
                'Ack' => 0,
                '_serialize' => ['Ack']
            ]);
      }
      
    }

    public function bikeresult(){
      $this->loadModel('Products');
      $this->loadModel('Productsimages');
      $this->loadModel('Bikemodels'); 
      $this->loadModel('Makes');
      $this->loadModel('Colours');

      $make_id = $this->request->data['make_id'];

      if(isset($make_id) and $make_id != ""){
          $condition[] = array('Makes.id'=> $make_id);
      }

      if($this->Products->find()->where($condition)->order(['Products.price' => $order_by])->contain(['Productsimages', 'Makes', 'Bikemodels'])){
        $products = $this->Products->find()                        
                        ->where($condition)                        
                        ->order(['Products.price' => $order_by])
                        ->contain(['Productsimages', 'Makes', 'Bikemodels']);
        $bikeimagepath = Router::url('/', true).'product_img/';
        $this->set([
                'Ack' => 1,
                'bikeimagepath' => $bikeimagepath,
                'products' => $products,
                '_serialize' => ['Ack','bikeimagepath','products']
            ]);
      }
      else{
        $this->set([
                'Ack' => 0,
                '_serialize' => ['Ack']
            ]);

      }
    }

    public function categorylisting(){

      $this->loadModel('Categories');
      
      if($this->Categories->find()->toArray()){
        $categories = $this->Categories->find()->toArray();
        $categoryimagepath = Router::url('/', true).'category_img/';
        $this->set([
                'Ack' => 1,
                'categoryimagepath' => $categoryimagepath,
                'categories' => $categories,
                '_serialize' => ['Ack','categoryimagepath','categories']
            ]);
      }
      else{
        $this->set([
                'Ack' => 0,
                '_serialize' => ['Ack']
            ]);
      }

    }

}