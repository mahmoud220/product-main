<?php

namespace App;
use Illuminate\Database\Eloquent\Model;


class Product extends Model
{

    protected $fillable = ['name', 'description', 'price', 'category_id', 'image'];


    public function categories()
    {
        return $this->belongsTo('App\Category', 'category_id','id');
    }

    // public function getProductPriceById (int $id) {

    //     return $this::find($id)->price;
    // }
}
