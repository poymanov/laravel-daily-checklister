<?php

declare(strict_types=1);

namespace App\View\Components;

use App\Services\Checklist\ChecklistService;
use Illuminate\View\Component;

class ChecklistTop extends Component
{
    public function render()
    {
        $checklistService = app(ChecklistService::class);
        $checklists       = $checklistService->findAllTop();

        return view('components.checklist-top', compact('checklists'));
    }
}
