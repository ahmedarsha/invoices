<?php

namespace App\Models;

use App\Observers\InvoiceObserver;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Invoice extends Model
{
    protected $table = "invoices";
    use SoftDeletes;

    public static function boot()
    {
        parent::boot();
        Invoice::observe(InvoiceObserver::class);
    }
    
    protected $fillable = [
        'invoice_number',
        'invoice_date',
        'due_date',
        'product_id',
        'category_id',
        'amount_collection',
        'amount_commission',
        'discount',
        'value_VAT',
        'rate_VAT',
        'total',
        'status',
        'note',
        'payment_date',
    ];

    protected $dates = ['deleted_at'];
     
    function scopeSelection($query){
        return $query->select(
            'id',
            'invoice_number',
            'invoice_date',
            'due_date',
            'product_id',
            'category_id',
            'amount_collection',
            'amount_commission',
            'discount',
            'value_VAT',
            'rate_VAT',
            'total',
            'status',
            'note',
            'payment_date',
        );
    } 

    function getStatusAttribute($val){
        if ($val == 0) {
            return "غير مدفوعه";
        }elseif($val == 1){
            return "مدفوعه" ;
        }elseif($val == 2){
            return "مدفوعه جزئيا" ;
        }
    }
    public function category(){
        return $this->belongsTo('App\Models\category','category_id');
    }
    public function product(){
        return $this->belongsTo('App\Models\Product','product_id');
    }
}
