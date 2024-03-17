<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\ShipmentRequest;
use App\Models\ShipmentRequestItem;
use Illuminate\Http\Request;
use App\Http\Requests\StoreShipmentRequestRequest;
use App\Http\Requests\UpdateShipmentRequestRequest;
use App\Services\ShipmentRequestService;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\V1\ShipmentRequest\ShipmentRequestResource;

class ShipmentRequestController extends Controller
{
    protected $shipmentRequestService;
    public function __construct(ShipmentRequestService $shipmentRequestService)
    {
        $this->shipmentRequestService = $shipmentRequestService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return $this->shipmentRequestService->getAllShipmentRequests($request);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreShipmentRequestRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, $id)
    {
        if ($id) {
            $shipmentRequest = ShipmentRequest::with(
                'inquiry',
                'consignee',
                'inquiry.cargoType',
                'inquiry.itemType',
                'shipmentRequestItems',
                'vehicle',
                'vehicle.vehicleMake',
                'vehicle.vehicleModel'
                )->where('id',$id)->first();
            if ($shipmentRequest) {
                return new ShipmentRequestResource($shipmentRequest);
            }
            throw ValidationException::withMessages(['error' => 'No Shipment Request Found']);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ShipmentRequest $shipmentRequest)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateShipmentRequestRequest $request, $id)
    {
        $shipmentRequest = ShipmentRequest::with(
            'shipmentRequestItems',
            )->where('id',$id)->first();
        $shipmentRequest->update($request->all());
        $validatedData = $request->validated();
        $shipmentRequestItems = $validatedData['shipmentRequestItems'];
        foreach($shipmentRequest->shipmentRequestItems as $key=>$value) {

            $exists = isset($shipmentRequestItems[$value['id']]);
            // echo $value['id'];
            // $shipmentRequest->shipmentRequestItems()->find($value['id']);
            // echo $exists;
            echo json_encode($shipmentRequestItems);
            if (!$exists) {
                echo $value['id'];
                echo $shipmentRequest->shipmentRequestItems->find($value['id']);
                // $shipmentRequest->shipmentRequestItems->find($value['id'])->delete();
            }
        }
        return new ShipmentRequestResource($shipmentRequest);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ShipmentRequest $shipmentRequest)
    {
        //
    }
}
