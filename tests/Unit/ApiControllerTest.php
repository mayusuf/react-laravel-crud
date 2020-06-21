<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;


class ApiControllerTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */

    protected $movie;

	public function setUp():void{

		$this->movie = new \App\Http\Controllers\ApiController;
		

	}

	public function testIsExistGetAllMovies(){

		$this->assertTrue($this->movie->getAllMovies());

	}
    
	
}
