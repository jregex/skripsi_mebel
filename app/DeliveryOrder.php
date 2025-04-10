<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryOrder extends Model
{
    use HasFactory;

    protected $guarded=['id'];

    public function details()
    {
        return $this->hasMany(DeliveryOrderDetails::class, 'kode_delivery_order', 'kode_delivery_order');
    }
}
