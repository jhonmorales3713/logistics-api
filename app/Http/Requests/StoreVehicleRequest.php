<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\Vehicle;

class StoreVehicleRequest extends FormRequest
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
            'plateNumber' => ['required','string','max:10'],
            'gasType_id' => ['required'],
            'type_id' => ['required'],
            'make_id' => ['required'],
            'model_id' => ['required'],
            'status' => ['required', Rule::in([Vehicle::STATUS_ACTIVE, Vehicle::STATUS_ON_MAINTENNANCE, Vehicle::STATUS_FOR_MAINTENNANCE])],
            'transmission' => ['required', Rule::in([Vehicle::TRANSMISSION_MANUAL, Vehicle::TRANSMISSION_AUTOMATIC])],
            'chassisNumber' => ['required','string','max:17'],
            'price' => ['required','numeric','max:99999999999999999999'],
            'vin' => ['required','string','max:17'],
            'year' => ['nullable','max:4'],
            'color' => ['nullable','string','max:20'],
            'maxLoad' => ['nullable','numeric','max:99999999999999999999'],
            'mileAge' => ['required','numeric','max:9999999'],
            'wheelCount' => ['nullable','integer','max:20'],
            'registryDate' => ['nullable'],
            'registryExpiration' => ['nullable'],
            'lastMaintennanceDate' => ['nullable'],
            'updatedBy' => ['nullable'],
            'updated_at' => ['nullable'],
        ];
    }

    public function attributes()
    {
        return [
            'mileAge' => 'mileage',
            'chassisNumber' => 'chassis #',
            'plateNumber' => 'plate #',
            'make_id' => 'make',
            'model_id' => 'model',
            'gasType_id' => 'gas type',
            'type_id' => 'type  ',
        ];
    }
    protected function prepareForValidation() {
        $this->merge([
            'status' => Vehicle::STATUS_ACTIVE
        ]);
    }
    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        $errors = $validator->errors()->toArray();
        
        // Define a map of original field names to new field names
        $fieldMap = [
            'make_id' => 'vehicleMake',
            'model_id' => 'vehicleModel',
            'gasType_id' => 'gasType',
            'type_id' => 'type',
            // Add more mappings as needed
        ];
        // Replace field names in error messages
        $newErrors = [];
        foreach ($errors as $field => $errorMessages) {
            if (isset($fieldMap[$field])) {
                $newField = $fieldMap[$field];
                foreach ($errorMessages as $errorMessage) {
                    // Check if the error message for this field is already in the newErrors array
                    if (!in_array($errorMessage, $newErrors[$newField] ?? [])) {
                        // Add the error message to the newErrors array for this field
                        $newErrors[$newField][] = $errorMessage;
                        // print_r($newErrors[$newField]);
                    }
                }
            }
        }
    
        // print_r($validator->errors());
        // Merge the newErrors with the existing errors
        $validator->errors()->merge($newErrors);
        // print_r($validator->errors());
        parent::failedValidation($validator);

    }
}
