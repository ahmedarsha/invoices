<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class categoryRequest extends FormRequest
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
            'name' => ['required','max:190', Rule::unique('categories')->ignore($this->category)]
            // 'name' => 'required|max:190|unique:categories,name,'. $this->category->id
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
            'name.required' => 'اسم القسم مطلوب',
            'name.unique' => 'هذا القسم موجود مسبقا من فضلك ادخل قسم اخر'
        ];
    }

}
