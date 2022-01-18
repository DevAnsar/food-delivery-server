<?php

namespace App\Http\Controllers\Api\shop;

use App\Http\Controllers\Controller;
use App\Http\Requests\MenuRequest;
use App\Http\Resources\v1\MenuCollection;
use App\Http\Resources\v1\MenuResource;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function products($menu_id,Request  $request){
        try{
            $user=$request->user();
            $provider=$user->provider;
            if ($provider){
                $menu=$provider->menus()->where('id',$menu_id)->first();
                if($menu){
                    $products=$menu->products;
                    return  $this->res([
                        'menu'=>$menu,
                        'products'=>$products,
                    ],'لیست محصولات منو');
                }
            }
            return  $this->res('','دریافت اطلاعات امکان پذیر نبود',false);

        }catch(\Exception $exception){
            return  $this->res('',$this->SystemErrorMessage,false);
        }
    }
}
