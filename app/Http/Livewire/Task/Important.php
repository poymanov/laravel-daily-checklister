<?php

namespace App\Http\Livewire\Task;

use App\Services\ImportantTask\Contracts\ImportantTaskServiceContract;
use Livewire\Component;
use Session;
use Throwable;

class Important extends Component
{
    public int $taskId;

    public bool $isAdded = false;

    private ImportantTaskServiceContract $importantTaskService;

    public function __construct(mixed $id = null)
    {
        $this->importantTaskService = app(ImportantTaskServiceContract::class);

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
            $this->importantTaskService->add($this->taskId, (int) auth()->id());

            $this->checkAdded();

            $this->emit('updateImportant');
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
            $this->importantTaskService->remove($this->taskId, (int) auth()->id());

            $this->checkAdded();

            $this->emit('updateImportant');
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
        return view('livewire.task.important');
    }

    /**
     * Проверка, есть ли текущая задача у пользователя в задачах дня
     */
    private function checkAdded(): void
    {
        $this->isAdded = $this->importantTaskService->isExists($this->taskId, (int) auth()->id());
    }
}
