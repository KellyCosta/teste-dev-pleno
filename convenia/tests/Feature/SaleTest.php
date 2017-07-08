<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class SaleTest extends TestCase
{
	use DatabaseTransactions;
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
    	$this->assertTrue(true);
    }

    public function testNewSale()
    {
    	$response = $this->json('POST', 'api/sales', ['salesman_id' => 2, 'sale_value' => '249.90']);

    	$return = [
    		"dados" => [
		    	"id"=> 6,
		    	"name"=> "Sally",
		    	"email"=> "sallya@gmail.com",
		    	"sale_value"=> "249.90",
		    	"sale_commission"=> 21.24,
		    	"sale_date"=> "2017-07-07"
	    	]
    	];

    	$response->assertJson([$return]);
    }

}
