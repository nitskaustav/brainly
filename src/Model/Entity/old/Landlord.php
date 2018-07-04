<?php

namespace App\Model\Entity;
use Cake\ORM\Entity;

class Landlord extends Entity {

    // Code from bake.

    protected $_accessible = [
        '*' => true,
        'id' => false,
    ];    
}
