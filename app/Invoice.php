<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;
    protected $guarded=['id'];

    public function details()
    {
        return $this->hasMany(InvoiceDetails::class, 'kode_invoice', 'kode_invoice');
    }
    
}
