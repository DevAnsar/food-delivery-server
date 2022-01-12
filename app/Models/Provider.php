<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Provider extends Model
{
    use HasFactory,Sluggable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'name',
        'slug',
        'image',
        'category_id',
        'sub_category_id',
        'delivery_time',
        'description',
    ];
    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }
    public function user(){
        return $this->hasOne(User::class,'id','user_id');
    }

    public function category(){
        return $this->hasOne(Category::class,'id','category_id');
    }
    public function menus(){
        return $this->hasMany(Menu::class,'provider_id','id');
    }
}
