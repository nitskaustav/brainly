<?php

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Order Entity.
 *
 * @property int $id
 * @property int $customer_id
 * @property \App\Model\Entity\Customer $customer
 * @property string $customer_name
 * @property int $address_id
 * @property \App\Model\Entity\Address $address
 * @property string $address_name
 * @property int $run_id
 * @property \App\Model\Entity\Run $run
 * @property string $run_name
 * @property \Cake\I18n\Time $order_date
 * @property \Cake\I18n\Time $delivery_date
 * @property string $comment
 * @property string $payment_status
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 * @property \App\Model\Entity\Orderdetail[] $orderdetails
 */
class Prescription extends Entity {

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        '*' => true,
        'id' => false,
    ];

}
