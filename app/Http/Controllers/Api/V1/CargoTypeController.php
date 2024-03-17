<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\CargoType;
use App\Http\Requests\StoreCargoTypeRequest;
use App\Http\Requests\UpdateCargoTypeRequest;
use App\Filters\V1\DropdownFilter;
use App\Http\Resources\V1\CargoTypeCollection;
use Illuminate\Http\Request;

class CargoTypeController extends Controller
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
        $filter = new DropdownFilter();
        $filterItems =  $filter->transform($request); //[['column', 'operator', 'value']]
        $itemTypes = CargoType::where($filterItems);
        
        return new CargoTypeCollection($itemTypes->paginate()->appends($request->query()));
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCargoTypeRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(CargoType $cargoType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CargoType $cargoType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCargoTypeRequest $request, CargoType $cargoType)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CargoType $cargoType)
    {
        //
    }
}
