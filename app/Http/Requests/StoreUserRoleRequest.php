<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\UserRole;

class StoreUserRoleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $user = $this->user();
        return $user != null;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required','string','max:20'],
            'access' => ['required'],
            'status' => ['required', Rule::in([UserRole::STATUS_ACTIVE, UserRole::STATUS_INACTIVE])],
        ];
    }
    protected function prepareForValidation() {
        $this->merge([
            'status' => UserRole::STATUS_ACTIVE
        ]);
    }
}
