<?php

namespace App\Http\Requests\Auth;

use App\Enums\UserRoleEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


class ResgisteringRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'password' => [
                'required',
                'string',
                'min:0',
                'max:255',
            ],
            'role' =>[
                'required',
                // 'in_array:' . UserRoleEnum::CUSTOMER .','. UserRoleEnum::PITCH_OWNER,
                Rule::in([
                    UserRoleEnum::CUSTOMER,
                    UserRoleEnum::PITCH_OWNER,
                ]),
            ],
        ];
    }
}
