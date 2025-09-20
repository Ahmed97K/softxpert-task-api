<?php

namespace App\Http\Controllers;

use App\Http\Resources\IndexTaskResource;
use App\Models\Task;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class AdminTaskController extends Controller
{
    public function index(Request $request)
    {
        $tasks = QueryBuilder::for(Task::class)
            ->allowedFilters([
                AllowedFilter::exact('status'),
                AllowedFilter::exact('assignee_id'),
                AllowedFilter::scope('date_range', 'dateRange'),
                AllowedFilter::exact('priority'),
            ])
            ->with(['assignee', 'creator'])
            ->allowedSorts(['status', 'priority', 'due_date'])
            ->paginate(globalPerPage($request))
            ->appends(request()->query());

        return IndexTaskResource::collection($tasks);
    }

}
