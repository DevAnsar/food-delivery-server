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

    public function generateRandomNumber($length = 8)
    {
        $random = "";
        srand((double)microtime() * 1000000);

        $data = "102345601234567899876543210890";

        for ($i = 0; $i < $length; $i++) {
            $random .= substr($data, (rand() % (strlen($data))), 1);
        }

        return $random;

    }
}
