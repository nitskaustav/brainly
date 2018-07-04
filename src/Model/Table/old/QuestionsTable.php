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
class QuestionsTable extends Table {

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config) {
        parent::initialize($config);

        $this->table('questions');
        $this->displayField('question');
        $this->primaryKey('id');

        
          $this->hasMany('QuestionCheckboxes', ['foreignKey' => 'qid']);
          
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
