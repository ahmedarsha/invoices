<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = "products";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
     protected $fillable = [
        'name','description','category_id'
    ];

    function scopeSelection($query){
        return $query->select('id','name','description','category_id');
    }
    public function category(){
         return $this->belongsTo('App\Models\category','category_id');
     }
}
