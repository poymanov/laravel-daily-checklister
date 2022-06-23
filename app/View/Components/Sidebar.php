<?php

namespace App\View\Components;

use App\Services\ChecklistGroup\Contracts\ChecklistGroupServiceContract;
use App\Services\Page\Contracts\PageServiceContract;
use Illuminate\View\Component;

class Sidebar extends Component
{
    public function __construct(private ChecklistGroupServiceContract $checklistGroupService, private PageServiceContract $pageService)
    {
    }

    public function render()
    {
        $checklistGroups = $this->checklistGroupService->findAll();
        $pages = $this->pageService->findAll();

        return view('components.sidebar', compact('checklistGroups', 'pages'));
    }
}
