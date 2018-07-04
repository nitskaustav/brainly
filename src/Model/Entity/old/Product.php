<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Product Entity.
 *
 * @property int $id
 * @property int $supplier_id
 * @property \App\Model\Entity\Supplier $supplier
 * @property string $description
 * @property float $costprice
 * @property string $weight
 * @property float $p1
 * @property float $p2
 * @property float $p3
 * @property float $p4
 * @property float $p5
 * @property string $gst
 * @property string $min_qty
 * @property string $mon_avail
 * @property string $tue_avail
 * @property string $wed_avail
 * @property string $thu_avail
 * @property string $fri_avail
 * @property string $sat_avail
 * @property string $sun_avail
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 * @property \App\Model\Entity\Orderdetail[] $orderdetails
 */
class Product extends Entity
{

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
