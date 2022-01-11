<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Resources\Json\JsonResource;

class CityResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $data=[
            'id'=>$this->id,
            'title'=>$this->title,
            'name'=>$this->name,
            'slug'=>$this->slug
        ];
//        if ($this->parent_id == 0){
//            $data=array_merge($data,['areas'=>new CityCollection($this->units)]);
//        }
        return $data;
    }
}
