<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Checklist\StoreRequest;
use App\Http\Requests\Checklist\UpdateRequest;
use App\Models\Checklist;
use App\Models\ChecklistGroup;
use App\Services\Checklist\Contracts\ChecklistServiceContract;
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

            return redirect()->route('dashboard')->with('alert.success', 'Checklist was created');
        } catch (Throwable $e) {
            return redirect()->back()->with('alert.error', $e->getMessage());
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

            return redirect()->route('dashboard')->with('alert.success', 'Checklist was updated');
        } catch (Throwable $e) {
            return redirect()->back()->with('alert.error', $e->getMessage());
        }
    }
}