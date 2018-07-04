<?php
namespace App\Model\Table;

use Cake\ORM\Table;

class EventImagesTable extends Table {
	public function initialize(array $config) {
	$this->table('event_images');
        $this->primaryKey('id');
    }
}     