<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ProviderMenuCollection extends ResourceCollection
{
    protected $withProducts;
    /**
     * Create a new resource instance.
     *
     * @param  mixed  $resource
     * @return void
     */
    public function __construct($resource,$withProducts=false)
    {
        parent::__construct($resource);

        $this->resource = $this->collectResource($resource);
        $this->withProducts=$withProducts;
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
                'title'=>$item->title
            ];
            if ($this->withProducts){
                $data=array_merge($data,[
                    'products'=>new ProductCollection($item->products)
                ]);
            }
            return $data;
        });
    }
}
