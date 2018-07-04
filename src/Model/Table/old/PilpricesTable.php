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
class PilpricesTable extends Table {

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config) {
        parent::initialize($config);

        $this->table('pilprices');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->belongsTo('Pils', [ 'foreignKey' => 'pilid']);

    }

}
