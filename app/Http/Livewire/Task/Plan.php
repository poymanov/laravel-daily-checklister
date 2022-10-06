<?php

namespace App\Http\Livewire\Task;

use App\Models\User;
use App\Services\PlanTask\Contracts\PlanTaskServiceContract;
use App\Services\PlanTask\Dtos\PlanTaskDto;
use DateTime;
use Exception;
use Livewire\Component;
use Session;
use Throwable;

class Plan extends Component
{
    public int $taskId;

    /** @var DateTime|null */
    public ?DateTime $plannedDate = null;

    /** @var bool */
    public bool $showOptions = false;

    /** @var string|null */
    public ?string $selectPlanDate = null;

    private PlanTaskServiceContract $planTaskService;

    public function __construct(mixed $id = null)
    {
        $this->planTaskService = app(PlanTaskServiceContract::class);

        parent::__construct($id);
    }

    public function mount(): void
    {
        $this->checkPlannedDate();
    }

    /**
     * @return \Illuminate\Http\RedirectResponse|void
     */
    public function add()
    {
        if (!$this->plannedDate) {
            return;
        }

        try {
            $this->planTaskService->add($this->taskId, (int) auth()->id(), $this->plannedDate);

            $this->checkPlannedDate();

            $this->emit('updatePlan');
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
            $this->planTaskService->remove($this->taskId, (int) auth()->id());

            $this->checkPlannedDate();

            $this->emit('updatePlan');
        } catch (Throwable $e) {
            Session::flash('alert.error', $e->getMessage());

            return redirect()->to(route('page.welcome'));
        }
    }

    public function openOptions(): void
    {
        $this->showOptions = true;
    }

    public function planToday(): void
    {
        $this->plannedDate = now();

        $this->add();
    }

    public function planTomorrow(): void
    {
        $this->plannedDate = now()->addDay();

        $this->add();
    }

    public function planNextWeek(): void
    {
        $this->plannedDate = now()->addWeek();

        $this->add();
    }

    /**
     * @throws Exception
     */
    public function updatedSelectPlanDate(): void
    {
        if (!$this->selectPlanDate) {
            return;
        }

        $this->plannedDate = new DateTime($this->selectPlanDate);

        $this->add();
    }

    /**
     * Проверка, есть ли текущая задача у пользователя в запланированных задачах
     */
    private function checkPlannedDate(): void
    {
        /** @var User|null $user */
        $user = auth()->user();

        if (!$user) {
            return;
        }

        /** @var PlanTaskDto|null $planTask */
        $planTask = $this->planTaskService->findOneByTaskId($this->taskId);

        if ($planTask) {
            $this->plannedDate = $planTask->date;
        } else {
            $this->plannedDate = null;
        }
    }
}
