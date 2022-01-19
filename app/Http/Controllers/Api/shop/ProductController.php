<?php

namespace App\Http\Controllers\Api\shop;

use App\Http\Controllers\Controller;
use App\Http\Requests\MenuRequest;
use App\Http\Resources\v1\MenuCollection;
use App\Http\Resources\v1\MenuResource;
use App\Models\Product;
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

    public function get_product($menu_id,$product_id,Request  $request){
        try{
            $user=$request->user();
            $provider=$user->provider;
            if ($provider){
//                $menu=$provider->menus()->where('id',$menu_id)->first();
                $product=Product::find($product_id);
                if ($product && $product->user_id == $user->id){

                    return  $this->res(['product'=>$product],'مشخصات محصول');
                }else{
                    return  $this->res('','آیتم مورد نظر یافت نشد',false);
                }
            }else{
                return  $this->res('','فروشگاه یافت نشد',false);
            }
        }catch(\Exception $exception){
            return  $this->res('',$this->SystemErrorMessage,false);
        }
    }
    public function edit_products($menu_id,$product_id,Request $request){
        try{
            $user=$request->user();
            $provider=$user->provider;
            if ($provider){
                $menu=$provider->menus()->where('id',$menu_id)->first();
                if ($menu){
                    $product=Product::find($product_id);
                    $product->update([
                        'title'=>$request->input('title'),
                        'price'=>$request->input('price')
                    ]);
                    return  $this->res('','محصول با موفقیت ویرایش شد');
                }else{
                    return  $this->res('','آیتم مورد نظر یافت نشد',false);
                }
            }else{
                return  $this->res('','فروشگاه یافت نشد',false);
            }
        }catch(\Exception $exception){
            return  $this->res('',$this->SystemErrorMessage,false);
        }
    }

    public function create_products($menu_id,Request $request){
        try{
            $user=$request->user();
            $provider=$user->provider;
            if ($provider){
                $menu=$provider->menus()->where('id',$menu_id)->first();
                if ($menu){
                    //                $last_menu=$provider->menus()->orderBy('order','desc')->first();
                    $product=$menu->products()->create([
                        'user_id'=>$user->id,
                        'provider_id'=>$provider->id,
                        'title'=>$request->input('title'),
                        'price'=>$request->input('price')
                    ]);
                    return  $this->res('','محصول با موفقیت افزوده شد');
                }else{
                    return  $this->res('','آیتم مورد نظر یافت نشد',false);
                }
            }else{
                return  $this->res('','فروشگاه یافت نشد',false);
            }
        }catch(\Exception $exception){
            return  $this->res('',$exception->getMessage(),false);
        }
    }

    public function products_destroy($menu_id,$product_id,Request  $request){
        try{
            $user = $request->user();
            $provider=$user->provider;
            if ($provider){
                $menu=$provider->menus()->where('id',$menu_id)->first();
                if ($menu){
                    $product=Product::find($product_id);
                    $product->delete();
                    return  $this->res($menu,'محصول با موفقیت حذف شد');
                }else{
                    return  $this->res('','آیتم مورد نظر یافت نشد',false);
                }
            }else{
                return  $this->res('','فروشگاه یافت نشد',false);
            }
        }catch(\Exception $exception){
            return  $this->res('',$this->SystemErrorMessage,false);
        }
    }


}
