<?php

namespace App\Http\Livewire\Checklist;

use App\Services\Checklist\Contracts\ChecklistServiceContract;
use Livewire\Component;

class ChecklistMenuItem extends Component
{
    /** @var int */
    public int $totalTasks = 0;

    /** @var int */
    public int $completedTasks = 0;

    /** @var int */
    public int $checklistGroupId;

    /** @var int */
    public int $checklistId;

    /** @var string */
    public string $checklistName;

    /** @var ChecklistServiceContract */
    private ChecklistServiceContract $checklistService;

    /** @phpstan-ignore-next-line */
    protected $listeners = ['changeTaskCompleteStatus' => 'recountChecklistData'];

    public function __construct(mixed $id = null)
    {
        $this->checklistService = app(ChecklistServiceContract::class);

        parent::__construct($id);
    }

    public function mount(): void
    {
        $this->countChecklistData();
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function render()
    {
        return view('livewire.checklist.checklist-menu-item');
    }

    /**
     * @param int $checklistId
     */
    public function recountChecklistData(int $checklistId): void
    {
        if ($this->checklistId != $checklistId) {
            return;
        }

        $this->countChecklistData();
    }

    private function countChecklistData(): void
    {
        $this->completedTasks = $this->checklistService->countCompletedTasks($this->checklistId);
        $this->totalTasks     = $this->checklistService->countTasks($this->checklistId);
    }
}
