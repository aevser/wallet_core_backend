<?php

namespace App\Http\Requests\V1\Api\Transaction;

use Illuminate\Foundation\Http\FormRequest;

class CreateDepositRequest extends FormRequest
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
            'amount' => 'required|numeric',
            'comment' => 'nullable|string|max:500'
        ];
    }

    public function messages(): array
    {
        return [
            'user_id.required' => __('validations.deposit.user_id.required'),
            'user_id.integer' => __('validations.deposit.user_id.integer'),
            'user_id.exists' => __('validations.deposit.user_id.exists'),

            'amount.required' => __('validations.deposit.amount.required'),
            'amount.numeric' => __('validations.deposit.amount.numeric'),

            'comment.string' => __('validations.deposit.comment.string'),
            'comment.max' => __('validations.deposit.comment.max')
        ];
    }
}
