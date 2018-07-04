<?php

namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Core\Configure;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use Cake\ORM\TableRegistry;
use Cake\Datasource\ConnectionManager;
use Cake\View\Helper;
/**
 * Website Settings Controller
 *
 * @property \App\Model\Table\SiteSettingsTable $Customers
 */
class StatisticsController extends AppController {
    

    /**
     * Edit method
     *
     * @param string|null $id Customer id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    
    
    public function initialize() {
        parent::initialize();
        $this->Auth->allow(['getcount']);
     }
    
    
    
    public function index() {

        $this->viewBuilder()->layout('admin');
        
        $this->loadModel('Users');
        $this->loadModel('Services');
        $this->loadModel('Reviews'); 
        $this->loadModel('Visitors');
        
      $timeperiod='';  
     //if(!empty($_REQUEST['day']) && $_REQUEST['day']== 7){   
     /*$day = date('w');
     $week_start = date('Y-m-d', strtotime('-'.$day.' days'));
     $week_end = date('Y-m-d', strtotime('+'.(6-$day).' days'));
     
    $countuser = $this->Users->find()->where(['Users.utype'=>1,'Users.is_active'=>1,'created > DATE_ADD(NOW(),INTERVAL -7 DAY)'])->count(); 
   
    $countservice = $this->Services->find()->where(['Services.is_active'=>1,'created > DATE_ADD(NOW(),INTERVAL -7 DAY)'])->count(); 
       
    $countserviceverified = $this->Users->find()->where(['Users.utype'=>2,'Users.check_verified'=>'Y','verified_date > DATE_ADD(NOW(),INTERVAL -7 DAY)'])->count();
       
    $countreview = $this->Reviews->find()->where(['post_date > DATE_ADD(NOW(),INTERVAL -7 DAY)'])->count();
   $timeperiod= 'Past 7 days';
     
     }else if(!empty($_REQUEST['day']) && $_REQUEST['day']== 30){   
     
    $startdate = date('Y-m-01');
   $enddate = date('Y-m-t');
    $countuser = $this->Users->find()->where(['Users.utype'=>1,'Users.is_active'=>1,'created > DATE_ADD(NOW(),INTERVAL -30 DAY)'])->group('Users.id')->count(); 
     
    $countservice = $this->Services->find()->where(['Services.is_active'=>1,'created > DATE_ADD(NOW(),INTERVAL -30 DAY)'])->count(); 
       
    $countserviceverified = $this->Users->find()->where(['Users.utype'=>2,'Users.check_verified'=>'Y','Users.verified_date > DATE_ADD(NOW(),INTERVAL -30 DAY)'])->count();
    
    //echo $countserviceverified;exit;
       
    $countreview = $this->Reviews->find()->where(['post_date > DATE_ADD(NOW(),INTERVAL -30 DAY)'])->count();
   $timeperiod= 'Past 30 days';
    
     }else if(!empty($_REQUEST['day']) && $_REQUEST['day']== 1){   
     
    $startdate = date('Y-m-d 00:00:01');
    $enddate = date('Y-m-t 23:59:59');
    $countuser = $this->Users->find()->where(['Users.utype'=>1,'Users.is_active'=>1,'created >'=>$startdate,'created <='=>$enddate])->group('Users.id')->count(); 
     
    $countservice = $this->Services->find()->where(['Services.is_active'=>1,'created >'=>$startdate,'created <='=>$enddate])->count(); 
       
    $countserviceverified = $this->Users->find()->where(['Users.utype'=>2,'Users.check_verified'=>'Y','verified_date >'=>$startdate,'verified_date <='=>$enddate])->group('Users.id')->count();
       
    $countreview = $this->Reviews->find()->where(['post_date >'=>$startdate,'post_date <='=>$enddate])->count();
   
    $timeperiod= 'Today';
     }else if(!empty($_REQUEST['day']) && $_REQUEST['day']== 365){   
     
    $startdate = date('Y-01-01 00:00:01');
    $enddate = date('Y-12-31 23:59:59');
   
    
    
    $countuser = $this->Users->find()->where(['Users.utype'=>1,'Users.is_active'=>1,'created > DATE_ADD(NOW(),INTERVAL -1 YEAR)'])->count(); 
     
    $countservice = $this->Services->find()->where(['Services.is_active'=>1,'created > DATE_ADD(NOW(),INTERVAL -1 YEAR)'])->count(); 
       
    $countserviceverified = $this->Users->find()->where(['Users.utype'=>2,'Users.check_verified'=>'Y','verified_date > DATE_ADD(NOW(),INTERVAL -1 YEAR)'])->count();
       
    $countreview = $this->Reviews->find()->where(['post_date > DATE_ADD(NOW(),INTERVAL -1 YEAR)'])->count();
   
    $timeperiod= 'one year';
    
     }*/
     
     
     
    // else{
     
       $countuser = $this->Users->find()->where(['Users.utype'=>1,'Users.is_active'=>1])->group('Users.id')->count(); 
     
       //echo $countuser;
       $countservice = $this->Services->find()->where(['Services.is_active'=>1])->count(); 
       
       $countserviceverified = $this->Users->find()->where(['Users.utype'=>2,'Users.check_verified'=>'Y'])->group('Users.id')->count();
       
       $countreview = $this->Reviews->find()->count();
       
       $timeperiod= 'All';
       
     //}
     
     
      $countallvisitor = $this->Visitors->find()->count();
      
      
      
      
     
        $this->set(compact('countuser','countservice','countreview','countserviceverified','countallvisitor','timeperiod'));
        $this->set('_serialize', ['countuser','countservice','countreview','countserviceverified']);
    
    }
    
    
    
    
    public function getcount() {

        $this->viewBuilder()->layout(false);
        
        $this->loadModel('Users');
        $this->loadModel('Services');
        $this->loadModel('Reviews'); 
        $this->loadModel('Visitors');
        //print_r($_REQUEST['day']);exit();
      $timeperiod='';  
     if(!empty($_REQUEST['day']) && $_REQUEST['day']== 7){   
     //$day = date('w');
     //$week_start = date('Y-m-d', strtotime('-'.$day.' days'));
    // $week_end = date('Y-m-d', strtotime('+'.(6-$day).' days'));
     $conn = ConnectionManager::get('default');
         
    $countuser = $this->Users->find()->where(['Users.utype'=>1,'Users.is_active'=>1,'created > DATE_ADD(NOW(),INTERVAL -7 DAY)'])->count(); 
   
    for ($i = 0; $i <= 6; $i++) {
    
        $date = date("Y-m-d", strtotime( date( 'Y-m-d' )." -$i days"));
       
        $countuserperiod = $conn->execute("SELECT Count(*) as c FROM users where utype=1 and is_active=1 and created between '".$date." 00:00:01' and  '".$date." 23:59:59'")->fetchAll('assoc');
      
        $countusergraph[] = $countuserperiod[0]['c'];
    }
    
    
    
    $countservice = $this->Services->find()->where(['Services.is_active'=>1,'created > DATE_ADD(NOW(),INTERVAL -7 DAY)'])->count();
    
    for ($i = 0; $i <= 6; $i++) {
    
        $date = date("Y-m-d", strtotime( date( 'Y-m-d' )." -$i days"));
       
        $countserviceperiod = $conn->execute("SELECT Count(created) as c FROM services where is_active=1 and created between '".$date." 00:00:01' and  '".$date." 23:59:59'")->fetchAll('assoc');
      
        $countservicegraph[] = $countserviceperiod[0]['c'];
    }
    //print_r($countservicegraph);exit;
    
       
    $countserviceverified = $this->Users->find()->where(['Users.utype'=>2,'Users.check_verified'=>'Y','verified_date > DATE_ADD(NOW(),INTERVAL -7 DAY)'])->count();
    
    for ($i = 0; $i <= 6; $i++) {
    
        $date = date("Y-m-d", strtotime( date( 'Y-m-d' )." -$i days"));
       
        $countserviceverifiedperiod = $conn->execute("SELECT Count(*) as c FROM users where utype=2 and check_verified='Y' and verified_date between '".$date." 00:00:01' and  '".$date." 23:59:59'")->fetchAll('assoc');
      
        $countserviceverifiedgraph[] = $countserviceverifiedperiod[0]['c'];
    }
    
    
       
    $countreview = $this->Reviews->find()->where(['post_date > DATE_ADD(NOW(),INTERVAL -7 DAY)'])->count();
    
    for ($i = 0; $i <= 6; $i++) {
    
        $date = date("Y-m-d", strtotime( date( 'Y-m-d' )." -$i days"));
       
        $countreviewperiod = $conn->execute("SELECT Count(*) as c FROM reviews where post_date between '".$date." 00:00:01' and  '".$date." 23:59:59'")->fetchAll('assoc');
      
        $countreviewgraph[] = $countreviewperiod[0]['c'];
    }
    
    
    
   $timeperiod= 'Past 7 days';
   
   for ($i = 0; $i <= 6; $i++) {
    $period[] = date("d M Y", strtotime( date( 'Y-m-d' )." -$i days"));
    }
     
     }else if(!empty($_REQUEST['day']) && $_REQUEST['day']== 30){   
     
    $conn = ConnectionManager::get('default');
    $countuser = $this->Users->find()->where(['Users.utype'=>1,'Users.is_active'=>1,'created > DATE_ADD(NOW(),INTERVAL -30 DAY)'])->group('Users.id')->count(); 
         
    for ($i = 0; $i <= 30; $i++) {
    
        $date = date("Y-m-d", strtotime( date( 'Y-m-d' )." -$i days"));
       
        $countuserperiod = $conn->execute("SELECT Count(*) as c FROM users where utype=1 and is_active=1 and created between '".$date." 00:00:01' and  '".$date." 23:59:59'")->fetchAll('assoc');
      
        $countusergraph[] = $countuserperiod[0]['c'];
    }
    
   
    
    $countservice = $this->Services->find()->where(['Services.is_active'=>1,'created > DATE_ADD(NOW(),INTERVAL -30 DAY)'])->count(); 
    
    for ($i = 0; $i <= 30; $i++) {
    
        $date = date("Y-m-d", strtotime( date( 'Y-m-d' )." -$i days"));
       
        $countserviceperiod = $conn->execute("SELECT Count(*) as c FROM services where is_active=1 and created between '".$date." 00:00:01' and  '".$date." 23:59:59'")->fetchAll('assoc');
      
        $countservicegraph[] = $countserviceperiod[0]['c'];
    }
    
    
       
    $countserviceverified = $this->Users->find()->where(['Users.utype'=>2,'Users.check_verified'=>'Y','Users.verified_date > DATE_ADD(NOW(),INTERVAL -30 DAY)'])->count();
    
    for ($i = 0; $i <= 30; $i++) {
    
        $date = date("Y-m-d", strtotime( date( 'Y-m-d' )." -$i days"));
       
        $countserviceverifiedperiod = $conn->execute("SELECT Count(*) as c FROM users where utype=2 and check_verified='Y' and verified_date between '".$date." 00:00:01' and  '".$date." 23:59:59'")->fetchAll('assoc');
      
        $countserviceverifiedgraph[] = $countserviceverifiedperiod[0]['c'];
    }
    //print_r($countserviceverifiedgraph);exit;
       
    $countreview = $this->Reviews->find()->where(['post_date > DATE_ADD(NOW(),INTERVAL -30 DAY)'])->count();
    
    for ($i = 0; $i <= 30; $i++) {
    
        $date = date("Y-m-d", strtotime( date( 'Y-m-d' )." -$i days"));
       
        $countreviewperiod = $conn->execute("SELECT Count(*) as c FROM reviews where post_date between '".$date." 00:00:01' and  '".$date." 23:59:59'")->fetchAll('assoc');
      
        $countreviewgraph[] = $countreviewperiod[0]['c'];
    }
   
   $timeperiod= 'Past 30 days';
   
   for ($i = 0; $i <= 30; $i++) {
    $period[] = date("d M Y", strtotime( date( 'Y-m-d' )." -$i days"));
   }
   //print_r($period);
    
     }else if(!empty($_REQUEST['day']) && $_REQUEST['day']== 1){   
     
    $startdate = date('Y-m-d 00:00:01');
    $enddate = date('Y-m-t 23:59:59');
    $countuser = $this->Users->find()->where(['Users.utype'=>1,'Users.is_active'=>1,'created >'=>$startdate,'created <='=>$enddate])->group('Users.id')->count(); 
     $countusergraph[] = $this->Users->find()->where(['Users.utype'=>1,'Users.is_active'=>1,'created >'=>$startdate,'created <='=>$enddate])->group('Users.id')->count();
     
     
    $countservice = $this->Services->find()->where(['Services.is_active'=>1,'created >'=>$startdate,'created <='=>$enddate])->count(); 
    $countservicegraph[] = $this->Services->find()->where(['Services.is_active'=>1,'created >'=>$startdate,'created <='=>$enddate])->count(); 
    
    
       
    $countserviceverified = $this->Users->find()->where(['Users.utype'=>2,'Users.check_verified'=>'Y','verified_date >'=>$startdate,'verified_date <='=>$enddate])->group('Users.id')->count();
    $countserviceverifiedgraph[] = $this->Users->find()->where(['Users.utype'=>2,'Users.check_verified'=>'Y','verified_date >'=>$startdate,'verified_date <='=>$enddate])->group('Users.id')->count();
    
       
    $countreview = $this->Reviews->find()->where(['post_date >'=>$startdate,'post_date <='=>$enddate])->count();
   
    $countreviewgraph[] = $this->Reviews->find()->where(['post_date >'=>$startdate,'post_date <='=>$enddate])->count();
    
    
    $timeperiod= 'Today';
    $period[] = date("d M Y", strtotime( date( 'Y-m-d' )));
    
    
     }else if(!empty($_REQUEST['day']) && $_REQUEST['day']== 365){   
     
   
    $countuser = $this->Users->find()->where(['Users.utype'=>1,'Users.is_active'=>1,'created > DATE_ADD(NOW(),INTERVAL -1 YEAR)'])->count(); 
    
    $conn = ConnectionManager::get('default');                      
    $countuserperiod = $conn->execute("SELECT y, m, Count(`created`) as c FROM (SELECT y, m FROM
    (SELECT YEAR(CURDATE()) y UNION ALL SELECT YEAR(CURDATE())-1) years,
    (SELECT 1 m UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4
      UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8
      UNION ALL SELECT 9 UNION ALL SELECT 10 UNION ALL SELECT 11 UNION ALL SELECT 12) months) ym
  LEFT JOIN users ON ym.y = YEAR(users.created) AND ym.m = MONTH(users.created) AND users.utype=1 AND users.is_active=1 WHERE  (y=YEAR(CURDATE()) AND m<=MONTH(CURDATE())) OR
  (y<YEAR(CURDATE()) AND m>MONTH(CURDATE())) group by y,m")->fetchAll('assoc');
    foreach($countuserperiod as $dt){
    $countusergraph[]=$dt['c'];
 
    }
    //print_r($countusergraph);exit;
    
    $countservice = $this->Services->find()->where(['Services.is_active'=>1,'created > DATE_ADD(NOW(),INTERVAL -1 YEAR)'])->count();
    
    $conn = ConnectionManager::get('default');                      
    $countserviceperiod = $conn->execute("SELECT y, m, Count(`created`) as c FROM (SELECT y, m FROM
    (SELECT YEAR(CURDATE()) y UNION ALL SELECT YEAR(CURDATE())-1) years,
    (SELECT 1 m UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4
      UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8
      UNION ALL SELECT 9 UNION ALL SELECT 10 UNION ALL SELECT 11 UNION ALL SELECT 12) months) ym
  LEFT JOIN services ON ym.y = YEAR(services.created) AND ym.m = MONTH(services.created) AND services.is_active=1  WHERE (y=YEAR(CURDATE()) AND m<=MONTH(CURDATE())) OR
  (y<YEAR(CURDATE()) AND m>MONTH(CURDATE())) group by y,m")->fetchAll('assoc');
    foreach($countserviceperiod as $dt){
    $countservicegraph[]=$dt['c'];
 
    }
    
 
    $countserviceverified = $this->Users->find()->where(['Users.utype'=>2,'Users.check_verified'=>'Y','verified_date > DATE_ADD(NOW(),INTERVAL -1 YEAR)'])->count();

    $conn = ConnectionManager::get('default');                      
    $countserviceverifiedperiod = $conn->execute("SELECT y, m, Count(`verified_date`) as c FROM (SELECT y, m FROM
    (SELECT YEAR(CURDATE()) y UNION ALL SELECT YEAR(CURDATE())-1) years,
    (SELECT 1 m UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4
      UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8
      UNION ALL SELECT 9 UNION ALL SELECT 10 UNION ALL SELECT 11 UNION ALL SELECT 12) months) ym
  LEFT JOIN users ON ym.y = YEAR(users.verified_date) AND ym.m = MONTH(users.verified_date) AND users.utype=2 AND users.check_verified='Y' WHERE (y=YEAR(CURDATE()) AND m<=MONTH(CURDATE())) OR
  (y<YEAR(CURDATE()) AND m>MONTH(CURDATE())) group by y,m")->fetchAll('assoc');
    foreach($countserviceverifiedperiod as $dt){
    $countserviceverifiedgraph[]=$dt['c'];
 
    }
    
    $countreview = $this->Reviews->find()->where(['post_date > DATE_ADD(NOW(),INTERVAL -1 YEAR)'])->count();

    $conn = ConnectionManager::get('default');                      
    $countreviewperiod = $conn->execute("SELECT y, m, Count(`post_date`) as c FROM (SELECT y, m FROM
    (SELECT YEAR(CURDATE()) y UNION ALL SELECT YEAR(CURDATE())-1) years,
    (SELECT 1 m UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4
      UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8
      UNION ALL SELECT 9 UNION ALL SELECT 10 UNION ALL SELECT 11 UNION ALL SELECT 12) months) ym
  LEFT JOIN reviews ON ym.y = YEAR(reviews.post_date) AND ym.m = MONTH(reviews.post_date) WHERE (y=YEAR(CURDATE()) AND m<=MONTH(CURDATE())) OR
  (y<YEAR(CURDATE()) AND m>MONTH(CURDATE())) group by y,m")->fetchAll('assoc');
    foreach($countreviewperiod as $dt){
    $countreviewgraph[]=$dt['c'];
 
    }
    
    
   
    $timeperiod= 'one year';
    
    
    for ($i = 0; $i <= 11; $i++) {
    $period[] = date("M Y", strtotime( date( 'Y-m-d' )." -$i months"));
    }
    
     }
     
     else{
         
         $data = array('Ack'=>0);
     }
     
     /*else{
         
       $conn = ConnectionManager::get('default'); 
     
       $countuser = $this->Users->find()->where(['Users.utype'=>1,'Users.is_active'=>1])->group('Users.id')->count();
       $countuserperiod = $conn->execute("SELECT created , COUNT(created) as c FROM users WHERE utype=1 and is_active=1 and  created <= NOW() GROUP BY MONTH(created)")->fetchAll('assoc');
    foreach($countuserperiod as $dt){
        
    $period[] = date("M Y", strtotime( $dt['created']));   
    $countusergraph[]=$dt['c'];
 
    }
       
     
       //echo $countuser;
       $countservice = $this->Services->find()->where(['Services.is_active'=>1])->count();
       
       $countserviceperiod = $conn->execute("SELECT created , COUNT(created) as c FROM services WHERE is_active=1 and  created <= NOW() GROUP BY MONTH(created)")->fetchAll('assoc');
    foreach($countserviceperiod as $dt){
        
    //$period[] = date("M Y", strtotime( $dt['created']));   
    $countservicegraph[]=$dt['c'];
 
    }
       
       
       
       $countserviceverified = $this->Users->find()->where(['Users.utype'=>2,'Users.check_verified'=>'Y'])->group('Users.id')->count();
       
       $countserviceverifiedperiod = $conn->execute("SELECT verified_date , COUNT(verified_date) as c FROM users WHERE utype=2 and check_verified='Y' and  verified_date <= NOW() GROUP BY MONTH(verified_date)")->fetchAll('assoc');
    foreach($countserviceverifiedperiod as $dt){
        
    //$period[] = date("M Y", strtotime( $dt['verified_date']));   
    $countserviceverifiedgraph[]=$dt['c'];
 
    }
       
       
       
       
       $countreview = $this->Reviews->find()->count();
       
       $countreviewperiod = $conn->execute("SELECT post_date , COUNT(post_date) as c FROM reviews WHERE  post_date <= NOW() GROUP BY MONTH(post_date)")->fetchAll('assoc');
    foreach($countreviewperiod as $dt){
        
    $period[] = date("M Y", strtotime( $dt['post_date']));   
    $countreviewgraph[]=$dt['c'];
 
    }
     
       $timeperiod= 'All';
       
     }*/
     
     
     

     
      $countallvisitor = $this->Visitors->find()->count();
      
     $data = array('Ack'=>1, 'countuser'=>$countuser,'countservice'=>$countservice,'countserviceverified'=>$countserviceverified,'countreview'=>$countreview,'timeperiod'=>$timeperiod,'countallvisitor'=>$countallvisitor,'months'=>array_reverse($period),'countusergraph'=>($countusergraph),'countserviceverifiedgraph'=>($countserviceverifiedgraph),'countservicegraph'=>($countservicegraph),'countreviewgraph'=>($countreviewgraph));
     
     echo json_encode($data);
              exit();
    
    }
    
    
    
    
}


//SELECT MONTH(reg_date) , COUNT(reg_date) FROM your_table WHERE reg_date >= NOW() - INTERVAL 1 YEAR GROUP BY MONTH(reg_date)

