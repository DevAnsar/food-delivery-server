<?php

namespace App\Http\Controllers\Api\shop;

use App\Http\Controllers\Controller;
use App\Http\Requests\ShopInformationRequest;
use App\Http\Resources\v1\ProviderResource;
use Illuminate\Http\Request;

class InformationController extends Controller
{
    public function information(Request  $request){
        try{
            $user=$request->user();
            $provider=$user->provider;
            if ($provider){
                return  $this->res(['delivery'=>new ProviderResource($provider,false,true)],'مشخصات فروشگاه');

            }else{
                return  $this->res('','فروشگاه یافت نشد',false);
            }
        }catch(\Exception $exception){
            return  $this->res('',$this->SystemErrorMessage,false);
        }
    }
    public function information_edit(ShopInformationRequest  $request){
        try{
            $user=$request->user();
            $provider=$user->provider;
            if ($provider){
                $provider->update([
                    'name'=>$request->name,
                    'description'=>$request->description,
                    'delivery_time'=>$request->deliveryTime,
                ]);
                return  $this->res('','مشخصات فروشگاه با موفقیت ویرایش شد');

            }else{
                return  $this->res('','فروشگاه یافت نشد',false);
            }
        }catch(\Exception $exception){
            return  $this->res('',$this->SystemErrorMessage,false);
        }
    }
}
