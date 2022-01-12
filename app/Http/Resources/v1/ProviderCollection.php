<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ProviderCollection extends ResourceCollection
{
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
        return $data;
        });
    }
}
