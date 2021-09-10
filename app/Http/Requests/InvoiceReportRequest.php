<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InvoiceReportRequest extends FormRequest
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
            'invoice_number' => 'required_if:radio,2|nullable|exists:invoices,invoice_number',
            'type' => 'required_if:radio,1|nullable|in:0,1,2,*',
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
            'required_if' => 'هذا الحقل مطلوب',
            'in' => 'من فضلك قم باختيار نوع الفاتوره بشكل صحيح',
            'exists' => 'هذه الفاتوره غير موجوده او ربما تم حذفها',
            'required_with' => 'هذا الحقل مطلوب ايضا'
        ];
    }
}
