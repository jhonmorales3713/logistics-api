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
use Illuminate\Support\Facades\DB;

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
        $shipment = ShipmentRequest::create($request->all());
        $validatedData = $request->validated();
        $shipmentRequestItems = $validatedData['shipmentRequestItems'];
        foreach ($shipmentRequestItems as $value) {
            $shipmentRequestItem = new ShipmentRequestItem;
            $shipmentRequestItem->shipment_request_id = $shipment->id;
            $shipmentRequestItem->name = $value["name"];
            $shipmentRequestItem->quantity = number_format($value["quantity"],2);
            $shipmentRequestItem->save();
        }
        return new ShipmentRequestResource($shipment);
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

        $itemsFromRequest = collect($shipmentRequestItems);
        $existingItemIds = $shipmentRequest->shipmentRequestItems->pluck('id');
        // Delete items that exist in the database but not in the request
        $itemsToDelete = $existingItemIds->diff($itemsFromRequest->pluck('id'));
        ShipmentRequestItem::whereIn('id', $itemsToDelete)->delete();

        foreach ($shipmentRequestItems as $value) {
            if(isset($value['id'])) {
                $item = ShipmentRequestItem::findOrFail($value['id']);
                $item->update([
                    'name' => $value['name'],
                    'quantity' => $value['quantity'],
                ]);
            } else {
                $shipmentRequestItem = new ShipmentRequestItem;
                $shipmentRequestItem->shipment_request_id = $id;
                $shipmentRequestItem->name = $value["name"];
                $shipmentRequestItem->quantity = number_format($value["quantity"],2);
                $shipmentRequestItem->save();
            }
        }
        
        // $shipmentRequest->shipmentRequestItems()->whereNotIn('id', $existingItems)->delete();
        // $shipmentRequest->refresh();
        return new ShipmentRequestResource($shipmentRequest);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function approve(Request $request, $id)
    {
        $permitted = $this->hasPermission(ShipmentRequest::TAG.ShipmentRequest::PERMISSION_APPROVE);
        if (!$permitted) {
            return response()->json(['message' => 'Action unauthorized. Please refresh the page.'], 401);
        }
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

            $this->authorize('approve', $shipmentRequest);
            $shipmentRequest->status = ShipmentRequest::STATUS_APPROVE;
            $shipmentRequest->updated_at = now();
            $shipmentRequest->save();
            return new ShipmentRequestResource($shipmentRequest);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function unapprove(Request $request, $id)
    {
        $permitted = $this->hasPermission(ShipmentRequest::TAG.ShipmentRequest::PERMISSION_APPROVE);
        if (!$permitted) {
            return response()->json(['message' => 'Action unauthorized. Please refresh the page.'], 401);
        }
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
            
            $this->authorize('unapprove', $shipmentRequest);
            $shipmentRequest->status = ShipmentRequest::STATUS_PENDING;
            $shipmentRequest->updated_at = now();
            $shipmentRequest->save();
            return new ShipmentRequestResource($shipmentRequest);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function decline(Request $request, $id)
    {
        $permitted = $this->hasPermission(ShipmentRequest::TAG.ShipmentRequest::PERMISSION_APPROVE);
        if (!$permitted) {
            return response()->json(['message' => 'Action unauthorized. Please refresh the page.'], 401);
        }
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
            
            $this->authorize('approve', $shipmentRequest);
            $shipmentRequest->status = ShipmentRequest::STATUS_DECLINE;
            $shipmentRequest->updated_at = now();
            $shipmentRequest->save();
            return new ShipmentRequestResource($shipmentRequest);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ShipmentRequest $shipmentRequest)
    {
        //
    }
}
