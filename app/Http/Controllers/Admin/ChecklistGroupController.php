<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ChecklistGroup\StoreRequest;
use App\Http\Requests\ChecklistGroup\UpdateRequest;
use App\Models\ChecklistGroup;
use App\Services\ChecklistGroup\Contracts\ChecklistGroupServiceContract;
use App\Services\ChecklistGroup\Exceptions\ChecklistGroupCreateFailedException;
use App\Services\ChecklistGroup\Exceptions\ChecklistGroupDeleteFailedException;
use App\Services\ChecklistGroup\Exceptions\ChecklistGroupNotFoundException;
use App\Services\ChecklistGroup\Exceptions\ChecklistGroupUpdateFailedException;
use Illuminate\Support\Facades\Log;
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

            return redirect()->route('page.welcome')->with('alert.success', 'Checklist group was created');
        } catch (ChecklistGroupCreateFailedException $e) {
            return redirect()->back()->with('alert.error', $e->getMessage());
        } catch (Throwable $e) {
            Log::error($e);

            return redirect()->route('page.welcome')->with('alert.error', 'Something went wrong');
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

            return redirect()->route('page.welcome')->with('alert.success', 'Checklist group was updated');
        } catch (ChecklistGroupNotFoundException | ChecklistGroupUpdateFailedException $e) {
            return redirect()->back()->with('alert.error', $e->getMessage());
        } catch (Throwable $e) {
            Log::error($e);

            return redirect()->route('page.welcome')->with('alert.error', 'Something went wrong');
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

            return redirect()->route('page.welcome')->with('alert.success', 'Checklist group was deleted');
        } catch (ChecklistGroupDeleteFailedException | ChecklistGroupNotFoundException $e) {
            return redirect()->back()->with('alert.error', $e->getMessage());
        } catch (Throwable $e) {
            Log::error($e);

            return redirect()->route('page.welcome')->with('alert.error', 'Something went wrong');
        }
    }
}
