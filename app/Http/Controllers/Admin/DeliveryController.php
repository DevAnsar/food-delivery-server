<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\admin\providerRequest;
use App\Http\Resources\admin\DeliveryCollection;
use App\Http\Resources\admin\DeliveryResource;
use App\Http\Resources\admin\UserCollection;
use App\Http\Resources\v1\CategoryCollection;
use App\Models\Category;
use App\Models\Provider;
use App\Models\User;
use Illuminate\Http\Request;

class DeliveryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $deliveries=Provider::all();
            return $this->res(['deliveries'=>new DeliveryCollection($deliveries)],'لیست فروشندگان');
        }catch (Exception $exception){
            return  $this->res('','مشکل در دریافت اطلاعات از سرور',false);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        try {
            $users=User::all();
            $categories=Category::where('parent_id',0)->get();
            return $this->res([
                'users'=>new UserCollection($users),
                'categories'=>new CategoryCollection($categories)
            ],'لیست کاربران و دسته بندی ها');
        }catch (Exception $exception){
            return  $this->res('','مشکل در دریافت اطلاعات از سرور',false);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(providerRequest $request)
    {
        try {
            $provider=Provider::create([
                'subcategory_id'=>2,
                'category_id'=>$request->input('categoryId'),
                'user_id'=>$request->userId,
                'name'=>$request->name,
                'description'=>$request->description,
                'delivery_time'=>$request->deliveryTime
            ]);
            if ($provider){
                return $this->res('','فروشنده با موفقیت ایجاد شد');
            }else{
                return $this->res('',' فروشنده جدید ایجاد نشد',false);
            }

        }catch (Exception $exception){
            return  $this->res('','مشکل در دریافت اطلاعات از سرور',false);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Provider  $provider
     * @return \Illuminate\Http\Response
     */
    public function show($provider_id)
    {
        try {
            $provider=Provider::find($provider_id);
            if ($provider){
                return $this->res(['delivery'=>new DeliveryResource($provider)],'اطلاعات فروشنده');
            }else{
                return $this->res('',' فروشنده یافت نشد',false);
            }

        }catch (Exception $exception){
            return  $this->res('','مشکل در دریافت اطلاعات از سرور',false);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Provider  $provider
     * @return \Illuminate\Http\Response
     */
    public function update(providerRequest $request,$provider_id)
    {
        try {
            $provider=Provider::find($provider_id);
            if ($provider){
                $update=$provider->update([
                    'user_id'=>$request->input('userId'),
                    'category_id'=>$request->input('categoryId'),
                    'subcategory_id'=>2,
                    'name'=>$request->input('name'),
                    'description'=>$request->input('description'),
                    'delivery_time'=>$request->input('deliveryTime'),
                ]);
                if($update){
                    return $this->res('','فروشنده با موفقیت ویرایش شد');
                }
                return $this->res('','آپدیت فروشنده انجام نشد',false);
            }else{
                return $this->res('',' فروشنده یافت نشد',false);
            }

        }catch (Exception $exception){
            return  $this->res('','مشکل در دریافت اطلاعات از سرور',false);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Provider  $provider
     * @return \Illuminate\Http\Response
     */
    public function destroy($provider_id)
    {
        try {
            $provider=Provider::find($provider_id);
            if ($provider){
                $deleted=$provider->delete();
                if($deleted){
                    return $this->res('','فروشنده با موفقیت حذف شد');
                }
                return $this->res('','حذف فروشنده انجام نشد',false);
            }else{
                return $this->res('',' فروشنده یافت نشد',false);
            }

        }catch (Exception $exception){
            return  $this->res('','مشکل در دریافت اطلاعات از سرور',false);
        }
    }
}
