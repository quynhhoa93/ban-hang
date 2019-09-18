<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductType extends Model
{
    protected $table = 'producttypes';

    protected $fillable = [
        'name','idCategory','slug','status',
    ];

    public function Category(){
        return $this->belongsTo('App\Models\Categories','idCategory','id');
    }
}
