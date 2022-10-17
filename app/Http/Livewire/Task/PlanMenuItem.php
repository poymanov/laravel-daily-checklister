<?php

namespace App\Http\Livewire\Task;

use App\Models\User;
use App\Services\PlanTask\Contracts\PlanTaskServiceContract;
use Livewire\Component;

class PlanMenuItem extends Component
{
    public int $tasksCount = 0;

    /** @phpstan-ignore-next-line */
    protected $listeners = ['updatePlan' => 'countTasks'];

    private PlanTaskServiceContract $planTaskService;

    public function __construct(mixed $id = null)
    {
        $this->planTaskService = app(PlanTaskServiceContract::class);

        parent::__construct($id);
    }

    public function mount(): void
    {
        $this->countTasks();
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function render()
    {
        return view('livewire.task.plan-menu-item');
    }

    /**
     * @return void
     */
    public function countTasks(): void
    {
        /** @var User|null $user */
        $user = auth()->user();

        if (!$user) {
            return;
        }

        $this->tasksCount = $this->planTaskService->countByUserId($user->id);
    }
}
