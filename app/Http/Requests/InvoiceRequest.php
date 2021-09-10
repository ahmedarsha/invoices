<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class InvoiceRequest extends FormRequest
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
            'invoice_number' => 'required|string|max:50|unique:invoices,invoice_number,'.$this->id,
            // 'invoice_number' => ['required','string','max:50',Rule::unique('invoices')->ignore($this->invoice)],
            'invoice_date' => 'required|date',
            'due_date' => 'required|date',
            'category_id' => 'required|exists:categories,id|numeric',
            'product_id' => 'required|exists:products,id|numeric',
            'amount_collection' => 'required|numeric',
            'amount_commission' => 'required|numeric',
            'discount' => 'required|numeric',
            'Rate_VAT' => 'required',
            'Value_VAT' => 'required|numeric',
            'total' => 'required|numeric',
            'note' => 'nullable|string',
            'pic' => 'nullable|image|mimes:pdf,jpeg,jpg,png|max:1024',
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
            'unique' => 'هذه الفاتوره موجود مسبقا من فضلك ادخل فاتوره اخره',
            'category_id.numeric' => 'من فضلك ادخل قسم صحيح ',
            'category_id.exists' => 'هذا القسم غير موجود من فضلك ادخل قسم صحيح ',
            'product_id.numeric' => 'من فضلك ادخل منتج صحيح ',
            'product_id.exists' => 'هذا المنتج غير موجود من فضلك ادخل منتج صحيح ',
            
        ];
    }
}
