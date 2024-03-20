<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\ShipmentRequest;

class StoreShipmentRequestRequest extends FormRequest
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
            'estimatedDeliveryDate' => ['required'],
            'vehicle_id' => ['required'],
            'updated_at' => ['nullable'],
            'shipmentRequestItems' => 'required|array',
            'shipmentRequestItems.*.name' => 'required',
            'shipmentRequestItems.*.quantity' => 'required|numeric',
        ];
        return $rules;
    }
    public function attributes()
    {
        return [
            'shipmentRequestItems.*.name' => 'name',
            'shipmentRequestItems.*.quantity' => 'quantity',
            'estimatedDeliveryDate' => 'target delivery date',
            'vehicle_id' => 'vehicle',
            'inquiry_id' => 'inquiry',
            'consignee_id' => 'consignee',
        ];
    }
    public function messages()
    {
        return [
            'shipmentRequestItems.required' => 'You must have at least one item.',
            'shipmentRequestItems.array' => 'Items must be an array',
            'shipmentRequestItems.*.exists' => 'Invalid ID provided.',
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
        if (isset($data['deliveryDate'])) {
            $data['estimatedDeliveryDate'] = $data['deliveryDate'];
            unset($data['deliveryDate']);
        }
        if (isset($data['items'])) {
            $data['shipmentRequestItems'] = $data['items'];
            unset($data['items']);
        }

        return $data;
    }
    protected function prepareForValidation() {
        $this->merge([
            'status' => ShipmentRequest::STATUS_PENDING
        ]);
    }
}
