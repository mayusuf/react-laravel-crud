<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Category;

class ApiCategory extends Controller
{
    public function getCategories() {
      
    	$categories['categories'] = Category::get();

    	return response($categories, 200);
    }
}
