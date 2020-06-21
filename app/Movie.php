<?php

/*
 ORM for movie table.
 Insert, update, delete and get of movies
*/

namespace App;

use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    protected $table = 'movies';

    protected $fillable = ['title', 'cover','cat_id','descrp','cnt_pro','is_deleted'];
}
