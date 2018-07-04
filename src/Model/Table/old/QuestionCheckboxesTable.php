<?php
namespace App\Model\Table;

use Cake\ORM\Table;

class QuestionCheckboxesTable extends Table {
	public function initialize(array $config) {
	$this->table('question_checkboxes');
        $this->primaryKey('id');
    }
}     