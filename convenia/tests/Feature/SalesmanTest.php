<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Salesman;

class SalesmanTest extends TestCase
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

    public function testNewSalesman()
    {
    	$response = $this->json('POST', 'api/salesman', ['name' => 'Sally', 'email' => 'sally@email.com']);
    	$return = ['name' => 'Sally', 'email' => 'sally@email.com', 'commission' => '0.085', 'id' => 1];

    	$response->assertJson([$return]);
    }

    public function testListSalesman()
    {
    	$response = $this->json('GET', 'api/salesman');
    	$result = [
	    	"dados"=> [
		    	[
			    	"id" => 1,
			    	"name" => "Nome do Vendedor 1",
			    	"email" => "emaildovendedor1@gmail.com",
			    	"commission" => "0.085"
		    	],
		    	[
			    	"id" => 2,
			    	"name" => "Nome do Vendedor 2",
			    	"email" => "emaildovendedor2@gmail.com",
			    	"commission" => "0.085"
		    	],
		    	[
			    	"id" => 3,
			    	"name" => "Nome do Vendedor 3",
			    	"email" => "emaildovendedor3@gmail.com",
			    	"commission" => "0.085"
		    	],
		    	[
			    	"id" => 4,
			    	"name" => "Nome do Vendedor 4",
			    	"email" => "emaildovendedor4@gmail.com",
			    	"commission" => "0.085"
		    	]
	    	]
    	];

    	$response->assertJson([$result]);
    }

    public function testSalesmanSales()
    {
    	$response = $this->json('GET', '/salesman/2/sales');
    	$result = [
	    	"dados"=> [
		    	"id" => 2,
		    	"name" => "Nome do Vendedor 2",
		    	"email" => "emaildovendedor2@gmail.com",
		    	"commission" => "0.085",
		    	"sales" => [
			    	[
				    	"id" => 6,
				    	"sale_value" => "149.90",
				    	"sale_commission" => "12.74",
				    	"sale_date" => "2017-07-03"
			    	],[
				    	"id" => 18,
				    	"sale_value" => "49.90",
				    	"sale_commission" => "4.24",
				    	"sale_date" => "2017-07-05"
			    	],[
				    	"id" => 19,
				    	"sale_value" => "249.90",
				    	"sale_commission" => "21.24",
				    	"sale_date" => "2017-07-07"
			    	]
		    	]
	    	]
    	];

    	$response->assertJson([$result]);
    }
}