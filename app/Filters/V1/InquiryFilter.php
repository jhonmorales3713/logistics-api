<?php
namespace App\Filters\V1;

use Illuminate\Http\Request;
use App\Filters\ApiFilter;
use App\Libraries\QueryTranslations;

class InquiryFilter extends ApiFilter {
    protected $validParams = [
        'email' => ['like'],
        'referenceNumber' => ['like'],
        'status' => ['eq'],
        'tergetDate' => ['eq', 'gt', 'gte', 'lt', 'lte'],
        'itemType' => ['eq'],
        'cargoType' => ['eq']
    ];
    protected $columnMap = [
        'itemType_id' => ['eq'],
        'cargoType_id' => ['eq'],
    ];
}