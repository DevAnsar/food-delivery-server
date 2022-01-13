<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ProviderCollection extends ResourceCollection
{
    public $user;
    /**
     * Create a new resource instance.
     *
     * @param  mixed  $resource
     * @return void
     */
    public function __construct($resource,$user=false)
    {
        parent::__construct($resource);

        $this->resource = $this->collectResource($resource);
        $this->user=$user;
    }
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return $this->collection->map(function ($item){
        $data=[
            'id'=>$item->id,
            'slug'=>$item->slug,
            'categoryId'=>$item->category_id,
            'subCategoryId'=>$item->sub_category_id,
            'name'=>$item->name,
            'image'=>$item->image,
            'description'=>$item->description,
            'deliveryTime'=>$item->delivery_time,
        ];
        if ($this->user){
            $data= array_merge($data,[
                'like'=> $item->favorites()->where('user_id','=',$this->user->id)->count() > 0 ,
            ]);
        }
        return $data;
        });
    }
}
