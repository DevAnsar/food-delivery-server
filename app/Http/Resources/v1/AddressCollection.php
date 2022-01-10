<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Resources\Json\ResourceCollection;

class AddressCollection extends ResourceCollection
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
                'name'=>$item->name,
                'address'=>$item->address,
                'city_id'=>$item->city_id,
                'city'=>new CityResource($item->city),
                'area_id'=>new CityResource($item->area),
                'floor'=>$item->floor,
                'unit'=>$item->unit,
                'lat'=>$item->lat,
                'lng'=>$item->ing
            ];
            return $data;
        });
    }
}
