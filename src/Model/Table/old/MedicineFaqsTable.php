<?php
namespace App\Model\Table;

use Cake\ORM\Table;

class MedicineFaqsTable extends Table {
	public function initialize(array $config) {
	$this->table('medicine_faqs');
        $this->primaryKey('id');
    }
}     