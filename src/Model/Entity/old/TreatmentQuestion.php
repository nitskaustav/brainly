<?php

namespace App\Model\Entity;

use Cake\ORM\Entity;

class TreatmentQuestion extends Entity {
    
    protected $_accessible = [
        '*' => true,
        'id' => false,
    ];

}
