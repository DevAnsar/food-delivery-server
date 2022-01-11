<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|void
     */
    public function check_phone_number(Request $request){
        try {
            $this->validate($request,[
                'phone'=>'required|size:11'
            ]);

            $mobile=$request->phone;
            $potential_user_query=User::query()->where('mobile','=',$mobile);
            $login_code=$this->generateRandomNumber(4);
            if ($potential_user_query->count() > 0){
                $user = $potential_user_query->first();
                $user->update(['login_code'=>$login_code]);
            }else{
                User::query()->create([
                    'mobile'=>$mobile,
                    'login_code'=>$login_code,
                ]);
            }
            //send login code to phone number
            return  $this->res([
                'loginCode'=>$login_code,
                'mobile'=>$mobile
            ],'رمز یکبار مصرف تولید شد');
        }catch (\Exception $exception){
            return  $this->res('',$this->SystemErrorMessage,false);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|void
     */
    public function check_login_code(Request $request){
        try {
            $this->validate($request,[
                'phone'=>'required|size:11',
                'code'=>'required|size:4'
            ]);

            $mobile=$request->phone;
            $code=$request->code;
            $potential_user_query=User::query()->where('mobile','=',$mobile);
            if ($potential_user_query->count() > 0){
                $user = $potential_user_query->first();
                if ($user->login_code == $code){
                    //generate auth token
                    $token = $user->createToken($user->mobile);
                    return  $this->res(['token'=>$token->plainTextToken],'با موفقیت وارد شدید',true);
                }else{
                    return  $this->res('','کد وارد شده صحیح نمیباشد',false);
                }
            }else{
                return  $this->res('','کاربر یافت نشد',false);
            }
        }catch (\Exception $exception){
            return  $this->res('',$this->SystemErrorMessage,false);
        }
    }
}
