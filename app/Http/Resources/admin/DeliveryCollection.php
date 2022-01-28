<?php

namespace App\Http\Resources\admin;

use Illuminate\Http\Resources\Json\ResourceCollection;

class DeliveryCollection extends ResourceCollection
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
                'user'=> new UserResource($item->user),
                'description'=>$item->description,
                'image'=>$item->image
            ];
            return $data;
        });
    }
}
