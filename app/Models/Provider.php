<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Provider extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'name',
        'image',
        'category_id',
        'sub_category_id',
        'delivery_time',
        'description',
    ];
    public function user(){
        return $this->hasOne(User::class,'id','user_id');
    }

    public function category(){
        return $this->hasOne(Category::class,'id','category_id');
    }
}
