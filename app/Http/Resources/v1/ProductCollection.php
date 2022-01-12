<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ProductCollection extends ResourceCollection
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
                'providerId'=>$item->provider_id,
                'menuId'=>$item->menu_id,
                'title'=>$item->title,
                'image'=>$item->image,
                'description'=>$item->description,
                'price'=>$item->price,
                'priceText'=>number_format($item->price),
            ];
            return $data;
        });
    }
}
