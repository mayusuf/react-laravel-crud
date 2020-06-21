<?php
/*
 Business logic applies in this controller regarding movie
*/
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

use App\Movie;

use DB;

class ApiController extends Controller
{
    // Retive all movies. Apply GET method
    // return : status code
    public function getMovies() {

        $allmovies['movies'] = DB::table('movies')
        ->join('categories','movies.cat_id','=','categories.cat_id')->get();

    	return response($allmovies, 200);
    }

    // Insert movie information by applying POST method
    // $request : Data about movie which are given into form 
    // return : response status code 201 along with message
    public function createMovie(Request $request) {

      

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

    // Retive a single movie information conjunction with category by applying GET method
    // $id : numeric 
    // return movie information along with response status code

    public function getMovie($id) {
      
    	$singleMovie['movie'] = DB::table('movies')
        ->join('categories','movies.cat_id','=','categories.cat_id')
        ->where('movies.id',"=",$id)
        ->get();

    	return response($singleMovie, 200);
    }

    
    // Update movie information  by applying PUT method
    // $request : Data about movie which are given into edit form 
    // $id : numeric 
    // return response status code along with message

    public function updateMovie(Request $request,$id) {
      

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

    // Delete movie information  by applying DELETE method
    // $id : numeric 
    // return response status code along with message

    public function deleteMovie($id) {
      	
      	$movie = Movie::find($id);
        $movie->delete();

        return response()->json([
          "message" => "records deleted"
        ], 202);
    }
}
