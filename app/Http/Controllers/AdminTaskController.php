<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddDependenciesRequest;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Http\Requests\UpdateTaskStatusRequest;
use App\Http\Resources\IndexTaskResource;
use App\Http\Resources\ShowTaskResource;
use App\Http\Resources\StoreTaskResource;
use App\Http\Resources\TaskDependencyResource;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
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
                AllowedFilter::scope('due_date', 'dateRange'),
                AllowedFilter::exact('priority'),
            ])
            ->with(['assignedUser', 'creator', 'dependencies'])
            ->allowedSorts(['status', 'priority', 'due_date'])
            ->paginate(globalPerPage($request))
            ->appends(request()->query());

        return $this->ok(data: IndexTaskResource::collection($tasks)->response()->getData(true));
    }


    public function show(Task $task)
    {
        $task->load(['assignedUser', 'creator', 'dependencies']);
        return $this->ok(data: ShowTaskResource::make($task)->response()->getData(true));
    }


    public function store(StoreTaskRequest $request)
    {
        $task = Task::create($request->validated());

        $task->load(['assignedUser', 'creator']);
        return $this->ok(data: StoreTaskResource::make($task)->response()->getData(true));
    }


    public function update(Task $task, UpdateTaskRequest $request)
    {
        $validated = $request->validated();
        $task->update(Arr::except($validated, ['dependencies']));

        if(!empty($request->dependencies)) {
            $task->dependencies()->sync($request->dependencies);
        }

        $task->load(['assignedUser', 'creator', 'dependencies']);
        return $this->ok(data: ShowTaskResource::make($task)->response()->getData(true), message: __('messages.task_updated'));
    }

    public function addTaskDependencies(Task $task, AddDependenciesRequest $request)
    {
        $task->dependencies()->attach($request->dependencies);

        $task->load(['assignedUser', 'creator', 'dependencies']);
        return $this->ok(
            message: __('messages.dependencies_added'),
            data: ShowTaskResource::make($task)->response()->getData(true)
        );
    }


    public function getTaskDependencies(Task $task)
    {
        $task->load(['dependencies.assignedUser', 'dependencies.creator']);

        return $this->ok(data: [
            'task_id' => $task->id,
            'task_title' => $task->title,
            'dependencies' => TaskDependencyResource::collection($task->dependencies)
        ]);
    }


    public function removeTaskDependency(Task $task, Task $dependency)
    {
        $task->dependencies()->detach($dependency->id);

        return $this->ok(message: __('messages.dependency_removed'));
    }

    public function updateTaskStatus(Task $task, UpdateTaskStatusRequest $request)
    {
        $task->update($request->validated());

        $task->load(['assignedUser', 'creator']);
        return $this->ok(
            message: __('messages.task_status_updated'),
            data: ShowTaskResource::make($task)->response()->getData(true)
        );
    }
}
