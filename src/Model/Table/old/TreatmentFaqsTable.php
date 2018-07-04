<?php
namespace App\Model\Table;

use Cake\ORM\Table;

class TreatmentFaqsTable extends Table {
	public function initialize(array $config) {
	$this->table('treatment_faqs');
        $this->primaryKey('id');
        
        
        $this->belongsTo('Treatments', ['className' => 'Treatments', 'foreignKey' => 'treatment_id', 'propertyName' => 'Treatments' ]);
    }
    
    
    
    
}     