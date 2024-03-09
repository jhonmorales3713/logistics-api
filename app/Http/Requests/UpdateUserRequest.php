<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use App\Models\UserRole;

class UpdateUserRequest extends FormRequest
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
            'email' => ['required','string','max:50'],
            'password' => ['required','string','min:6'],
            'userRoles' => 'required|array',
            'updated_at' => ['nullable'],
        ];
    }
    // public function validationData()
    // {
    //     $data = $this->all();
        
    //     // Change attribute names as needed
    //     $data['user_role_id'] = $this->input('userRoles');
    //     echo $this->input('userRoles');
    //     $this->replace($data);

    //     return $data;
    // }
    public function messages()
    {
        return [
            'userRoles.required' => 'You must have at least one user role.',
            'userRoles.array' => 'User role must be an array',
            'userRoles.*.exists' => 'Invalid role ID provided.',
        ];
    }
    protected function prepareForValidation() {
        $this->merge([
            'updated_at' => now(),
            'password' => Hash::needsRehash($this->password) ? Hash::make($this->password) : $this->password
        ]);
    }
}
