<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class orders extends Model
{
    
    public function product()
    {
       return $this->belongsTo(Products::class, 'product_id', 'id');
    }
}
