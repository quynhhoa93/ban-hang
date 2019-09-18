<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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
            'name' =>'required|min:2|max:255'
        ];
    }
    public function messages()
    {
        return[
            'required' =>':attribute không được để trống',
            'min' =>':attribute Phải có ít nhất 2 ký tự',
            'max' =>':attribute Tối đa là 255 ký tự'
        ];
    }

    public function attribute(){
        return[
            'name'=>'tên danh mục sản phẩm',
        ];
    }
}
