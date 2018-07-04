<?php

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Run Entity.
 *
 * @property int $id
 * @property string $run_name
 * @property string $run_no
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 * @property \App\Model\Entity\Address[] $addresses
 * @property \App\Model\Entity\Order[] $orders
 */
class TreatmentCategory extends Entity {

    protected $_accessible = [
        '*' => true,
        'id' => false,
    ];

}
