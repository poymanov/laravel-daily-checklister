<?php

namespace App\Http\Controllers;

use App\Http\Requests\Task\StoreRequest;
use App\Http\Requests\Task\UpdateRequest;
use App\Models\Checklist;
use App\Models\Task;
use App\Services\Checklist\Contracts\ChecklistServiceContract;
use App\Services\Checklist\Exceptions\ChecklistNotFoundException;
use App\Services\Task\Contracts\TaskServiceContract;
use App\Services\Task\Exceptions\TaskCreateFailedException;
use App\Services\Task\Exceptions\TaskDeleteFailedException;
use App\Services\Task\Exceptions\TaskNotFoundException;
use App\Services\Task\Exceptions\TaskUpdateFailedException;
use Illuminate\Support\Facades\Log;
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

        return view('task.create', compact('checklist'));
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
                    'checklist-groups.checklists.show',
                    ['checklist_group' => $checklist->checklist_group_id, 'checklist' => $checklist->id]
                )
                ->with('alert.success', 'Task was created');
        } catch (TaskCreateFailedException | ChecklistNotFoundException $e) {
            return redirect()->back()->with('alert.error', $e->getMessage());
        } catch (Throwable $e) {
            Log::error($e);

            return redirect()->route('page.welcome')->with('alert.error', 'Something went wrong');
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
        return view('task.edit', compact('checklist', 'task'));
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
                ->route('checklist-groups.checklists.show', ['checklist_group' => $checklist->group->id, 'checklist' => $checklist->id])
                ->with('alert.success', 'Task was updated');
        } catch (TaskNotFoundException | TaskUpdateFailedException $e) {
            return redirect()->back()->with('alert.error', $e->getMessage());
        } catch (Throwable $e) {
            Log::error($e);

            return redirect()->route('page.welcome')->with('alert.error', 'Something went wrong');
        }
    }

    /**
     * @param Checklist $checklist
     * @param Task      $task
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Checklist $checklist, Task $task)
    {
        try {
            $this->taskService->delete($task->id);

            return redirect()
                ->route('checklist-groups.checklists.show', ['checklist_group' => $checklist->group->id, 'checklist' => $checklist->id])
                ->with('alert.success', 'Task was deleted');
        } catch (TaskDeleteFailedException | TaskNotFoundException $e) {
            return redirect()->back()->with('alert.error', $e->getMessage());
        } catch (Throwable $e) {
            Log::error($e);

            return redirect()->route('page.welcome')->with('alert.error', 'Something went wrong');
        }
    }
}
