<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\UpdateUserTaskStatusRequest;
use App\Http\Resources\User\UserTaskCollection;
use App\Http\Resources\User\UserTaskResource;
use App\Models\Task;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class UserTaskController extends Controller
{

    public function index(Request $request)
    {
        $tasks = QueryBuilder::for(Task::class)
            ->allowedFilters([
                AllowedFilter::exact('status'),
                AllowedFilter::scope('date_range', 'dateRange'),
                AllowedFilter::exact('priority'),
            ])
            ->assignedToCurrentUser()
            ->with(['assignedUser', 'creator'])
            ->allowedSorts(['status', 'priority', 'due_date'])
            ->paginate(globalPerPage($request))
            ->appends(request()->query());

        return $this->ok(data: UserTaskResource::collection($tasks)->response()->getData(true));
    }


    public function show(Task $task)
    {
        $this->authorize('view', $task);

        $task->load(['assignedUser', 'creator']);
        return $this->ok(data: UserTaskResource::make($task)->response()->getData(true));
    }


    public function updateTaskStatus(Task $task, UpdateUserTaskStatusRequest $request)
    {

        $task->update($request->validated());

        $task->load(['assignedUser', 'creator']);
        return $this->ok(
            message: 'Task status updated successfully',
            data: UserTaskResource::make($task)->response()->getData(true)
        );
    }
}
