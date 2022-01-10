<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Resources\Json\ResourceCollection;

class CityCollection extends ResourceCollection
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
                'title'=>$item->title,
                'name'=>$item->name,
                'slug'=>$item->slug
            ];
            if ($item->parent_id == 0){
                $data=array_merge($data,['units'=>new CityCollection($item->units)]);
            }
            return $data;
        });
    }
}
