<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Inquiry;
use App\Models\CargoType;
use Illuminate\Http\Request;
use App\Http\Requests\StoreInquiryRequest;
use App\Http\Requests\UpdateInquiryRequest;
use App\Http\Resources\V1\InquiryResource;
use App\Filters\V1\InquiryFilter;
use App\Services\InquiryService;
use App\Http\Resources\V1\InquiryCollection;
use Illuminate\Validation\ValidationException;
// use App\Http\Resources\V1\CustomerCollection;

class InquiryController extends Controller
{
    protected $inquiryService;
    public function __construct(InquiryService $inquiryService)
    {
        $this->inquiryService = $inquiryService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filter = new InquiryFilter();
        $filterItems =  $filter->transform($request);
        return $this->inquiryService->getAllInquiries($request);
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function receive(Request $request, $id)
    {
        $permitted = $this->hasPermission(Inquiry::TAG.Inquiry::PERMISSION_RECEIVE);
        if (!$permitted) {
            return response()->json(['message' => 'Action unauthorized. Please refresh the page.'], 401);
        }
        if ($id) {
            $inquiry = Inquiry::with('cargoType','itemType')->where('id', $id)->first();
            
            $this->authorize('receive', $inquiry);
            $inquiry->status = Inquiry::STATUS_RECEIVED;
            $inquiry->received_at = now();
            $inquiry->save();
            return new InquiryResource($inquiry);
        }
    }
    
    public function invalid(Request $request, $id)
    {
        if ($id) {
            $inquiry = Inquiry::with('cargoType','itemType')->where('id', $id)->first();
            
            $this->authorize('invalid', $inquiry);
            $inquiry->status = Inquiry::STATUS_INVALID;
            $inquiry->save();
            return new InquiryResource($inquiry, $this);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreInquiryRequest $request)
    {
        return new InquiryResource(Inquiry::create($request->all()));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, $id)
    {
        if ($id) {
            $inquiry = Inquiry::with('cargoType','itemType')->where('id',$id)->first();
            if ($inquiry) {
                return new InquiryResource($inquiry);
            }
            throw ValidationException::withMessages(['error' => 'No Inquiry Found']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function showByRefNum(Request $request, $referenceNumber)
    {
        if ($referenceNumber) {
            return new InquiryResource(Inquiry::where('referenceNumber', $referenceNumber)->first());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Inquiry $inquiry)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateInquiryRequest $request, Inquiry $inquiry)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Inquiry $inquiry)
    {
        //
    }
}
