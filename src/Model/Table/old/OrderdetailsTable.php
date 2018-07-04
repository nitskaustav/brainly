<?php

namespace App\Model\Table;

use App\Model\Entity\Orderdetail;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Orderdetails Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Orders
 * @property \Cake\ORM\Association\BelongsTo $Products
 */
class OrderdetailsTable extends Table {

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config) {
        parent::initialize($config);

        $this->table('orderdetails');
        $this->displayField('id');
        $this->primaryKey('id');
        
        
        $this->belongsTo('Treatments', ['foreignKey' => 'treatment_id']);
        $this->belongsTo('Medicines', ['foreignKey' => 'medicine_id']);
        $this->belongsTo('Pils', ['foreignKey' => 'pil_id']);
        $this->belongsTo('Orders', ['foreignKey' => 'ord_id']);
        
        /*
          $this->addBehavior('Timestamp');

          $this->belongsTo('Orders', [
          'foreignKey' => 'order_id'
          ]);
          $this->belongsTo('Products', [
          'foreignKey' => 'product_id'
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
