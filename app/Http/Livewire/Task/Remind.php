<?php

namespace App\Http\Livewire\Task;

use App\Models\User;
use App\Services\RemindTask\Contracts\RemindTaskServiceContract;
use Illuminate\Support\Carbon;
use Livewire\Component;
use Session;
use Throwable;

class Remind extends Component
{
    public int $taskId;

    /** @var string|null */
    public ?string $remindDate = null;

    /** @var string|null */
    public ?string $remindTime = null;

    /** @var bool */
    public bool $showOptions = false;

    /** @var Carbon|null */
    public ?Carbon $savedRemindDate;

    private RemindTaskServiceContract $remindTaskService;

    public function __construct(mixed $id = null)
    {
        $this->remindTaskService = app(RemindTaskServiceContract::class);

        parent::__construct($id);
    }

    public function mount(): void
    {
        $this->remindDate = now()->addWeek()->toDateString();
        $this->remindTime = now()->toTimeString('minutes');

        $this->checkSavedRemindDate();
    }

    /**
     * @return \Illuminate\Http\RedirectResponse|void
     */
    public function add()
    {
        if (!$this->remindDate || !$this->remindTime) {
            return;
        }

        try {
            $this->remindTaskService->create($this->taskId, (int)auth()->id(), $this->remindDate, $this->remindTime);

            $this->checkSavedRemindDate();
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
            $this->remindTaskService->delete($this->taskId, (int)auth()->id());

            $this->showOptions = false;

            $this->checkSavedRemindDate();
        } catch (Throwable $e) {
            Session::flash('alert.error', $e->getMessage());

            return redirect()->to(route('page.welcome'));
        }
    }

    /**
     * @return void
     */
    public function remindTomorrow(): void
    {
        $this->remindDate = now()->addDay()->toDateString();

        $this->add();
    }

    /**
     * @return void
     */
    public function remindNextMonday(): void
    {
        $this->remindDate = now()->next('Monday')->toDateString();

        $this->add();
    }

    /**
     * @return void
     */
    public function openOptions(): void
    {
        $this->showOptions = true;
    }

    /**
     * Проверка, есть ли текущая задача у пользователя в напоминаниях
     */
    private function checkSavedRemindDate(): void
    {
        /** @var User|null $user */
        $user = auth()->user();

        if (!$user) {
            return;
        }

        $remindTaskDto = $this->remindTaskService->findOneByTaskIdAndUserId($this->taskId, $user->id);

        if ($remindTaskDto) {
            $this->savedRemindDate = Carbon::createFromTimestamp($remindTaskDto->date);
        } else {
            $this->savedRemindDate = null;
        }
    }
}
