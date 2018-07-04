<?php

namespace App\Model\Entity;
use Cake\ORM\Entity;

class Property extends Entity {

    // Code from bake.

    protected $_accessible = [
        '*' => true,
        'id' => false,
    ];    
}
