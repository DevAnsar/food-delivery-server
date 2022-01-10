<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddressRequest;
use App\Http\Resources\v1\AddressCollection;
use App\Models\Address;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        try {
            $user=auth()->user();
            return $this->res(new AddressCollection($user->addresses),'آدرس های شما');
        }catch (\Exception $e){
            return $this->res(null,$this->SystemErrorMessage);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param AddressRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(AddressRequest $request)
    {
        try {
            $user=auth()->user();
            $user->addresses()->create([
                'name'=>$request->name,
                'address'=>$request->address,
                'city_id'=>$request->city_id,
                'area_id'=>$request->area_id,
            ]);
            return $this->res(null,'آدرس با موفقیت افزوده شد');
        }catch (\Exception $e){
            return $this->res(null,$this->SystemErrorMessage);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param AddressRequest $request
     * @param \App\Models\Address $address
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(AddressRequest $request, Address $address)
    {
        try {
            $user=auth()->user();
            if ($address->user_id == $user->id){
            $address->update([
                'name'=>$request->name,
                'address'=>$request->address,
                'city_id'=>$request->city_id,
                'area_id'=>$request->area_id,
            ]);
            return $this->res(null,'آدرس با موفقیت افزوده شد');
            }else{
                return $this->res(null,'عدم اجازه دسترسی',false);
            }
        }catch (\Exception $e){
            return $this->res(null,$this->SystemErrorMessage);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Address  $address
     * @return \Illuminate\Http\Response
     */
    public function destroy(Address $address)
    {
        try {
            $user=auth()->user();
            if ($address->user_id == $user->id){
                $address->delete();
                return $this->res(null,'آدرس با موفقیت حذف شد');
            }else{
                return $this->res(null,'عدم اجازه دسترسی',false);
            }
        }catch (\Exception $e){
            return $this->res(null,$this->SystemErrorMessage);
        }
    }
}
