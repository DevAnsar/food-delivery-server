<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory,Sluggable;
    protected $fillable = [
        'title',
        'name',
        'slug',
        'parent_id'
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

    public function sub_categories(){
        return $this->hasMany(Category::class,'parent_id','id');
    }
    public function providers(){
        return $this->hasMany(Provider::class,'category_id','id');
    }
}
