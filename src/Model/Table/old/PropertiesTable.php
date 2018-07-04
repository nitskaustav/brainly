<?php

namespace App\Model\Table;

use Cake\Utility\Text;
use Cake\Event\Event;
use Cake\ORM\Table;
use ArrayObject;
use Cake\I18n\Time;

class PropertiesTable extends Table {

    public function initialize(array $config) {
        $this->table('properties');
        //$this->displayField('id');
        $this->primaryKey('id');
        //$this->request->data['dob']= Time::parseDate($this->request->data['dob'],'Y-M-d');



        /*
          $this->hasMany('Reviews', [
          'foreignKey' => 'service_provider_id',
          'dependent' => true,
          ]);


          $this->hasOne('Bankdetails', [
          'className' => 'Bankdetails',
          'foreignKey' => 'service_provider_id',
          'propertyName' => 'Bankdetails'
          ]);

          $this->hasOne('Packagedetails', [
          'className' => 'Packagedetails',
          'foreignKey' => 'id',
          'propertyName' => 'Packagedetails'
          ]);


          $this->belongsTo('Packagedetails', [
          'className' => 'Packagedetails',
          'foreignKey' => 'id',
          'propertyName' => 'Packagedetails'
          ]);

         */
           $this->belongsTo('Categories', [
          'className' => 'Categories',
          'foreignKey' => 'category_id',
          'propertyName' => 'Categories'
          ]);  
            $this->belongsTo('Users', [
          'className' => 'Users',
          'foreignKey' => 'user_id',
          'propertyName' => 'Users'
          ]);  
    }

    

}
