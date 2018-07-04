<?php

namespace App\Model\Table;

use Cake\ORM\Table;

class MedicineQuestionsTable extends Table {

    public function initialize(array $config) {

        $this->table('medicine_questions');
        $this->primaryKey('id');

        $this->belongsTo('Medicine', ['className' => 'Medicines', 'foreignKey' => 'mid', 'propertyName' => 'Medicines']);
        $this->belongsTo('Question', ['className' => 'Questions', 'foreignKey' => 'qid', 'propertyName' => 'Questions']);
    }

}
