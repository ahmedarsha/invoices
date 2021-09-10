<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductRequest extends FormRequest
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
            'name' => ['required','max:190', Rule::unique('products')->ignore($this->product)],
            // 'name'=>'required|string|max:190|unique:products,name,'.$this->id,
            'category_id' => 'required|numeric|exists:categories,id',
        ];
    }
    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => 'اسم المنتج مطلوب',
            'name.unique' => 'هذا المنتج موجود مسبقا من فضلك ادخل منتج اخر',
            'category_id.required' => 'اسم القسم مطلوب',
            'category_id.numeric' => 'من فضلك ادخل قسم صحيح ',
            'category_id.exists' => 'هذا القسم غير موجود من فضلك ادخل قسم صحيح ',

        ];
    }
}
