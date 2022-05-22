<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ChecklisterGroup\StoreRequest;
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
}
