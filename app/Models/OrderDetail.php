<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    protected $table = 'orderdetails';
    protected $fillable =[
        'idOrder','idProduct','quantity','price'
    ];

    public function Product(){
        return $this->belongsTo('App\Models\Product','idProduct','id');
    }

    public function Oder(){
        return $this->belongsTo('App\Models\Order','idOrder','id');
    }
}
