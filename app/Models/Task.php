<?php

namespace App\Models;

use App\Enums\TaskStatusEnum;
use App\Enums\TaskPriorityEnum;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Builder;

class Task extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'status' => TaskStatusEnum::class,
        'priority' => TaskPriorityEnum::class,
        'due_date' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($task) {
            $task->created_by_id = authUser()->id;
            $task->status = TaskStatusEnum::PENDING;
            $task->priority = TaskPriorityEnum::LOW;
        });
    }

    public function assignedUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assignee_id');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by_id');
    }

    /**
     * Get the tasks that this task depends on (its prerequisites).
     *
     * Example:
     * If task A requires tasks B and C to be completed first,
     * then $taskA->dependencies will return [TaskB, TaskC].
     */
    public function dependencies(): BelongsToMany
    {
        return $this->belongsToMany(Task::class, 'task_dependencies', 'task_id', 'depends_on_task_id');
    }

    /**
     * Get the tasks that depend on this task (its dependents).
     *
     * Example:
     * If task A depends on task B,
     * then $taskB->dependents will return [TaskA].
     */

    public function dependents(): BelongsToMany
    {
        return $this->belongsToMany(Task::class, 'task_dependencies', 'depends_on_task_id', 'task_id');
    }


    public function scopeDateRange(Builder $query, ?string $dateRange, ?string $to = null): Builder
    {
        [$from, $to] = match (true) {
            $dateRange && is_null($to) && str_contains($dateRange, ',') => array_map('trim', explode(',', $dateRange, 2)),
            $dateRange && is_null($to)                                  => [$dateRange, $dateRange],
            default                                                     => [$dateRange, $to],
        };

        $from = $from ? Carbon::parse($from)->startOfDay() : null;
        $to   = $to ? Carbon::parse($to)->endOfDay() : null;

        return $query
            ->when($from && $to, fn ($q) => $q->whereBetween('due_date', [$from, $to]))
            ->when($from && ! $to, fn ($q) => $q->where('due_date', '>=', $from))
            ->when(! $from && $to, fn ($q) => $q->where('due_date', '<=', $to));
    }


    public function allDependenciesCompleted(): bool
    {
        return $this->dependencies()
                    ->where('status', '!=', TaskStatusEnum::COMPLETED)
                    ->doesntExist();
    }

    public function getIncompleteDependencies()
    {
        return $this->dependencies()
                    ->where('status', '!=', TaskStatusEnum::COMPLETED)
                    ->get();
    }

    public function canChangeStatusTo(TaskStatusEnum $newStatus): bool
    {
        if ($newStatus !== TaskStatusEnum::COMPLETED) {
            return true;
        }

        return $this->allDependenciesCompleted();
    }

}
