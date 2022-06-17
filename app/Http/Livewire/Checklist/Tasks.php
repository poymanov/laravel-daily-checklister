<?php

namespace App\Http\Livewire\Checklist;

use App\Services\Checklist\Contracts\ChecklistServiceContract;
use App\Services\Task\Contracts\TaskServiceContract;
use App\Services\Task\Dtos\TaskDto;
use App\Services\Task\Enums\ChangeOrderDirectionEnum;
use Livewire\Component;
use Throwable;

class Tasks extends Component
{
    /** @var int */
    public $checklistId;

    /** @var TaskDto[] */
    public $tasks;

    /** @var int */
    public $tasksLastOrder;

    /** @var ChecklistServiceContract */
    private $checklistService;

    /** @var TaskServiceContract */
    private $taskService;

    public function __construct(mixed $id = null)
    {
        $this->checklistService = app(ChecklistServiceContract::class);
        $this->taskService      = app(TaskServiceContract::class);

        parent::__construct($id);
    }

    /**
     * @return void
     */
    public function mount(): void
    {
        $this->getTasks();
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function render()
    {
        return view('livewire.checklist.tasks');
    }

    /**
     * Перемещение задачи на предыдующую позицию в порядке сортировки
     *
     * @param int $id
     *
     * @throws Throwable
     */
    public function movePrev(int $id): void
    {
        $this->changeOrder($id, ChangeOrderDirectionEnum::PREV);
    }

    /**
     * Перемещение задачи на следующую позицию в порядке сортировки
     *
     * @param int $id
     *
     * @throws Throwable
     */
    public function moveNext(int $id): void
    {
        $this->changeOrder($id, ChangeOrderDirectionEnum::NEXT);
    }

    /**
     * Изменение порядка сортировки задачи
     *
     * @param int                      $id
     * @param ChangeOrderDirectionEnum $direction
     *
     * @throws Throwable
     * @throws \App\Services\Task\Exceptions\TaskNotFoundException
     */
    public function changeOrder(int $id, ChangeOrderDirectionEnum $direction): void
    {
        $this->taskService->changeOrder($id, $direction);

        $this->getTasks();
    }

    /**
     * Получение задач чеклиста
     */
    private function getTasks(): void
    {
        $this->tasks          = $this->taskService->findAllByChecklistId($this->checklistId);
        $this->tasksLastOrder = $this->checklistService->getTasksLastOrder($this->checklistId);
    }
}
