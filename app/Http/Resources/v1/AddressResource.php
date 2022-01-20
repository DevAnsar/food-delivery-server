<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Resources\Json\JsonResource;

class AddressResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id'=>$this->id,
            'name'=>$this->name,
            'address'=>$this->address,
            'cityId'=>$this->city_id,
            'city'=>new CityResource($this->city),
            'areaId'=>$this->area_id,
            'area'=>new CityResource($this->area),
            'floor'=>$this->floor,
            'unit'=>$this->unit,
            'lat'=>$this->lat,
            'lng'=>$this->ing
        ];
    }
}
