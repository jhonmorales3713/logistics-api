<?php
namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Models\Inquiry;
use Illuminate\Http\Request;

class InquiryService
{
    public function getAllInquiries(Request $request)
    {
        $page = (int)($request->query('page') ?? 1 ) - 1;
        $limit = $request->query('limit') ?? 15; 
        $search = $request->query('search');
        $orderBy = $request->query('sortBy') ?? '-targetDate';
        // filters
        $itemType = (int)$request->query('itemType');
        $status = (int)$request->query('status');
        $deliveryType = $request->query('deliveryType');
        $cargoType = (int)$request->query('cargoType');
        $targetDateFrom = $request->query('targetDateFrom');
        $targetDateTo = $request->query('targetDateTo');
        // end of filters
        $inquiries = DB::table('inquiries')
            ->leftJoin('cargo_types', 'cargo_types.id', '=', 'inquiries.cargoType_id')
            ->leftJoin('item_types', 'item_types.id', '=', 'inquiries.itemType_id')
            ->select('inquiries.*',
            'cargo_types.name as cargoType', 'cargo_types.id as cargoId',
            'item_types.name as itemType', 'item_types.id as itemTypeId',
        );
        if ($search != '') {
            $inquiries->where('referenceNumber', 'like', "%{$search}%" );
            $inquiries->orWhere('email', 'like', "%{$search}%" );
        }
        if($itemType) {
            $inquiries->where('item_types.id', '=', "$itemType" );
        }
        if($status) {
            $inquiries->where('status', '=', "$status" );
        }
        if($cargoType) {
            $inquiries->where('cargo_types.id', '=', "$cargoType" );
        }
        if ($deliveryType) {
            $inquiries->where('deliveryType', '=', "$deliveryType" );
        }
        if ($targetDateFrom || $targetDateTo) {
            $inquiries->whereBetween('targetDate', [$targetDateFrom, $targetDateTo] );
        }
        $order = substr($orderBy, 0, 1) == '-' ? 'desc' : 'asc';
        $column = $order == 'desc' ? substr($orderBy, 1, strlen($orderBy)) : $orderBy;
        if ($column == 'cargoType') {
            $column = 'cargo_types.name';
        }
        if ($column == 'itemType') {
            $column = 'item_types.name';
        }
        $inquiries->orderBy($column, $order);
        $totalRows = $inquiries->count();
        $inquiries = $inquiries->limit($limit)->offset($page * $limit)->get();
        $inquiryList = [];
        foreach ($inquiries as $inquiry) {
            $inquiryList[] = [
                'id' => $inquiry->id,
                'email' => $inquiry->email,
                'referenceNumber' => $inquiry->referenceNumber,
                'quantity' => $inquiry->quantity,
                'status' => $inquiry->status,
                'targetDate' => $inquiry->targetDate,
                'contactNumber' => $inquiry->contactNumber,
                'deliveryType' => $inquiry->deliveryType,
                'cargoType' => [
                    'id' => $inquiry->cargoId,
                    'name' => $inquiry->cargoType
                ],
                'itemType' => [
                    'id' => $inquiry->itemTypeId,
                    'name' => $inquiry->itemType
                ]
            ];
        }
        return [
            'totalRows' => $totalRows,
            'page' => $page + 1,
            'limit' => $limit,
            'data' => $inquiryList
        ];
    }
}