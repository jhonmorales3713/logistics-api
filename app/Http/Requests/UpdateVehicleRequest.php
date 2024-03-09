<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\Vehicle;
use App\Models\VehicleMake;
use App\Models\VehicleModel;
use App\Models\GasType;
use App\Models\CargoType;

class UpdateVehicleRequest extends FormRequest
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
        ];
    }
    protected function prepareForValidation() {
        $this->merge([
            
        ]);
    }
}
