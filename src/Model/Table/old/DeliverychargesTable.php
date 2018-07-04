<?php
namespace App\Model\Table;

use Cake\ORM\Table;

class DeliverychargesTable extends Table {
	public function initialize(array $config) {
	$this->table('deliverycharges');
        $this->primaryKey('id');
    }
}     