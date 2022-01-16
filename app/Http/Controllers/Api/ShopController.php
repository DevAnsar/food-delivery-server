<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\v1\CategoryCollection;
use App\Http\Resources\v1\MenuCollection;
use App\Http\Resources\v1\ProviderCollection;
use App\Models\Category;
use App\Models\Menu;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function menus(Request  $request){
        try{
            $user=$request->user();
            $provider=$user->provider;
            if ($provider){
                $menus=$provider->menus;
                return  $this->res([
                    'menus'=>new MenuCollection($menus),
                ],'لیست منو');
            }else{
                return  $this->res('','فروشگاه یافت نشد',false);
            }
        }catch(\Exception $exception){
            return  $this->res('',$this->SystemErrorMessage,false);
        }
    }
    public function menus_destroy($menu_id,Request  $request){
        try{
            $user=$request->user();
            $provider=$user->provider;
            if ($provider){
                $menu=$provider->menus()->where('id',$menu_id)->first();
                if ($menu){
//                    $menu->delete();
                    return  $this->res($menu,'منو با موفقیت حذف شد');
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
