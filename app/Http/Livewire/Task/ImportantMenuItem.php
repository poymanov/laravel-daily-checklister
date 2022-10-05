<?php

namespace App\Http\Livewire\Task;

use App\Models\User;
use App\Services\ImportantTask\Contracts\ImportantTaskServiceContract;
use Livewire\Component;

class ImportantMenuItem extends Component
{
    public int $tasksCount = 0;

    /** @phpstan-ignore-next-line */
    protected $listeners = ['updateImportant' => 'countTasks'];

    private ImportantTaskServiceContract $importantTaskService;

    public function __construct(mixed $id = null)
    {
        $this->importantTaskService = app(ImportantTaskServiceContract::class);

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
        return view('livewire.task.important-menu-item');
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

        $this->tasksCount = $this->importantTaskService->countByUserId($user->id);
    }
}
