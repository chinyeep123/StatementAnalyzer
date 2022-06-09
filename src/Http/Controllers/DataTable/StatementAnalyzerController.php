<?php
namespace Ant\StatementAnalyzer\Http\Controllers\DataTable;

use App\Http\Controllers\Controller;
// use App\Models\Order;

class StatementAnalyzerController extends Controller {
    public function builder()
    {
        // return Order::query()->with('invoice');
    }

    public function getDisplayableColumns()
    {
        return app('admin-layout')->getDisplayableColumnsForCollection('order');
    }

    public function getFilterable()
    {
        return [
            'number',
            'status',
        ];
    }

    public function getSortable()
    {
        return [
            'id',
            'status',
            'created_at',
            'updated_at',
        ];
    }

    public function getCustomColumnNames()
    {
        return [
        ];
    }
}