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
class MedicinesTable extends Table {

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config) {
        parent::initialize($config);

        $this->table('medicines');
        $this->displayField('title');
        $this->primaryKey('id');

        $this->belongsTo('Treatment', ['className' => 'Treatments', 'foreignKey' => 'treatment_id', 'propertyName' => 'Treatments' ]);
        $this->hasMany('Pils', ['foreignKey' => 'mid']);
        $this->hasMany('MedicineFaqs', ['foreignKey' => 'medicine_id']);
        //$this->hasMany('MedicineQuestions', ['foreignKey' => 'mid']);
        
          /*
          $this->hasMany('Orders', [
          'foreignKey' => 'customer_id'
          ]);
          $this->hasMany('Templates', [
          'foreignKey' => 'customer_id'
          ]);
         */
    }

}
