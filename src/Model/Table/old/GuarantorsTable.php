<?php

namespace App\Model\Table;

use Cake\Utility\Text;
use Cake\Event\Event;
use Cake\ORM\Table;
use ArrayObject;
use Cake\I18n\Time;

class GuarantorsTable extends Table {

    public function initialize(array $config) {
        $this->table('guarantors');
        //$this->displayField('id');
        $this->primaryKey('id');
        //$this->request->data['dob']= Time::parseDate($this->request->data['dob'],'Y-M-d');



        
           $this->belongsTo('Tenants', [
          'className' => 'Tenants',
          'foreignKey' => 'tenant_id',
          'propertyName' => 'Tenants'
          ]);  
           
    }

    

}
