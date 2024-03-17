<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Consignee;
use App\Http\Requests\StoreConsigneeRequest;
use App\Http\Requests\UpdateConsigneeRequest;
use App\Http\Resources\V1\Consignee\ConsigneeCollection;
use Illuminate\Http\Request;
use App\Filters\V1\DropdownFilter;

class ConsigneeController extends Controller
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
    public function store(StoreConsigneeRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Consignee $consignee)
    {
        //
    }

    /**
     * Display a listing of the resource.
     */
    public function dropdown(Request $request)
    {
        $consignees = Consignee::where('name','like', '%'.$request->input('name').'%')->limit(10)->get();
        if ($consignees) {
            return $consignees;
        }
        throw ValidationException::withMessages(['error' => 'No consignee Found']);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Consignee $consignee)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateConsigneeRequest $request, Consignee $consignee)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Consignee $consignee)
    {
        //
    }
}
