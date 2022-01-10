<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'provider_id',
        'menu_id',
        'title',
        'description',
        'price',
        'image',
    ];
    public function user(){
        return $this->hasOne(User::class,'id','user_id');
    }

    public function provider(){
        return $this->hasOne(Provider::class,'id','provider_id');
    }

    public function menu(){
        return $this->hasOne(Menu::class,'id','menu_id');
    }
}
