<?php

namespace App\Http\Requests\V1\Api\Transaction;

use Illuminate\Foundation\Http\FormRequest;

class CreateTransferRequest extends FormRequest
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
            'from_user_id' => 'required|integer|exists:users,id',
            'to_user_id' => 'required|integer|exists:users,id',
            'amount' => 'required|numeric',
            'comment' => 'nullable|string|max:500'
        ];
    }

    public function messages(): array
    {
        return [
            'from_user_id.required' => __('validations.transfer.from_user_id.required'),
            'from_user_id.integer' => __('validations.transfer.from_user_id.integer'),
            'from_user_id.exists' => __('validations.transfer.from_user_id.exists'),

            'to_user_id.required' => __('validations.transfer.to_user_id.required'),
            'to_user_id.integer' => __('validations.transfer.to_user_id.integer'),
            'to_user_id.exists' => __('validations.transfer.to_user_id.exists'),

            'amount.required' => __('validations.transfer.amount.required'),
            'amount.numeric' => __('validations.transfer.amount.numeric'),

            'comment.string' => __('validations.transfer.comment.string'),
            'comment.max' => __('validations.transfer.comment.max')
        ];
    }
}
