<?php
namespace App\Services;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Inquiry;
use Illuminate\Http\Request;

class ShipmentRequestService
{
    public function getAllShipmentRequests(Request $request)
    {
        $page = (int)($request->query('page') ?? 1 ) - 1;

        $limit = $request->query('limit') ?? 15; 
        $search = $request->query('search');
        $orderBy = $request->query('sortBy') ?? '-shipment_requests.id';
        // filters
        $status = $request->query('status');
        $itemType = (int)$request->query('itemType');
        $deliveryType = $request->query('deliveryType');
        $cargoType = (int)$request->query('cargoType');
        $deliveryDateFrom = $request->query('deliveryDateFrom');
        $deliveryDateTo = $request->query('deliveryDateTo');
        // end of filters
        $shipmentRequests = DB::table('shipment_requests')
            ->leftJoin('vehicles', 'vehicles.id', '=', 'shipment_requests.vehicle_id')
            ->leftJoin('inquiries', 'inquiries.id', '=', 'shipment_requests.inquiry_id')
            ->leftJoin('consignees', 'consignees.id', '=', 'shipment_requests.consignee_id')
            ->leftJoin('vehicle_makes', 'vehicle_makes.id', '=', 'vehicles.make_id')
            ->leftJoin('cargo_types', 'cargo_types.id', '=', 'inquiries.cargoType_id')
            ->leftJoin('item_types', 'item_types.id', '=', 'inquiries.itemType_id')
            ->leftJoin('vehicle_models', 'vehicle_models.id', '=', 'vehicles.model_id')
            ->select('shipment_requests.*',
                    'vehicles.plateNumber as plateNumber',
                    'vehicles.id as vehicleId',
                    'vehicle_makes.id as makeId',
                    'vehicle_makes.name as make',
                    'vehicle_models.id as modelId',
                    'vehicle_models.name as model',
                    'consignees.name as consignee',
                    'consignees.id as consigneeId',
                    'inquiries.referenceNumber as referenceNumber',
                    'inquiries.deliveryType',
                    'consignees.name as consignee',
                    'consignees.id as consigneeId',
                    'cargo_types.name as cargoType',
                    'cargo_types.id as cargoId',
                    'item_types.name as itemType',
                    'item_types.id as itemTypeId',
        );
        if ($search != '') {
            $shipmentRequests->where('referenceNumber', 'like', "%{$search}%" );
            $shipmentRequests->orWhere('consignees.name', 'like', "%{$search}%" );
            $shipmentRequests->orWhere('destination', 'like', "%{$search}%" );
            $shipmentRequests->orWhere('origin', 'like', "%{$search}%" );
        }
        if($status) {
            $shipmentRequests->where('shipment_requests.status', '=', "$status" );
        }
        if($itemType) {
            $shipmentRequests->where('item_types.id', '=', "$itemType" );
        }
        if($cargoType) {
            $shipmentRequests->where('cargo_types.id', '=', "$cargoType" );
        }
        if ($deliveryType) {
            $shipmentRequests->where('deliveryType', '=', "$deliveryType" );
        }
        if ($deliveryDateFrom || $deliveryDateTo) {
            $shipmentRequests->whereBetween('estimatedDeliveryDate', [$deliveryDateFrom, $deliveryDateTo] );
        }
        $order = substr($orderBy, 0, 1) == '-' ? 'desc' : 'asc';
        $column = $order == 'desc' ? substr($orderBy, 1, strlen($orderBy)) : $orderBy;
        $shipmentRequests->orderBy($column, $order);
        $totalRows = $shipmentRequests->count();
        $shipmentRequests = $shipmentRequests->limit($limit)->offset($page * $limit)->get();
        $shipmentRequestList = [];
        
        foreach ($shipmentRequests as $shipmentRequest) {
            $shipmentRequestList[] = [
                'id' => $shipmentRequest->id,
                'referenceNumber' => $shipmentRequest->referenceNumber,
                'consignee' => [
                    'id' => $shipmentRequest->consigneeId ?? '',
                    'name' => $shipmentRequest->consignee ?? '',
                ],
                'deliveryType' => $shipmentRequest->deliveryType,
                'cargoType' => [
                    'id' => $shipmentRequest->cargoId,
                    'name' => $shipmentRequest->cargoType
                ],
                'itemType' => [
                    'id' => $shipmentRequest->itemTypeId,
                    'name' => $shipmentRequest->itemType
                ],
                'deliveryDate' => $shipmentRequest->estimatedDeliveryDate,
                'destination' => $shipmentRequest->destination,
                'origin' => $shipmentRequest->origin,
                'status' => $shipmentRequest->status,
                'createdAt' => $shipmentRequest->created_at,
                'vehicle' => [
                    'id' => $shipmentRequest->vehicleId,
                    'plateNumber' => $shipmentRequest->plateNumber,
                    'make' => [
                        'id' => $shipmentRequest->makeId ?? '',
                        'name' => $shipmentRequest->make ?? '',
                    ],
                    'model' => [
                        'id' => $shipmentRequest->modelId ?? '',
                        'name' => $shipmentRequest->model ?? '',
                    ]
                ]
            ];
        }
        return [
            'totalRows' => $totalRows,
            'page' => $page + 1,
            'limit' => $limit,
            'data' => $shipmentRequestList
        ];
    }
}