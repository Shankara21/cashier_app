<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orderDetails()
    {
        return $this->hasMany(OrderDetails::class);
    }

    public function modal_details()
    {
        return $this->hasMany(ModalDetail::class);
    }
}
