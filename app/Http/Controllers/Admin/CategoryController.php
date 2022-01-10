<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\v1\CategoryCollection;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function categories(){
        try{
            $categories=Category::where('parent_id','=',0)->get();
            return  response()->json($categories);
        }catch(\Exception $exception){
            return $exception;
        }
    }
}
