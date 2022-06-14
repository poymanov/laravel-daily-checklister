<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Task\StoreRequest;
use App\Http\Requests\Task\UpdateRequest;
use App\Models\Checklist;
use App\Models\Task;
use App\Services\Checklist\Contracts\ChecklistServiceContract;
use App\Services\Task\Contracts\TaskServiceContract;
use Throwable;

class TaskController extends Controller
{
    public function __construct(private ChecklistServiceContract $checklistService, private TaskServiceContract $taskService)
    {
    }

    /**
     * @param Checklist $checklist
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     * @throws \App\Services\Checklist\Exceptions\ChecklistNotFoundException
     */
    public function create(Checklist $checklist)
    {
        $checklist = $this->checklistService->findOneById($checklist->id);

        return view('admin.task.create', compact('checklist'));
    }

    /**
     * @param StoreRequest $request
     * @param Checklist    $checklist
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreRequest $request, Checklist $checklist)
    {
        try {
            $this->taskService->create($checklist->id, $request->get('name'), $request->get('description'));

            return redirect()
                ->route(
                    'admin.checklist-groups.checklists.show',
                    ['checklist_group' => $checklist->checklist_group_id, 'checklist' => $checklist->id]
                )
                ->with('alert.success', 'Task was created');
        } catch (Throwable $e) {
            return redirect()->back()->with('alert.error', $e->getMessage());
        }
    }

    /**
     * @param Checklist $checklist
     * @param Task      $task
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(Checklist $checklist, Task $task)
    {
        return view('admin.task.edit', compact('checklist', 'task'));
    }

    /**
     * @param UpdateRequest $request
     * @param Checklist     $checklist
     * @param Task          $task
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateRequest $request, Checklist $checklist, Task $task)
    {
        try {
            $this->taskService->update($task->id, $request->get('name'), $request->get('description'));

            return redirect()
                ->route('admin.checklist-groups.checklists.show', ['checklist_group' => $checklist->group->id, 'checklist' => $checklist->id])
                ->with('alert.success', 'Task was updated');
        } catch (Throwable $e) {
            return redirect()->back()->with('alert.error', $e->getMessage());
        }
    }
}
