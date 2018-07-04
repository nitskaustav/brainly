<?php
namespace App\Model\Table;

use Cake\ORM\Table;

class SiteSettingsTable extends Table {
	public function initialize(array $config) {
	$this->table('site_settings');
        $this->primaryKey('id');
       
    }
}     