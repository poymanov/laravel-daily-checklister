<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Task\StoreRequest;
use App\Models\Checklist;
use App\Services\Checklist\Contracts\ChecklistServiceContract;
use App\Services\Task\Contracts\TaskServiceContract;
use App\Services\Task\Factories\TaskCreateDtoFactory;
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
            $checklistDto = $this->checklistService->findOneById($checklist->id);
            $task         = TaskCreateDtoFactory::createFromParams($checklistDto->id, $request->get('name'), $request->get('description'));
            $this->taskService->create($task);

            return redirect()
                ->route(
                    'admin.checklist-groups.checklists.show',
                    ['checklist_group' => $checklistDto->checklistGroupId, 'checklist' => $checklistDto->id]
                )
                ->with('alert.success', 'Task was created');
        } catch (Throwable $e) {
            return redirect()->back()->with('alert.error', $e->getMessage());
        }
    }
}
