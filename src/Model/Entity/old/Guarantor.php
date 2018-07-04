<?php

namespace App\Model\Entity;
use Cake\ORM\Entity;

class Guarantor extends Entity {

    // Code from bake.

    protected $_accessible = [
        '*' => true,
        'id' => false,
    ];    
}
