<?php

/*
 Business logic applies in this controller regarding category
*/

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Category;

class ApiCategory extends Controller
{
    public function getCategories() {
      
    	$categories['categories'] = Category::get();

    	return response($categories, 200);
    }

    public function createCategory(Request $request){

    	$cat = new Category;
    	$request->json()->all();

	    $cat->cat_name = $request->firstName;
	    $cat->save();

	    return response()->json([
	    	"message" => "Category record created Successfully..",

	    ], 201);
    }

}
