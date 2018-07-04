<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\RunsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\RunsTable Test Case
 */
class RunsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\RunsTable
     */
    public $Runs;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.runs',
        'app.addresses',
        'app.customers',
        'app.orders',
        'app.orderdetails',
        'app.products',
        'app.suppliers',
        'app.templates'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Runs') ? [] : ['className' => 'App\Model\Table\RunsTable'];
        $this->Runs = TableRegistry::get('Runs', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Runs);

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
}
