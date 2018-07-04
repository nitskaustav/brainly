<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\OrderdetailsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\OrderdetailsTable Test Case
 */
class OrderdetailsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\OrderdetailsTable
     */
    public $Orderdetails;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.orderdetails',
        'app.orders',
        'app.products'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Orderdetails') ? [] : ['className' => 'App\Model\Table\OrderdetailsTable'];
        $this->Orderdetails = TableRegistry::get('Orderdetails', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Orderdetails);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
