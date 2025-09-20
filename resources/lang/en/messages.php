<?php

declare(strict_types=1);

return [
    // Task Management Messages
    'task_created' => 'Task created successfully.',
    'task_updated' => 'Task updated successfully.',
    'task_deleted' => 'Task deleted successfully.',
    'task_status_updated' => 'Task status updated successfully.',

    // Task Dependencies Messages
    'dependencies_added' => 'Dependencies added successfully.',
    'dependencies_updated' => 'Dependencies updated successfully.',
    'dependency_removed' => 'Dependency removed successfully.',
    'no_dependencies' => 'This task has no dependencies.',

    // Authentication Messages
    'logged_in_successfully' => 'Logged in successfully.',
    'logged_out_successfully' => 'Logged out successfully.',

    // Authorization Messages
    'unauthorized' => 'You are not authorized to perform this action.',
    'forbidden' => 'Access denied.',
    'not_found' => 'Resource not found.',

    // Task Assignment Messages
    'task_assigned' => 'Task assigned successfully.',
    'task_unassigned' => 'Task unassigned successfully.',
    'task_reassigned' => 'Task reassigned successfully.',

    // Status Change Messages
    'status_changed_to_pending' => 'Task status changed to pending.',
    'status_changed_to_in_progress' => 'Task status changed to in progress.',
    'status_changed_to_completed' => 'Task status changed to completed.',
    'status_changed_to_cancelled' => 'Task status changed to cancelled.',
    'status_changed_to_on_hold' => 'Task status changed to on hold.',

    // Task Authorization Messages
    'task_not_assigned_to_you' => 'This task is not assigned to you.',
    'cannot_modify_task' => 'You cannot modify this task.',
    'only_assigned_user_can_update_status' => 'Only the assigned user can update task status.',

    // Task Completion Messages
    'cannot_complete_with_incomplete_dependencies' => 'Cannot complete task. The following dependencies must be completed first: :dependencies',
    'task_completed_successfully' => 'Task completed successfully.',
    'all_dependencies_completed' => 'All dependencies have been completed.',

    // Error Messages
    'something_went_wrong' => 'Something went wrong. Please try again.',
    'server_error' => 'Internal server error occurred.',
    'validation_failed' => 'The given data was invalid.',
    'task_not_found' => 'Task not found.',
    'user_not_found' => 'User not found.',
    'invalid_task_status' => 'Invalid task status provided.',

    // Task Priority Messages
    'priority_updated' => 'Task priority updated successfully.',
    'high_priority_task' => 'This is a high priority task.',

    // Dependency Related Messages
    'circular_dependency' => 'Cannot create circular dependency.',
    'self_dependency' => 'Task cannot depend on itself.',
    'dependency_not_found' => 'Dependency task not found.',
    'dependency_already_exists' => 'This dependency already exists.',
];
