<?php

namespace App\Http\Livewire\Checklist;

use App\Services\Checklist\Contracts\ChecklistServiceContract;
use App\Services\Checklist\Exceptions\ChecklistNotFoundException;
use Livewire\Component;

class ChecklistTopItem extends Component
{
    public int $checklistId;

    public string $checklistName;

    public int $progressRate = 0;

    /** @var ChecklistServiceContract */
    private $checklistService;

    /** @phpstan-ignore-next-line */
    protected $listeners = ['changeTaskCompleteStatus' => 'recountProgress'];

    /**
     * @param mixed|null $id
     *
     * @throws ChecklistNotFoundException
     */
    public function __construct(mixed $id = null)
    {
        $this->checklistService = app(ChecklistServiceContract::class);

        parent::__construct($id);
    }

    /**
     * @return void
     * @throws ChecklistNotFoundException
     */
    public function mount(): void
    {
        $checklist = $this->checklistService->findOneById($this->checklistId);

        $this->checklistName = $checklist->name;

        $this->countProgress();
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function render()
    {
        return view('livewire.checklist.checklist-top-item');
    }

    /**
     * @param int $checklistId
     */
    public function recountProgress(int $checklistId): void
    {
        if ($this->checklistId != $checklistId) {
            return;
        }

        $this->countProgress();
    }

    /**
     * @return void
     * @throws ChecklistNotFoundException
     */
    private function countProgress(): void
    {
        $completedTasks = $this->checklistService->countCompletedTasks($this->checklistId);
        $totalTasks     = $this->checklistService->countTasks($this->checklistId);

        if ($totalTasks > 0) {
            $this->progressRate = intval(($completedTasks / $totalTasks) * 100);
        }
    }
}
