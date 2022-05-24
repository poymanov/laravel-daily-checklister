<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ChecklisterGroup\StoreRequest;
use App\Http\Requests\ChecklisterGroup\UpdateRequest;
use App\Models\ChecklistGroup;
use App\Services\ChecklistGroup\Contracts\ChecklistGroupServiceContract;
use Throwable;

class ChecklistGroupController extends Controller
{
    public function __construct(private ChecklistGroupServiceContract $checklistGroupService)
    {
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('admin.checklist-group.create');
    }

    /**
     * @param StoreRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreRequest $request)
    {
        try {
            $this->checklistGroupService->create($request->get('name'));

            return redirect()->route('dashboard')->with('alert.success', 'Checklist group was created');
        } catch (Throwable $e) {
            return redirect()->back()->with('alert.error', $e->getMessage());
        }
    }

    /**
     * @param ChecklistGroup $checklistGroup
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(ChecklistGroup $checklistGroup)
    {
        return view('admin.checklist-group.edit', compact('checklistGroup'));
    }

    /**
     * @param UpdateRequest  $request
     * @param ChecklistGroup $checklistGroup
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateRequest $request, ChecklistGroup $checklistGroup)
    {
        try {
            $this->checklistGroupService->update($checklistGroup->id, $request->get('name'));

            return redirect()->route('dashboard')->with('alert.success', 'Checklist group was updated');
        } catch (Throwable $e) {
            return redirect()->back()->with('alert.error', $e->getMessage());
        }
    }

    /**
     * @param ChecklistGroup $checklistGroup
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(ChecklistGroup $checklistGroup)
    {
        try {
            $this->checklistGroupService->delete($checklistGroup->id);

            return redirect()->route('dashboard')->with('alert.success', 'Checklist group was deleted');
        } catch (Throwable $e) {
            return redirect()->back()->with('alert.error', $e->getMessage());
        }
    }
}
