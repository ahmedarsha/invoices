<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class category extends Model
{
    protected $table = "categories";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
     protected $fillable = [
        'name','description','created_by'
    ];

    function scopeSelection($query){
        return $query->select('id','name','description');
    }

}
