<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\ORM\RulesChecker;
use App\Model\Entity\Customer;
class AdminsTable extends Table {

    public function initialize(array $config) {
         parent::initialize($config);

        $this->table('admins');
        $this->displayField('name');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');
        
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
        */

        //$this->belongsTo('Packagedetails', [
        //'className' => 'Packagedetails',
        //  'foreignKey' => 'id',
        //  'propertyName' => 'Packagedetails'
        // ]);
    }
    public function buildRules(RulesChecker $rules) {
        $rules->add($rules->isUnique(['email'], 'Email Already Used Try with another'));
        $rules->add($rules->isUnique(['username'], 'Username Already Used Try with another'));
        return $rules;
    }

}
