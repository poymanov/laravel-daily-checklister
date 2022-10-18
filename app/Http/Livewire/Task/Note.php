<?php

namespace App\Http\Livewire\Task;

use App\Models\User;
use App\Services\TaskNote\Contracts\TaskNoteServiceContract;
use Livewire\Component;
use Session;
use Throwable;

class Note extends Component
{
    public int $taskId;

    public ?string $text = null;

    public ?string $textareaText = null;

    public bool $textareaOpened = false;

    private TaskNoteServiceContract $taskNoteService;

    public function __construct(mixed $id = null)
    {
        $this->taskNoteService = app(TaskNoteServiceContract::class);

        parent::__construct($id);
    }

    public function mount(): void
    {
        $this->checkText();

        $this->textareaText = $this->text;
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function render()
    {
        return view('livewire.task.note');
    }

    /**
     * @return \Illuminate\Http\RedirectResponse|void
     */
    public function add()
    {
        if (!$this->textareaText) {
            return;
        }

        try {
            $this->taskNoteService->create($this->taskId, (int)auth()->id(), $this->textareaText);

            $this->checkText();

            $this->textareaOpened = false;
        } catch (Throwable $e) {
            Session::flash('alert.error', $e->getMessage());

            return redirect()->to(route('page.welcome'));
        }
    }

    /**
     * @return \Illuminate\Http\RedirectResponse|void
     */
    public function update()
    {
        if (!$this->textareaText) {
            return;
        }

        try {
            $this->taskNoteService->update($this->taskId, (int)auth()->id(), $this->textareaText);

            $this->checkText();

            $this->textareaOpened = false;
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
            $this->taskNoteService->delete($this->taskId, (int)auth()->id());

            $this->checkText();

            $this->textareaText = null;
        } catch (Throwable $e) {
            Session::flash('alert.error', $e->getMessage());

            return redirect()->to(route('page.welcome'));
        }
    }

    /**
     * @return void
     */
    public function checkText(): void
    {
        /** @var User|null $user */
        $user = auth()->user();

        if (!$user) {
            return;
        }

        $taskNote = $this->taskNoteService->findOneByTaskIdAndUserId($this->taskId, $user->id);

        if ($taskNote) {
            $this->text = $taskNote->text;
        } else {
            $this->text = null;
        }
    }

    /**
     * @return void
     */
    public function openTextarea(): void
    {
        $this->textareaOpened = true;
    }
}
