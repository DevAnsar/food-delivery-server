<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\v1\ProviderCollection;
use App\Http\Resources\v1\ProviderResource;
use App\Models\Provider;
use Illuminate\Http\Request;

class ProviderController extends Controller
{
    public function index($category_id=0,$sub_category_id=0){
        try{
            $providers=Provider::query();
            if ($category_id != 0){
                $providers->where('category_id','=',$category_id);
            }
            if ($sub_category_id != 0){
                $providers->where('sub_category_id','=',$sub_category_id);
            }
            return $this->res([
                'providers'=>new ProviderCollection($providers->get())
            ],'لیست ارائه دهنده خدمات');
        }catch (\Exception $exception){
            return $this->res('',$this->SystemErrorMessage,false);
        }
    }

    public function provider($provider_slug){
        try{
            $provider=Provider::query()->where('slug','=',$provider_slug)->first();
            if ($provider){
            return $this->res([
                'provider'=>new ProviderResource($provider,true)
            ],'مشخصات ارائه دهنده خدمات');
            }else{
                return $this->res('','سرویس دهنده ای برای درخواست شما پیدا نشد',false);
            }
        }catch (\Exception $exception){
            return $this->res('',$this->SystemErrorMessage,false);
        }
    }
}
