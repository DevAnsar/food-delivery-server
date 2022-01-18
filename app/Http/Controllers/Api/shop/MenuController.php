<?php

namespace App\Http\Controllers\Api\shop;

use App\Http\Controllers\Controller;
use App\Http\Requests\MenuRequest;
use App\Http\Resources\v1\MenuCollection;
use App\Http\Resources\v1\MenuResource;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function menus(Request  $request){
        try{
            $user=$request->user();
            $provider=$user->provider;
            if ($provider){
                $menus=$provider->menus()->orderBy('order','asc')->get();
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
            $user = $request->user();
            $provider=$user->provider;
            if ($provider){
                $menu=$provider->menus()->where('id',$menu_id)->first();
                if ($menu){
                    $menu->delete();
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

    public function get_menu($id,Request  $request){
        try{
            $user=$request->user();
            $provider=$user->provider;
            if ($provider){
                $menu=$provider->menus()->where('id',$id)->first();
                if ($menu){
                    return  $this->res(['menu'=>new MenuResource($menu)],'مشخصات منو');
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

    public function create_menus(MenuRequest $request){
        try{
            $user=$request->user();
            $provider=$user->provider;
            if ($provider){
                $last_menu=$provider->menus()->orderBy('order','desc')->first();
                $menu=$provider->menus()->create([
                    'title'=>$request->input('title'),
                    'order'=>$last_menu?$last_menu->order+1 : 1
                ]);
                if ($menu){
                    return  $this->res('','منو با موفقیت افزوده شد');
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
    public function edit_menus($id,MenuRequest $request){
        try{
            $user=$request->user();
            $provider=$user->provider;
            if ($provider){
                $menu=$provider->menus()->where('id',$id)->first();
                if ($menu){
                    $menu->update([
                        'title'=>$request->input('title')
                    ]);
                    return  $this->res('','منو با موفقیت ویرایش شد');
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
