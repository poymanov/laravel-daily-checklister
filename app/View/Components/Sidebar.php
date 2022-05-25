<?php

namespace App\View\Components;

use App\Services\ChecklistGroup\Contracts\ChecklistGroupServiceContract;
use Illuminate\View\Component;

class Sidebar extends Component
{
    public function __construct(private ChecklistGroupServiceContract $checklistGroupService)
    {
    }

    public function render()
    {

        $checklistGroups = $this->checklistGroupService->findAll();

        return view('components.sidebar', compact('checklistGroups'));
    }
}
