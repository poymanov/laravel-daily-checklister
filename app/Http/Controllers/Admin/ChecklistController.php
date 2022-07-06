<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Checklist\StoreRequest;
use App\Http\Requests\Checklist\UpdateRequest;
use App\Models\Checklist;
use App\Models\ChecklistGroup;
use App\Services\Checklist\Contracts\ChecklistServiceContract;
use App\Services\Checklist\Exceptions\ChecklistCreateFailedException;
use App\Services\Checklist\Exceptions\ChecklistDeleteFailedException;
use App\Services\Checklist\Exceptions\ChecklistNotFoundException;
use App\Services\Checklist\Exceptions\ChecklistUpdateFailedException;
use App\Services\ChecklistGroup\Exceptions\ChecklistGroupNotFoundException;
use Illuminate\Support\Facades\Log;
use Throwable;

class ChecklistController extends Controller
{
    public function __construct(private ChecklistServiceContract $checklistService)
    {
    }

    /**
     * @param ChecklistGroup $checklistGroup
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create(ChecklistGroup $checklistGroup)
    {
        return view('admin.checklist.create', compact('checklistGroup'));
    }

    /**
     * @param StoreRequest   $request
     * @param ChecklistGroup $checklistGroup
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreRequest $request, ChecklistGroup $checklistGroup)
    {
        try {
            $this->checklistService->create($checklistGroup->id, $request->get('name'));

            return redirect()->route('page.welcome')->with('alert.success', 'Checklist was created');
        } catch (ChecklistCreateFailedException | ChecklistGroupNotFoundException $e) {
            return redirect()->back()->with('alert.error', $e->getMessage());
        } catch (Throwable $e) {
            Log::error($e);

            return redirect()->route('page.welcome')->with('alert.error', 'Something went wrong');
        }
    }

    /**
     * @param ChecklistGroup $checklistGroup
     * @param Checklist      $checklist
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(ChecklistGroup $checklistGroup, Checklist $checklist)
    {
        return view('admin.checklist.edit', compact('checklistGroup', 'checklist'));
    }

    /**
     * @param UpdateRequest  $request
     * @param ChecklistGroup $checklistGroup
     * @param Checklist      $checklist
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateRequest $request, ChecklistGroup $checklistGroup, Checklist $checklist)
    {
        try {
            $this->checklistService->update($checklist->id, $request->get('name'));

            return redirect()
                ->route('admin.checklist-groups.checklists.show', ['checklist_group' => $checklistGroup, 'checklist' => $checklist])
                ->with('alert.success', 'Checklist was updated');
        } catch (ChecklistNotFoundException | ChecklistUpdateFailedException $e) {
            return redirect()->back()->with('alert.error', $e->getMessage());
        } catch (Throwable $e) {
            Log::error($e);

            return redirect()->route('page.welcome')->with('alert.error', 'Something went wrong');
        }
    }

    /**
     * @param ChecklistGroup $checklistGroup
     * @param Checklist      $checklist
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(ChecklistGroup $checklistGroup, Checklist $checklist)
    {
        try {
            $this->checklistService->delete($checklist->id);

            return redirect()->route('page.welcome')->with('alert.success', 'Checklist was deleted');
        } catch (ChecklistDeleteFailedException | ChecklistNotFoundException $e) {
            return redirect()->back()->with('alert.error', $e->getMessage());
        } catch (Throwable $e) {
            Log::error($e);

            return redirect()->route('page.welcome')->with('alert.error', 'Something went wrong');
        }
    }

    /**
     * @param ChecklistGroup $checklistGroup
     * @param Checklist      $checklist
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function show(ChecklistGroup $checklistGroup, Checklist $checklist)
    {
        try {
            $checklistDto = $this->checklistService->findOneById($checklist->id);

            return view('admin.checklist.show', ['checklist' => $checklistDto]);
        } catch (ChecklistNotFoundException $e) {
            return redirect()->route('page.welcome')->with('alert.error', $e->getMessage());
        } catch (Throwable $e) {
            Log::error($e);

            return redirect()->route('page.welcome')->with('alert.error', 'Something went wrong');
        }
    }
}
