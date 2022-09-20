<?php

namespace App\Http\Livewire\Task;

use App\Models\User;
use App\Services\DayTask\Contracts\DayTaskServiceContract;
use Livewire\Component;

class DayMenuItem extends Component
{
    public int $tasksCount = 0;

    /** @phpstan-ignore-next-line */
    protected $listeners = ['updateMyDay' => 'countTasks'];

    private DayTaskServiceContract $dayTaskService;

    public function __construct(mixed $id = null)
    {
        $this->dayTaskService = app(DayTaskServiceContract::class);

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
        return view('livewire.task.menu-item');
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

        $this->tasksCount = $this->dayTaskService->countByUserId($user->id);
    }
}
