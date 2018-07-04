<?php
namespace App\Model\Table;

use Cake\ORM\Table;

class TreatmentCategoriesTable extends Table {
	public function initialize(array $config) {
	$this->table('treatment_categories');
        $this->primaryKey('id');
        
        $this->belongsTo('Categories', ['className' => 'Categories', 'foreignKey' => 'catid', 'propertyName' => 'Categories' ]);
        $this->belongsTo('Treatments', ['className' => 'Treatments', 'foreignKey' => 'trid', 'propertyName' => 'Treatments' ]);
    }
    
}     