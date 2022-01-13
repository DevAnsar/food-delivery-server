<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\v1\ProviderCollection;
use App\Http\Resources\v1\ProviderResource;
use App\Models\Provider;
use Illuminate\Http\Request;

class ProviderController extends Controller
{
    /**
     * @param int $category_id
     * @param int $sub_category_id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index($category_id = 0, $sub_category_id = 0, Request $request)
    {
        try{
            $user=$request->user();
            $providers=Provider::query();
            if ($category_id != 0){
                $providers->where('category_id','=',$category_id);
            }
            if ($sub_category_id != 0){
                $providers->where('sub_category_id','=',$sub_category_id);
            }
            return $this->res([
                'providers'=>new ProviderCollection($providers->get(),$user)
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

    public function provider_like_or_dislike($provider_id,Request $request){
        try{
            $user=$request->user();
            $provider=Provider::query()->where('id','=',$provider_id)->first();
            if ($provider){
                $favorite=$user->favorites()->where('provider_id','=',$provider_id)->first();
                if($favorite){
                    $favorite->delete();
                    $stage=false;
                }else{
                    $user->favorites()->create(['provider_id'=>$provider_id]);
                    $stage=true;
                }
                return $this->res([
                    'stage'=>$stage
                ],'درخواست ثبت شد');
            }else{
                return $this->res('','سرویس دهنده ای برای درخواست شما پیدا نشد',false);
            }
        }catch (\Exception $exception){
            return $this->res('',$this->SystemErrorMessage,false);
        }
    }
}
