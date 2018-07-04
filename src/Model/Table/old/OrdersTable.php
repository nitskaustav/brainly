<?php

namespace App\Model\Table;

use App\Model\Entity\Order;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Orders Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Customers
 * @property \Cake\ORM\Association\BelongsTo $Addresses
 * @property \Cake\ORM\Association\BelongsTo $Runs
 * @property \Cake\ORM\Association\HasMany $Orderdetails
 */
class OrdersTable extends Table {

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config) {
        parent::initialize($config);

        $this->table('orders');
        $this->displayField('id');
        $this->primaryKey('id');
        
        
        $this->belongsTo('Treatments', [ 'foreignKey' => 'treatment_id']);
        $this->belongsTo('Users', [ 'foreignKey' => 'user_id']);
        $this->belongsTo('Billings', [ 'foreignKey' => 'shipping_id']);

        $this->hasMany('Orderdetails', ['foreignKey' => 'ord_id']);
        
        
        //$this->addBehavior('Timestamp');

        /*
          $this->belongsTo('Customers', [
          'foreignKey' => 'customer_id'
          ]);
          $this->belongsTo('Addresses', [
          'foreignKey' => 'address_id'
          ]);
          $this->belongsTo('Runs', [
          'foreignKey' => 'run_id'
          ]);
          $this->hasMany('Orderdetails', [
          'foreignKey' => 'order_id'
          ]);
         */
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
}
