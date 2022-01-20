<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'providerId'=>$this->provider_id,
            'menuId'=>$this->menu_id,
            'title'=>$this->title,
            'image'=>$this->image,
            'description'=>$this->description,
            'price'=>$this->price,
            'priceText'=>number_format($this->price),
        ];
    }
}
