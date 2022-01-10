<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\v1\CityCollection;
use App\Models\City;
use Illuminate\Http\Request;

class CityController extends Controller
{
    public function cities(){
        try{
            $cities=City::where('parent_id','=',0)->get();
            $citiesCollection = new CityCollection($cities);
            return  response()->json($citiesCollection);
        }catch(\Exception $exception){
            return $exception;
        }
    }
}
