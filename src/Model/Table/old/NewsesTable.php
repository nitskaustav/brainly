<?php

namespace App\Model\Table;

use App\Model\Entity\Run;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Runs Model
 *
 * @property \Cake\ORM\Association\HasMany $Addresses
 * @property \Cake\ORM\Association\HasMany $Orders
 */
class NewsesTable extends Table {

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config) {
        parent::initialize($config);

        $this->table('newses');
        //$this->displayField('id');
        $this->primaryKey('id');

        $this->belongsTo('Treatments', ['className' => 'Treatments', 'foreignKey' => 'treatment_id', 'propertyName' => 'Treatments' ]);
        $this->hasMany('NewsCategories', ['className' => 'NewsCategories', 'foreignKey' => 'news_id', 'propertyName' => 'NewsCategories']);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */


}
