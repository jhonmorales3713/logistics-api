<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\VehicleMake;
use App\Http\Requests\StoreVehicleMakeRequest;
use App\Http\Requests\UpdateVehicleMakeRequest;
use Illuminate\Http\Request;
use App\Filters\V1\VehicleMakeFilter;
use App\Http\Resources\V1\VehicleMakeCollection;

class VehicleMakeController extends Controller
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
     * Store a newly created resource in storage.
     */
    public function store(StoreVehicleMakeRequest $request)
    {

    }

    /**
     * Display a listing of the resource.
     */
    public function dropdown(Request $request)
    {
        $filter = new VehicleMakeFilter();
        $filterItems =  $filter->transform($request); //[['column', 'operator', 'value']]
        $vehilceMakes = VehicleMake::where($filterItems)->orderBy('name');
        
        return new VehicleMakeCollection($vehilceMakes->paginate()->appends($request->query()));
    }

    /**
     * Display the specified resource.
     */
    public function show(VehicleMake $vehicleMake)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(VehicleMake $vehicleMake)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateVehicleMakeRequest $request, VehicleMake $vehicleMake)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(VehicleMake $vehicleMake)
    {
        //
    }
}
