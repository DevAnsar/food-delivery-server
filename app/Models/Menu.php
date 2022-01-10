<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'order',
        'provider_id',
    ];
    public function provider(){
        return $this->hasOne(Provider::class,'id','provider_id');
    }
}
