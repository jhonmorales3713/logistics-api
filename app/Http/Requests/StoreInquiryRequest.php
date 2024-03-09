<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\Inquiry;

class StoreInquiryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $user = $this->user();
        return $user != null && $user->tokenCan('create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => ['required','email'],
            'contactNumber' => ['required'],
            'itemType' => ['required'],
            'cargoType' => ['required'],
            'status' => ['required', Rule::in([Inquiry::STATUS_PENDING, Inquiry::STATUS_RECEIVED, Inquiry::STATUS_INVALID])],
            'referenceNumber' => ['required'],
            'targetDate' => ['required'],
            'quantity' => ['required'],
            'deliveryType' => ['required',Rule::in(['prelo','load'])],
            'updatedBy' => ['nullable'],
        ];
    }

    protected function generateReferenceNumber() {
        $refNum = ['A', 'B', 'C', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N'
            , 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', '1', '1'
            , '2', '3', '4', '5', '6', '7', '8', '9', '0'];
        $refNumStr = '';
        do {
            $refNumStr .= $refNum[rand(0, count($refNum) - 1)];
        } while (strlen($refNumStr) < 10);
        $result = Inquiry::where('referenceNumber', $refNumStr)->first();
        if (!$result) {
            return $refNumStr;
        } else {
            $this->generateReferenceNumber();
        }
    }

    protected function prepareForValidation() {
        $this->merge([
            'status' => request()->has('status') ? $this->status : 'pendi',
            'itemType' => $this->itemType_id,
            'referenceNumber' => $this->generateReferenceNumber(),
            'cargoType' => $this->cargoType_id,
        ]);
    }
}
