<?php

namespace App\Http\Requests\admin;

use Illuminate\Foundation\Http\FormRequest;

class providerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'userId'=>'required',
            'categoryId'=>'required',
            'name'=>'required',
            'description'=>'nullable',
            'deliveryTime'=>'required'
        ];
    }
}
