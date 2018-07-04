<?php

namespace App\Model\Table;

use App\Model\Entity\Customer;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class TransactionsTable extends Table {

    public function initialize(array $config) {
        parent::initialize($config);
        $this->table('transactions');
        $this->displayField('name');
        $this->primaryKey('id');

        $this->belongsTo('Users', ['className' => 'Users', 'foreignKey' => 'user_id', 'propertyName' => 'Users']);
        $this->hasMany('Orders', ['className' => 'Orders', 'foreignKey' => 'transactionid', 'propertyName' => 'Orders']);
    }

}
