<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'addressable_id',
        'addressable_type',
        'name',
        'address',
        'city_id',
        'area_id',
        'lat',
        'lng',
        'floor',
        'unit'
    ];

    public function addressable()
    {
        return $this->morphTo();
    }
//    /**
//     * @return \Illuminate\Database\Eloquent\Relations\HasOne
//     */
//    public function user(){
//        return $this->hasOne(User::class,'id','user_id');
//    }
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function city(){
        return $this->hasOne(City::class,'id','city_id');
    }
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function area(){
        return $this->hasOne(City::class,'id','area_id');
    }
}
