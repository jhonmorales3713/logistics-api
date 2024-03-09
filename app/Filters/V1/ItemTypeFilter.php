<?php
namespace App\Filters\V1;

use Illuminate\Http\Request;
use App\Filters\ApiFilter;
use App\Libraries\QueryTranslations;

class ItemTypeFilter extends ApiFilter {
    protected $validParams = [
        'name' => ['eq', 'like'],
        'status' => ['eq'],
    ];
}