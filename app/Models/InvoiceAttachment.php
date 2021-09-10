<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvoiceAttachment extends Model
{
    protected $table = "invoice_attachments";
    protected $fillable = [
        'file_name',
        'invoice_number',
        'invoice_id',
        'Created_by',
    ];
}
