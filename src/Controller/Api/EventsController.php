<?php
namespace App\Controller\Api;
use Cake\Event\Event;
use Cake\Network\Exception\UnauthorizedException;
use Cake\Utility\Security;
use Firebase\JWT\JWT;
use Cake\ORM\TableRegistry;
use Cake\Routing\Router;
use Cake\Mailer\Email;
class EventsController extends AppController
{
    public function initialize()
    {
        parent::initialize();
        $this->Auth->allow(['add']);
        $this->loadComponent('RequestHandler');
    }
    
    
    
    public function listevents() {
        $this->loadModel('Events');
        $this->loadModel('EventImages');
        $date = date('Y-m-d H:i:s');
        //$events = $this->Events->find('all')->where(['Events.status' => 1]);
        $events = $this->Events->find('all', array('conditions' => array('status' => 1, 'event_end_date >=' => $date), 'contain' => array('EventImages')));
    
        $event_arr = array();
        foreach ($events as $event) {
            if(count($event['EventImages']) > 0){
                $image = Router::url('/', true).'event_img/'.$event['EventImages'][0]['image'];
            }
            else{
                $image = Router::url('/', true).'event_img/default.png';
            }
           $event_arr[] = array(
                                'id' => $event['id'],
                                'name' => $event['name'],
                                'location' => $event['location'],                                
                                'image' => $image
                                ); 
        }
        $this->set([
                    'ack' => 1,
                    'lists' => $event_arr,
                    'msg' => 'No list found.',
                    '_serialize' => ['lists','ack']
                ]);

    }

    public function eventdetails() {
        $this->loadModel('Events');
        $this->loadModel('EventImages');
        $this->loadModel('Tables');
        $this->loadModel('Users');
        
        
        $details = $this->Events->find()->where(['Events.id' => $this->request->data['id']])->contain(['EventImages', 'Tables', 'Users'])->first();
       
      
       if(count($details['EventImages']) > 0){
            foreach ($details['EventImages'] as $event) { 
                $image[] = Router::url('/', true).'event_img/'.$event['image'];
            }
        }

           $event = array(
                            'id' => $details['id'],
                            'name' => $details['name'],
                            'event_description' => $details['event_description'],
                            'club_name' => $details['Users']['club_name'],
                            'club_details' => $details['Users']['details'],
                            'music' => $details['music'],
                            'crowd' => $details['crowd'],
                            'location' => $details['location'],
                            'latitude' => $details['latitude'],
                            'longitude' => $details['longitude'],  
                            'images' => $image
                            ); 
        
        $this->set([
                    'ack' => 1,
                    'details' => $event,
                    'msg' => 'No list found.',
                    '_serialize' => ['details','ack']
                ]);

    }
}