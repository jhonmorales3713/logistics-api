<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Vehicle;
use App\Models\VehicleMake;
use Illuminate\Http\Request;
use App\Http\Requests\StoreVehicleRequest;
use App\Http\Requests\UpdateVehicleRequest;
use App\Services\VehicleService;
use App\Http\Resources\V1\VehicleResource;

class VehicleController extends Controller
{
    protected $vehicleService;
    public function __construct(VehicleService $vehicleService)
    {
        $this->vehicleService = $vehicleService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return $this->vehicleService->getAllVehicles($request);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }
    public function setForMaintennance(Request $request, $id)
    {
        if ($id) {
            $vehicle = Vehicle::with('vehicleMake','type','gasType','vehicleModel')->where('id',$id)->first();
            
            $this->authorize('forMaintennance', $vehicle);
            $vehicle->status = Vehicle::STATUS_FOR_MAINTENNANCE;
            $vehicle->save();
            return new VehicleResource($vehicle, $this);
        }
    }
    public function setOnMaintennance(Request $request, $id)
    {
        if ($id) {
            $vehicle = Vehicle::with('vehicleMake','type','gasType','vehicleModel')->where('id',$id)->first();
            
            $this->authorize('onMaintennance', $vehicle);
            $vehicle->status = Vehicle::STATUS_ON_MAINTENNANCE;
            $vehicle->save();
            return new VehicleResource($vehicle, $this);
        }
    }
    public function setActive(Request $request, $id)
    {
        if ($id) {
            $vehicle = Vehicle::with('vehicleMake','type','gasType','vehicleModel')->where('id',$id)->first();
            
            $this->authorize('active', $vehicle);
            $vehicle->status = Vehicle::STATUS_ACTIVE;
            $vehicle->save();
            return new VehicleResource($vehicle, $this);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreVehicleRequest $request)
    {
        return new VehicleResource(Vehicle::create($request->all()));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, $id)
    {
        
        if ($id) {
            $vehicle = Vehicle::with('vehicleMake','type','gasType','vehicleModel')->where('id',$id)->first();
            if ($vehicle) {
                return new VehicleResource($vehicle);
            }
            throw ValidationException::withMessages(['error' => 'No vehicle Found']);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Vehicle $vehicle)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateVehicleRequest $request, $id)
    {
        $vehicle = Vehicle::find($id);
        $vehicle->update($request->all());

        return new VehicleResource($vehicle);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Vehicle $vehicle)
    {
        //
    }
}
