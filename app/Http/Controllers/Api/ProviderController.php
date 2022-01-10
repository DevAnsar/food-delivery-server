<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\v1\ProviderCollection;
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
            return $this->res(new ProviderCollection($providers->get()),'لیست ارائه دهنده خدمات');
        }catch (\Exception $exception){
            return $this->res('',$this->SystemErrorMessage,false);
        }
    }
}
