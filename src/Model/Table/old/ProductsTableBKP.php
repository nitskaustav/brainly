<?php
namespace App\Model\Table;

use App\Model\Entity\Product;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Products Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Suppliers
 * @property \Cake\ORM\Association\HasMany $Orderdetails
 */
class ProductsTable extends Table {

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config){
        parent::initialize($config);

        $this->table('products');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Suppliers', [
            'foreignKey' => 'supplier_id'
        ]);
        $this->hasMany('Orderdetails', [
            'foreignKey' => 'product_id'
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator){
        $validator
            ->allowEmpty('id', 'create');

        $validator
            ->requirePresence('description', 'create')
            ->notEmpty('description');

        $validator
            ->requirePresence('description', 'create')
            ->notEmpty('description');

        $validator
            ->numeric('costprice')
            ->requirePresence('costprice', 'create')
            ->notEmpty('costprice');
			
        $validator
            ->requirePresence('weight', 'create')
            ->notEmpty('weight');
			
        $validator
            ->numeric('p1')
            ->requirePresence('p1', 'create')
            ->notEmpty('p1');
			
        $validator
            ->numeric('p2')
            ->requirePresence('p2', 'create')
            ->notEmpty('p2');
			
        $validator
            ->numeric('p3')
            ->requirePresence('p3', 'create')
            ->notEmpty('p3');

        $validator
            ->numeric('p4')
            ->requirePresence('p4', 'create')
            ->notEmpty('p4');
			
        $validator
            ->numeric('p5')
            ->requirePresence('p5', 'create')
            ->notEmpty('p5');


        /* $validator
             ->numeric('p5')
             ->allowEmpty('p5');  */


        $validator
            ->requirePresence('gst', 'create')
            ->notEmpty('gst');
			
        $validator
            ->requirePresence('min_qty', 'create')
            ->notEmpty('min_qty');
			
        $validator
            ->requirePresence('mon_avail', 'create')
            ->notEmpty('mon_avail');
			
        $validator
            ->requirePresence('tue_avail', 'create')
            ->notEmpty('tue_avail');
			
        $validator
            ->requirePresence('wed_avail', 'create')
            ->notEmpty('wed_avail');
			
        $validator
            ->requirePresence('thu_avail', 'create')
            ->notEmpty('thu_avail');
			
        $validator
            ->requirePresence('fri_avail', 'create')
            ->notEmpty('fri_avail');
			
        $validator
            ->requirePresence('sat_avail', 'create')
            ->notEmpty('sat_avail');
			
        $validator
            ->requirePresence('sun_avail', 'create')
            ->notEmpty('sun_avail');
			
        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules){
        $rules->add($rules->existsIn(['supplier_id'], 'Suppliers'));
        return $rules;
    }
}
