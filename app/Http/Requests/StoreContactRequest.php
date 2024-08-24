<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreContactRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'fullname' => 'required|string|min:3|max:50',
            'email' => 'required|email|min:3|max:50',
            'phone' => 'required|numeric|min:3',
            'content' => 'required|min:5|max:255'
        ];
    }

    public function messages(): array
    {
        return [
            'fullname.required' => 'Vui lòng nhập đầy đủ họ và tên',
            'fullname.string' => 'Vui lòng họ và tên không được là số',
            'fullname.min' => 'Vui lòng nhập ít nhất 3 ký tự',
            'fullname.max' => 'Vui lòng nhập nhiều nhất 50 ký tự',
            'email.required' => "Vui lòng nhập email",
            'email.email' => "Vui lòng nhập đúng email",
            'email.min' => "Vui lòng nhập ít nhất 3 ký tự",
            'email.max' => "Vui lòng nhập nhiều nhất 50 ký tự",
            'phone.required' => "Vui lòng nhập đầy đủ số điện thoại",
            'phone.numeric' => "Chỉ được nhập số",
            'phone.min' => "Vui lòng nhập ít nhất 3 ký tự",
            'content.required' => "Vui lòng nhập nội dung",
            'content.min' => "Vui lòng nhập ít nhất 6 ký tự",
            'content.max' => "Vui lòng nhập nhiều nhất 255 ký tự",
        ];
    }
}
