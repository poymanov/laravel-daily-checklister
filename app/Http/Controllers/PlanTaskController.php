<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Services\PlanTask\Contracts\PlanTaskServiceContract;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Throwable;

class PlanTaskController extends Controller
{
    public function __construct(private readonly PlanTaskServiceContract $planTaskService)
    {
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $planTasks = $this->planTaskService->findAllByUserId((int)auth()->id());

        return view('plan-task.index', compact('planTasks'));
    }

    /**
     * @param Task $task
     *
     * @return RedirectResponse
     */
    public function destroy(Task $task)
    {
        if (!$this->planTaskService->isExists($task->id, (int)auth()->id())) {
            abort(Response::HTTP_NOT_FOUND);
        }

        try {
            $this->planTaskService->remove($task->id, (int)auth()->id());

            return redirect()->route('tasks.plan.index')->with('alert.success', 'Task was deleted from plan list');
        } catch (Throwable) {
            return redirect()->back()->with('alert.error', 'Failed to delete task from plan list');
        }
    }
}
