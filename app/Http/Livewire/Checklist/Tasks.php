<?php

namespace App\Http\Livewire\Checklist;

use App\Services\Checklist\Contracts\ChecklistServiceContract;
use App\Services\Task\Contracts\TaskServiceContract;
use App\Services\Task\Dtos\TaskDto;
use App\Services\Task\Enums\ChangeOrderDirectionEnum;
use App\Services\Task\Exceptions\TaskNotFoundException;
use Livewire\Component;
use Session;
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

    /** @var array */
    public $openedTasks = [];

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
     * @throws TaskNotFoundException
     */
    public function changeOrder(int $id, ChangeOrderDirectionEnum $direction): void
    {
        $this->taskService->changeOrder($id, $direction);

        $this->getTasks();
    }

    /**
     * @param int $taskId
     */
    public function toggle(int $taskId): void
    {
        if (in_array($taskId, $this->openedTasks)) {
            $this->openedTasks = array_diff($this->openedTasks, [$taskId]);
        } else {
            $this->openedTasks[] = $taskId;
        }

        $this->getTasks();
    }

    /**
     * Завершение задачи
     *
     * @param int $taskId
     *
     * @return \Illuminate\Http\RedirectResponse|void
     */
    public function complete(int $taskId)
    {
        try {
            $this->taskService->complete($taskId, (int) auth()->id());

            $this->emit('changeTaskCompleteStatus', $this->checklistId);

            $this->getTasks();
        } catch (Throwable $e) {
            Session::flash('alert.error', $e->getMessage());

            return redirect()->to(route('page.welcome'));
        }
    }

    /**
     * Отмена завершения задачи
     *
     * @param int $taskId
     *
     * @return \Illuminate\Http\RedirectResponse|void
     */
    public function incomplete(int $taskId)
    {
        try {
            $this->taskService->incomplete($taskId);

            $this->emit('changeTaskCompleteStatus', $this->checklistId);

            $this->getTasks();
        } catch (Throwable $e) {
            Session::flash('alert.error', $e->getMessage());

            return redirect()->to(route('page.welcome'));
        }
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
