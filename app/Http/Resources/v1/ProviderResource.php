<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Resources\Json\JsonResource;

class ProviderResource extends JsonResource
{
    protected $withMenu;
    /**
     * Create a new resource instance.
     *
     * @param  mixed  $resource
     * @return void
     */
    public function __construct($resource,$withMenu=false)
    {
        $this->resource = $resource;
        $this->withMenu=$withMenu;
    }
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
            'categoryId'=>$this->category_id,
            'subCategoryId'=>$this->sub_category_id,
            'name'=>$this->name,
            'slug'=>$this->slug,
            'image'=>$this->image,
            'description'=>$this->description,
            'deliveryTime'=>$this->delivery_time,
        ];
        if($this->withMenu){
            $data=array_merge($data,[
                'menu'=>new ProviderMenuCollection($this->menus()->orderBy('order','asc')->get(),true)
            ]);
        }
        return $data;
    }
}
