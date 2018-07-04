<?php

namespace App\Model\Table;

use App\Model\Entity\Customer;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Customers Model
 *
 * @property \Cake\ORM\Association\HasMany $Addresses
 * @property \Cake\ORM\Association\HasMany $Orders
 * @property \Cake\ORM\Association\HasMany $Templates
 */
class ProductsTable extends Table {

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config) {
        parent::initialize($config);

//----------------------------------------------
        $this->belongsTo('Bikemodels', [
            'className' => 'Bikemodels',
            'foreignKey' => 'model_id',
            'propertyName' => 'Bikemodels'
        ]);

        $this->belongsTo('Makes', [
            'className' => 'Makes',
            'foreignKey' => 'make_id',
            'propertyName' => 'Makes'
        ]);

        $this->belongsTo('Users', [
            'className' => 'Users',
            'foreignKey' => 'seller_id',
            'propertyName' => 'Users'
        ]);

        $this->belongsTo('Categories', [
            'className' => 'Categories',
            'foreignKey' => 'category_id',
            'propertyName' => 'Categories'
        ]);

//----------------------------------------------


        $this->hasMany('Productsimages', [
          'foreignKey' => 'product_id'
        ]);

           
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
    public function buildRules(RulesChecker $rules) {
        //$rules->add($rules->isUnique(['slug'], 'Slug Already Used Try with another'));
        //$rules->add($rules->isUnique(['username'], 'Username Already Used Try with another'));
        return $rules;
    }

}
