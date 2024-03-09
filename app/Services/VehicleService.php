<?php
namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Models\Inquiry;
use Illuminate\Http\Request;

class VehicleService
{
    public function getAllVehicles(Request $request)
    {
        $page = (int)($request->query('page') ?? 1 ) - 1;

        $limit = $request->query('limit') ?? 15; 
        $search = $request->query('search');
        $orderBy = $request->query('sortBy') ?? '-id';
        // filters
        $vehicleMake = (int)$request->query('vehicleMake');
        $vehicleModel = (int)$request->query('vehicleModel');
        $gasType = $request->query('gasType');
        $type = $request->query('type');
        $status = $request->query('status');
        $registryExpirationFrom = $request->query('registryExpirationFrom');
        $registryExpirationTo = $request->query('registryExpirationTo');
        $registryDateFrom = $request->query('registryDateFrom');
        $registryDateTo = $request->query('registryDateTo');
        $lastMaintennanceDateFrom = $request->query('lastMaintennanceDateFrom');
        $lastMaintennanceDateTo = $request->query('lastMaintennanceDateTo');
        $transmission = $request->query('transmission');
        // end of filters
        $vehicles = DB::table('vehicles')
            ->leftJoin('cargo_types', 'type_id', '=', 'cargo_types.id')
            ->leftJoin('vehicle_makes', 'vehicle_makes.id', '=', 'vehicles.make_id')
            ->leftJoin('vehicle_models', 'vehicle_models.id', '=', 'vehicles.model_id')
            ->leftJoin('gas_types', 'gas_types.id', '=', 'vehicles.gasType_id')
            ->select('vehicles.*',
            'vehicle_makes.name as vehicleMake', 'vehicle_makes.id as vehicleMakeId',
            'vehicle_models.name as vehicleModel', 'vehicle_models.id as vehicleModelId',
            'cargo_types.name as type', 'cargo_types.id as typeId',
            'gas_types.name as gasType', 'gas_types.id as gasTypeId',
        );
        if ($search != '') {
            $vehicles->where('plateNumber', 'like', "%{$search}%" );
            $vehicles->orWhere('color', 'like', "%{$search}%" );
            $vehicles->orWhere('year', 'like', "%{$search}%" );
            $vehicles->orWhere('chassisNumber', 'like', "%{$search}%" );
            $vehicles->orWhere('vin', 'like', "%{$search}%" );
        }
        if($vehicleMake) {
            $vehicles->where('vehicle_makes.id', '=', "$vehicleMake" );
        }
        if($vehicleModel) {
            $vehicles->where('vehicle_models.id', '=', "$vehicleModel" );
        }
        if($type) {
            $vehicles->where('cargo_types.id', '=', "$type" );
        }
        if ($gasType) {
            $vehicles->where('gas_types.id', '=', "$gasType" );
        }
        if($status) {
            $vehicles->where('vehicles.status', '=', "$status" );
        }
        if ($registryExpirationFrom || $registryExpirationTo) {
            $vehicles->whereBetween('registryExpiration', [$registryExpirationFrom, $registryExpirationTo] );
        }
        if ($registryDateFrom || $registryDateTo) {
            $vehicles->whereBetween('registryDate', [$registryDateFrom, $registryDateTo] );
        }
        if ($lastMaintennanceDateFrom || $lastMaintennanceDateTo) {
            $vehicles->whereBetween('lastMaintennanceDate', [$lastMaintennanceDateFrom, $lastMaintennanceDateTo] );
        }
        if ($transmission) {
            $vehicles->where('transmission', '=', "$transmission" );
        }
        
        $order = substr($orderBy, 0, 1) == '-' ? 'desc' : 'asc';
        $column = $order == 'desc' ? substr($orderBy, 1, strlen($orderBy)) : $orderBy;
        if ($column == 'make') {
            $column = 'vehicle_makes.name';
        } else
        if ($column == 'model') {
            $column = 'vehicle_models.name';
        } else
        if ($column == 'gasType') {
            $column = 'gasType_models.name';
        }
        $vehicles->orderBy($column, $order);
        $totalRows = $vehicles->count();
        $vehicles = $vehicles->limit($limit)->offset($page * $limit)->get();
        $vehicleList = [];
        
        foreach ($vehicles as $vehicle) {
            $vehicleList[] = [
                'id' => $vehicle->id,
                'transmission' => $vehicle->transmission,
                'plateNumber' => $vehicle->plateNumber,
                'chassisNumber' => $vehicle->chassisNumber,
                'status' => $vehicle->status,
                'vin' => $vehicle->vin,
                'registryExpiration' => $vehicle->registryExpiration,
                'registryDate' => $vehicle->registryDate,
                'lastMaintennanceDate' => $vehicle->lastMaintennanceDate,
                'maxLoad' => $vehicle->maxLoad,
                'price' => $vehicle->price,
                'color' => $vehicle->color,
                'year' => $vehicle->year,
                'mileAge' => $vehicle->mileAge,
                'wheelCount' => $vehicle->wheelCount,
                'type' => [
                    'id' => $vehicle->typeId,
                    'name' => $vehicle->type
                ],
                'vehicleModel' => [
                    'id' => $vehicle->vehicleModelId,
                    'name' => $vehicle->vehicleModel
                ],
                'vehicleMake' => [
                    'id' => $vehicle->vehicleMakeId,
                    'name' => $vehicle->vehicleMake
                ],
                'gasType' => [
                    'id' => $vehicle->gasTypeId,
                    'name' => $vehicle->gasType
                ]
            ];
        }
        return [
            'totalRows' => $totalRows,
            'page' => $page + 1,
            'limit' => $limit,
            'data' => $vehicleList
        ];
    }
}