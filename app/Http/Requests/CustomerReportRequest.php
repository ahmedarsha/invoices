<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerReportRequest extends FormRequest
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
            'category_id' => 'required|exists:categories,id|numeric',
            'product_id' => 'required|exists:products,id|numeric',
            'start_at' => 'required_with:end_at|nullable|date',
            'end_at' => 'required_with:start_at|nullable|date',
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
            'required' => 'هذا الحقل مطلوب',
            'category_id.numeric' => 'من فضلك ادخل قسم صحيح ',
            'category_id.exists' => 'هذا القسم غير موجود من فضلك ادخل قسم صحيح ',
            'product_id.numeric' => 'من فضلك ادخل منتج صحيح ',
            'product_id.exists' => 'هذا المنتج غير موجود من فضلك ادخل منتج صحيح ',
            'required_with' => 'هذا الحقل مطلوب ايضا'
        ];
    }

}
