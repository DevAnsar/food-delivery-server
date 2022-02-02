<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\admin\providerRequest;
use App\Http\Resources\admin\DeliveryResource;
use App\Http\Resources\v1\AddressResource;
use App\Http\Resources\v1\CityCollection;
use App\Models\City;
use App\Models\Provider;
use Illuminate\Http\Request;

class DeliveryAddressController extends Controller
{

    /**
     * Display the specified resource.
     *
     */
    public function index($provider_id)
    {
        try {
            $provider=Provider::find($provider_id);

            $cities=City::where('parent_id','=',0)->get();
            $citiesCollection = new CityCollection($cities);

            if ($provider){
                return $this->res([
                    'delivery'=>new DeliveryResource($provider),
                    'address'=>$provider->address?new AddressResource($provider->address):null,
                    'cities'=>$citiesCollection
                ],'اطلاعات فروشنده');
            }else{
                return $this->res('',' فروشنده یافت نشد',false);
            }

        }catch (Exception $exception){
            return  $this->res('','مشکل در دریافت اطلاعات از سرور',false);
        }
    }

    public function update(Request $request,$provider_id)
    {
        try {
            $provider=Provider::find($provider_id);
            if ($provider){
                $data =[
                    'city_id'=>$request->input('cityId'),
                    'name'=>$request->input('name'),
                    'area_id'=>$request->input('areaId'),
                    'address'=>$request->input('address'),
                ];
                if(!$provider->address){
                    $update=$provider->address()->create($data);
                }else{
                    $update=$provider->address->update($data);
                }

                if($update){
                    return $this->res('','آدرس با موفقیت ویرایش شد');
                }
                return $this->res('','آپدیت آدرس فروشنده انجام نشد',false);
            }else{
                return $this->res('',' فروشنده یافت نشد',false);
            }

        }catch (Exception $exception){
            return  $this->res('','مشکل در دریافت اطلاعات از سرور',false);
        }
    }
}
