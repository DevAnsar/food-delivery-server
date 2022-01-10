<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public $SystemErrorMessage="مشکلی پیش آمد لطفا دوباره تلاش کنید";

    public function res($data,$message='',$status=true){
        return response()->json(['data'=>$data,'message'=>$message,'status'=>$status]);
    }
}
