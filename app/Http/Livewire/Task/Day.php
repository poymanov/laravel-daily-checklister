<?php

namespace App\Http\Livewire\Task;

use App\Services\DayTask\Contracts\DayTaskServiceContract;
use Livewire\Component;
use Session;
use Throwable;

class Day extends Component
{
    public int $taskId;

    public bool $isAdded = false;

    private DayTaskServiceContract $dayTaskService;

    public function __construct(mixed $id = null)
    {
        $this->dayTaskService = app(DayTaskServiceContract::class);

        parent::__construct($id);
    }

    public function mount(): void
    {
        $this->checkAdded();
    }

    /**
     * @return \Illuminate\Http\RedirectResponse|void
     */
    public function add()
    {
        try {
            $this->dayTaskService->add($this->taskId, (int) auth()->id());

            $this->checkAdded();
        } catch (Throwable $e) {
            Session::flash('alert.error', $e->getMessage());

            return redirect()->to(route('page.welcome'));
        }
    }

    /**
     * @return \Illuminate\Http\RedirectResponse|void
     */
    public function remove()
    {
        try {
            $this->dayTaskService->remove($this->taskId, (int) auth()->id());

            $this->checkAdded();
        } catch (Throwable $e) {
            Session::flash('alert.error', $e->getMessage());

            return redirect()->to(route('page.welcome'));
        }
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function render()
    {
        return view('livewire.task.day');
    }

    /**
     * Проверка, есть ли текущая задача у пользователя в задачах дня
     */
    private function checkAdded(): void
    {
        $this->isAdded = $this->dayTaskService->isExists($this->taskId, (int) auth()->id());
    }
}
