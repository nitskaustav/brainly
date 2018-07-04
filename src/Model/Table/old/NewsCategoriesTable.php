<?php
namespace App\Model\Table;

use Cake\ORM\Table;

class NewsCategoriesTable extends Table {
	public function initialize(array $config) {
	$this->table('news_categories');
        $this->primaryKey('id');

        $this->belongsTo('News', ['className' => 'News', 'foreignKey' => 'news_id', 'propertyName' => 'News' ]);
        $this->belongsTo('Categories', ['className' => 'Categories', 'foreignKey' => 'category_id', 'propertyName' => 'Categories']);
    }
    
    
    
    
}     