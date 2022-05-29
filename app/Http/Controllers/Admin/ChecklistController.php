<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Checklist\StoreRequest;
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
}
