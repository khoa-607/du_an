<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'price', 'id_category', 'id_brand', 'status', 'sale', 'company', 'detail', 'image'];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user'); 
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

}
