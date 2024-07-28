<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModalDetail extends Model
{
    use HasFactory;

    public function modal()
    {
        return $this->belongsTo(Modal::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
