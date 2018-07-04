<?php
namespace App\Model\Table;

use Cake\ORM\Table;

class PilsTable extends Table {
	public function initialize(array $config) {
	$this->table('pils');
        $this->displayField('title');
        $this->primaryKey('id');
        
        // $this->hasMany('Pils', ['foreignKey' => 'mid']);

        $this->belongsTo('Treatments', ['className' => 'Treatments', 'foreignKey' => 'tid', 'propertyName' => 'Treatments' ]);
        $this->belongsTo('Medicines', ['className' => 'Medicines', 'foreignKey' => 'mid', 'propertyName' => 'Medicines' ]);
        //$this->belongsTo('Pilprices', ['className' => 'Pilprices', 'foreignKey' => 'pilid', 'propertyName' => 'Pilprices' ]);
        
        $this->hasMany('Pilprices', ['foreignKey' => 'pilid']);
        $this->hasMany('Orderdetails', ['foreignKey' => 'pil_id']);
        
    }
}     