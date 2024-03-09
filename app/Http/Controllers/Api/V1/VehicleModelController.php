<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\VehicleModel;
use App\Http\Requests\StoreVehicleModelRequest;
use App\Http\Requests\UpdateVehicleModelRequest;
use App\Filters\V1\VehicleModelFilter;
use App\Http\Resources\V1\VehicleModelCollection;
use Illuminate\Http\Request;

class VehicleModelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Display a listing of the resource.
     */
    public function dropdown(Request $request)
    {
        $filter = new VehicleModelFilter();
        $filterItems =  $filter->transform($request); //[['column', 'operator', 'value']]
        $vehicleModels = VehicleModel::where($filterItems)->orderBy('name');
        
        return new VehicleModelCollection($vehicleModels->paginate()->appends($request->query()));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreVehicleModelRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(VehicleModel $vehicleModel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(VehicleModel $vehicleModel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateVehicleModelRequest $request, VehicleModel $vehicleModel)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(VehicleModel $vehicleModel)
    {
        //
    }
}
