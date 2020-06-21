<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

use App\Movie;

use DB;

class ApiController extends Controller
{
    public function getMovies() {

        $allmovies['movies'] = DB::table('movies')
        ->join('categories','movies.cat_id','=','categories.cat_id')->get();

    	return response($allmovies, 200);
    }

    public function createMovie(Request $request) {

      // logic to create a student record goes here

    	request()->validate([
	        'title' => 'required',
	        'cover' => 'required',
	        'cat_id' => 'required',
	        'descrp' =>'required',
	        'cnt_pro' =>'required',
    	]);

        $cover = $request->file('cover');
    	$extension = $cover->getClientOriginalExtension();
    	Storage::disk('public')->put($cover->getFilename().'.'.$extension,  File::get($cover));

	    $movie = new Movie;
	    $movie->title = $request->title;
	    
	    $movie->cover = $cover->getFilename().'.'.$extension;

	    $movie->cat_id = $request->cat_id;
	    $movie->descrp = $request->descrp;
	    $movie->cnt_pro = $request->cnt_pro;
	    $movie->save();

	    return response()->json([
	    	"message" => "Movie record created Successfully..",

	    ], 201);
	  
    }

    public function getMovie($id) {
      // logic to get a student record goes here

    	$singleMovie['movie'] = DB::table('movies')
        ->join('categories','movies.cat_id','=','categories.cat_id')
        ->where('movies.id',"=",$id)
        ->get();

    	return response($singleMovie, 200);
    }

    public function updateMovie(Request $request,$id) {
      // logic to update a student record goes here

    	request()->validate([
	        'title' => 'required',
	        'cover' => 'required',
	        'cat_id' => 'required',
	        'descrp' =>'required',
	        'cnt_pro' =>'required',
    	]);

    	$rest_json = file_get_contents("php://input");
    	$_POST = json_decode($rest_json, true);

    	$movie = Movie::find($id);   

    	if($_POST['cover'] == "noNewFile"){

    		rename("covers/$movie->cover", "covers/$request->title.jpeg");

    	}else{
	    	$cover = str_replace('data:image/jpeg;base64,','',$_POST['cover']);
	    	$cover = str_replace(' ','+',$cover);
	    	file_put_contents(__DIR__ ."test.jpeg",base64_decode($cover));

	    	$source = 'test.jpeg';  
	  
			// Store the path of destination file 
			$destination = 'covers/test.jpeg';  
	  
			// Copy the file from /user/desktop/geek.txt  
			if( !copy($source, $destination) ) {  
	    		echo "File can't be copied! \n";  
			}

			rename("covers/test.jpeg", "covers/$request->title.jpeg");
		}

                   
	    
	    $movie->title = $request->title;
	    
	    $movie->cover = $request->title.".jpeg";

	    $movie->cat_id = $request->cat_id;
	    $movie->descrp = $request->descrp;
	    $movie->cnt_pro = $request->cnt_pro;
	    $movie->save();

	    return response()->json([
	    	"message" => "Movie record updated Successfully..",

	    ], 201);	
    }

    public function deleteMovie($id) {
      	
      	$movie = Movie::find($id);
        $movie->delete();

        return response()->json([
          "message" => "records deleted"
        ], 202);
    }
}
