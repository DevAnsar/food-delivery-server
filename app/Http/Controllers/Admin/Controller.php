<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller as MainController;
use App\Http\Resources\v1\CityCollection;
use App\Models\City;
use App\Models\Product;
use App\Models\Provider;
use App\Models\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class Controller extends MainController
{
    use AuthenticatesUsers;
    public function admin_login(Request $request){
        try {
            $this->validateLogin($request);
            if (method_exists($this, 'hasTooManyLoginAttempts') && $this->hasTooManyLoginAttempts($request)) {
                $this->fireLockoutEvent($request);
                return $this->sendLockoutResponse($request);
            }
            if ($this->attemptLogin($request)) {
                $user=$this->guard()->user();
                return $this->res([
                    'token'=>$user->createToken($user->mobile)->plainTextToken
                ],'ورود موفق',true);
            }
            $this->incrementLoginAttempts($request);
            return $this->res('','کاربر با مشخصات مورد نظر یافت نشد',false);

        }catch (\Exception $exception){
            return $this->res('',$this->SystemErrorMessage,false);
        }
    }

    public function dashboard(Request  $request){
        try {
            $users=User::all()->count();
            $providers=Provider::all()->count();
            $products=Product::all()->count();
            $orders=0;
            return $this->res([
                'users'=>number_format($users),
                'providers'=>number_format($providers),
                'products'=>number_format($products),
                'orders'=>number_format($orders)
            ],'اطلاعات داشبورد مدیریت');

        }catch (\Exception $exception){
            return $this->res('',$this->SystemErrorMessage,false);
        }
    }
}
