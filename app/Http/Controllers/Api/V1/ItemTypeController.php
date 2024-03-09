<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\ItemType;
use Illuminate\Http\Request;
use App\Http\Requests\StoreItemTypeRequest;
use App\Http\Requests\UpdateItemTypeRequest;
use App\Filters\V1\ItemTypeFilter;
use App\Http\Resources\V1\ItemTypeCollection;

class ItemTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
    }
    /**
     * Display a listing of the resource.
     */
    public function dropdown(Request $request)
    {
        $filter = new ItemTypeFilter();
        $filterItems =  $filter->transform($request); //[['column', 'operator', 'value']]
        $itemTypes = ItemType::where($filterItems)->orderBy('name');
        
        return new ItemTypeCollection($itemTypes->paginate()->appends($request->query()));
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
    public function store(StoreItemTypeRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(ItemType $itemType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ItemType $itemType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateItemTypeRequest $request, ItemType $itemType)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ItemType $itemType)
    {
        //
    }
}
