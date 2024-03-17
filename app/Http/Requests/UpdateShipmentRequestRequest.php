<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateShipmentRequestRequest extends FormRequest
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
        $rules = [
            'consignee_id' => ['required'],
            'origin' => ['required'],
            'inquiry_id' => ['required'],
            'destination' => ['required'],
            'vehicle_id' => ['required'],
            'updated_at' => ['nullable'],
            'shipmentRequestItems' => 'required|array',
        ];
        return $rules;
    }

    public function attributes()
    {
        return [
            // 'mileAge' => 'mileage',
            // 'chassisNumber' => 'chassis #',
            // 'plateNumber' => 'plate #',
        ];
    }
    public function messages()
    {
        return [
            'shipmentRequestItems.required' => 'You must have at least one item.',
            'shipmentRequestItems.array' => 'Items must be an array',
            'shipmentRequestItems.*.exists' => 'Invalid item ID provided.',
        ];
    }
    public function all($keys = null)
    {
        $data = parent::all($keys);

        // Replace 'vehicle' with 'vehicle_id'
        if (isset($data['vehicle'])) {
            $data['vehicle_id'] = $data['vehicle'];
            // echo($data['vehicle']);
            unset($data['vehicle']);
        }
        if (isset($data['inquiry'])) {
            $data['inquiry_id'] = $data['inquiry'];
            unset($data['inquiry']);
        }
        if (isset($data['consignee'])) {
            $data['consignee_id'] = $data['consignee'];
            unset($data['consignee']);
        }
        if (isset($data['items'])) {
            $data['shipmentRequestItems'] = $data['items'];
            unset($data['items']);
        }

        return $data;
    }
    protected function prepareForValidation() {
        $this->merge([
            'updated_at' => now()
        ]);
    }
}
