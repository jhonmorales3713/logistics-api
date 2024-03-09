<?php
namespace App\Filters;

use Illuminate\Http\Request;
use App\Libraries\QueryTranslations;

class ApiFilter {
    protected $validParams = [];
    protected $columnMap = [];
    public function transform(Request $request) {
        $query = [];
        foreach($this->validParams as $param => $operators) {
            $que = $request->query($param);
            if(!isset($que)) {
                continue;
            }
            $column = $this->columnMap[$param] ?? $param;
            foreach($operators as $operator) {
                if (isset($que[$operator])) {
                    $query[] = [$column, QueryTranslations::operatorMap[$operator], $que[$operator]];
                }
            }
        }
        return $query;
    }
}