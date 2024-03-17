<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\GasType;
use App\Http\Requests\StoreGasTypeRequest;
use App\Http\Requests\UpdateGasTypeRequest;
use App\Filters\V1\DropdownFilter;
use App\Http\Resources\V1\GasTypeCollection;
use Illuminate\Http\Request;

class GasTypeController extends Controller
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
        $gasTypes = GasType::where($filterItems)->orderBy('name');
        
        return new GasTypeCollection($gasTypes->paginate()->appends($request->query()));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreGasTypeRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(GasType $gasType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(GasType $gasType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateGasTypeRequest $request, GasType $gasType)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(GasType $gasType)
    {
        //
    }
}
