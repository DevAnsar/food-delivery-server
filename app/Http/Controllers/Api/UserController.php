<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserInformationRequest;
use App\Http\Resources\v1\MeResource;
use App\Http\Resources\v1\ProviderCollection;
use App\Http\Resources\v1\ProviderResource;
use App\Models\Provider;
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
                    $provider = $user->provider;
                    return  $this->res([
                        'token'=>$token->plainTextToken,
                        'provider'=>$provider
                    ],'با موفقیت وارد شدید',true);
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

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function me(Request $request){
        try {

            $user=$request->user();
            if ($user){
                    return  $this->res([
                        'user'=>new MeResource($user)
                    ],'',true);
            }else{
                return  $this->res('','کاربر یافت نشد',false);
            }
        }catch (\Exception $exception){
            return  $this->res('',$this->SystemErrorMessage,false);
        }
    }

    public function update_user_information(UserInformationRequest $request){
        try {

            $user=$request->user();
            if ($user){
                $user->update([
                    'name'=>$request->name,
                    'birth'=>$request->birth,
                    'email'=>$request->email,
                    'newsletter'=>$request->newsletter
                ]);
                return  $this->res([
                    'user'=>new MeResource($user)
                ],'پروفایل آپدیت شذ');

            }else{
                return  $this->res('','کاربر یافت نشد',false);
            }
        }catch (\Exception $exception){
            return  $this->res('',$this->SystemErrorMessage,false);
        }
    }

    public function get_search(Request $request){
        try {

            $search=$request->query('search');
            if ($search){
                $providers=Provider::query()->where('name','like',"%".$search."%")->get();
                return  $this->res([
                    'results'=>new ProviderCollection($providers)
                ],'نتایج جستجو');

            }else{
                return  $this->res('','برای جستجو باید مقداری مشخص کنید',false);
            }
        }catch (\Exception $exception){
            return  $this->res('',$this->SystemErrorMessage,false);
        }
    }

    public function my_orders(Request  $request){
        try {

            $user=$request->user();
            if ($user){

                return  $this->res([
                    'myOrders'=>[]
                ],'سفارشات من');

            }else{
                return  $this->res('','کاربر یافت نشد',false);
            }
        }catch (\Exception $exception){
            return  $this->res('',$this->SystemErrorMessage,false);
        }
    }
    public function my_orders_tracking(Request  $request){
        try {

            $user=$request->user();
            if ($user){

                return  $this->res([
                    'myOrders'=>[]
                ],'پیگیری سفارش');

            }else{
                return  $this->res('','کاربر یافت نشد',false);
            }
        }catch (\Exception $exception){
            return  $this->res('',$this->SystemErrorMessage,false);
        }
    }

    public function create_provider(Request $request){
        try {

            $user=$request->user();
            if ($user){
                if($user->provider){
                    return  $this->res('','شما قبلا فروشگاه خود را ثبت رده اید',false);
                }else{
                    $provider=$user->provider()->create([
                        'name'=>$request->name,
                        'description'=>$request->description,
                        'delivery_time'=>$request->deliveryTime,
                        'category_id'=>1,
                        'sub_category_id'=>2
                    ]);
                    $provider->address()->create([
                        'name'=>$request->name,
                        'address'=>$request->address,
                        'city_id'=>$request->cityId,
                        'area_id'=>$request->areaId
                    ]);
                    return  $this->res([
                        'provider'=>new ProviderResource($provider,false,true)
                    ],'فروشگاه با موفقیت ایجاد شد');
                }
            }else{
                return  $this->res('','کاربر یافت نشد',false);
            }
        }catch (\Exception $exception){
//            return  $this->res('',$exception->getMessage(),false);
            return  $this->res('',$this->SystemErrorMessage,false);
        }
    }
}
