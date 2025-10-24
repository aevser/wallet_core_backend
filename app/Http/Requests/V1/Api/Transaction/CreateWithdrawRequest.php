<?php

namespace App\Http\Requests\V1\Api\Transaction;

use Illuminate\Foundation\Http\FormRequest;

class CreateWithdrawRequest extends FormRequest
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
            'user_id' => 'required|integer|exists:users,id',
            'amount' => 'required|numeric|min:0.01',
            'comment' => 'nullable|string|max:500'
        ];
    }

    public function messages(): array
    {
        return [
            'user_id.required' => __('validations.withdraw.user_id.required'),
            'user_id.integer' => __('validations.withdraw.user_id.integer'),
            'user_id.exists' => __('validations.withdraw.user_id.exists'),

            'amount.required' => __('validations.withdraw.amount.required'),
            'amount.numeric' => __('validations.withdraw.amount.numeric'),

            'comment.string' => __('validations.withdraw.comment.string'),
            'comment.max' => __('validations.withdraw.comment.max')
        ];
    }
}
