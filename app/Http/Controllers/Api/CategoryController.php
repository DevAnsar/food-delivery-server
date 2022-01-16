<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\v1\CategoryCollection;
use App\Http\Resources\v1\ProviderCollection;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function categories(Request  $request){
        try{
           $user=$request->user() ? $request->user() : false;
           $categories=Category::where('parent_id','=',0)->get();
            $firstCategoryProviders=$categories->first()->providers;
           return  $this->res([
               'categories'=>new CategoryCollection($categories),
               'providers'=>new ProviderCollection($firstCategoryProviders,$user),
           ],'لیست دسته بندی ها');
        }catch(\Exception $exception){
            return  $this->res('',$this->SystemErrorMessage,false);
        }
    }
}
