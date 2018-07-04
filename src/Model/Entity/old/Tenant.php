<?php

namespace App\Model\Entity;
use Cake\ORM\Entity;

class Tenant extends Entity {

    // Code from bake.

    protected $_accessible = [
        '*' => true,
        'id' => false,
    ];    
}
