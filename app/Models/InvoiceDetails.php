<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvoiceDetails extends Model
{
    protected $table = "invoice_details";
    
    protected $fillable = [
        'invoice_id',
        'invoice_number',
        'product_id',
        'category_id',
        'status',
        'note',
        'user_id',
        'payment_date',
    ];

    function getStatusAttribute($val){
        if ($val == 0) {
            return "غير مدفوعه";
        }elseif($val == 1){
            return "مدفوعه" ;
        }elseif($val == 2){
            return "مدفوعه جزئيا" ;
        }
    }

    public function user(){
        return $this->belongsTo('App\User','user_id');
    }
}
