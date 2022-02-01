<?php

namespace App\Http\Resources\admin;

use Illuminate\Http\Resources\Json\JsonResource;

class DeliveryResource extends JsonResource
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
            'categoryId'=>$this->category_id,
            'subcategory_id'=>$this->subcategory_id,
            'userId'=>$this->user_id,
            'user'=> new UserResource($this->user),
            'category'=>$this->category,
            'description'=>$this->description,
            'image'=>$this->image,
            'deliveryTime'=>$this->delivery_time,
        ];
    }
}
