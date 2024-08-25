<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreVoucherRequest extends FormRequest
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
            'code' => 'nullable|unique:vouchers|min:3|max:50',
            'discount_type' => "required|string|min:3|max:10",
            'discount_value' => "required|numeric|min:1",
            'discount_max' => "nullable|numeric|min:3",
            'quantity' => 'required|numeric|min:1',
            'user_count' => 'required|numeric|min:1',
            'day_start' => 'nullable|date|before_or_equal:day_end',
            'day_end' => 'nullable|date|after_or_equal:day_start',
            'is_active' => 'boolean|',
            'trigger_event' => 'required|min:3',
            'description' => 'min:3|max:255'
        ];
    }

    /**
     * Get custom error messages for validation failures.
     */
    public function messages(): array
    {
        return [
            'code.min' => 'Vui lòng nhập ít nhất 3 ký tự',
            'code.max' => 'Vui lòng nhập nhiều nhất 50 ký tự',
            'code.unique' => 'Code đã bị trùng',
            'discount_type.required' => 'Loại giảm giá không được để trống',
            'discount_type.string' => 'Chỉ nhập được chữ',
            'discount_type.min' => 'Vui lòng nhập ít nhất 3 ký tự',
            'discount_type.max' => 'Vui lòng nhập nhiều nhất 10 ký tự',
            'discount_value.required' => "Giá trị giảm giá không được để trống",
            'discount_value.numeric' => "Chỉ nhập được số",
            'discount_value.min' => "Vui lòng nhập giá trị lớn hơn 0",
            'quantity.required' => "Số lượng voucher không được để trống",
            'quantity.numeric' => "Chỉ nhập được số",
            'quantity.min' => "Số lượng voucher phải lớn hơn 0",
            'user_count.required' => "Số lượng sử dụng của mỗi tài khoản không được để trống",
            'user_count.numeric' => "Chỉ nhập được số",
            'user_count.min' => "Số lượng sử dụng phải lớn hơn 0",
            'day_start.date' => 'Ngày bắt đầu không hợp lệ',
            'day_start.before_or_equal' => 'Ngày bắt đầu phải trước hoặc bằng ngày kết thúc',
            'day_end.date' => 'Ngày kết thúc không hợp lệ',
            'day_end.after_or_equal' => 'Ngày kết thúc phải sau hoặc bằng ngày bắt đầu',
            'is_active.boolean' => 'Chỉ được chọn 1 trong 2',
            'trigger_event.required' => 'Vui lòng nhập loại của voucher',
            'trigger_event.min' => 'Vui lòng nhập ít nhất 3 ký tự',
            'description.min' => 'Vui lòng nhập ít nhất 3 ký tự',
            'description.max' => 'Vui lòng nhập nhiều nhất 255 ký tự',
        ];
    }
}
