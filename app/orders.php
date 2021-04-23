<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class orders extends Model
{
    
    public function product()
    {
       return $this->belongsTo(Products::class, 'product_id', 'id');
    }

    public function getStatusDetail(){
        switch($this->status){
            case 'CREATED': return "CREADO";
            case 'PAYED': return "PAGADO";
            case 'REJECTED': return "RECHAZADO";
        }
    }
}
