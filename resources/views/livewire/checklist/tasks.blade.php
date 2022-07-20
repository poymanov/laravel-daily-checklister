<ul class="list-group">
    @foreach($tasks as $task)
        <li class="list-group-item d-flex list-group-item-action justify-content-between align-items-center d-flex">
            <div class="mr-auto">
                {{ $task->name }}
            </div>
            <div class="d-flex align-items-center">
                <div class="mr-2">
                    @if($task->order > 1)
                        <a wire:click.prevent="movePrev({{ $task->id }})" href="#">
                            <x-svg-icon path="/assets/icons/free.svg#cil-caret-top" class="c-icon"/>
                        </a>
                    @endif

                    @if($task->order < $this->tasksLastOrder)
                        <a wire:click.prevent="moveNext({{ $task->id }})" href="#">
                            <x-svg-icon path="/assets/icons/free.svg#cil-caret-bottom" class="c-icon"/>
                        </a>
                    @endif
                </div>

                @role('admin')
                <a href="{{ route('checklists.tasks.edit', ['checklist' => $checklistId, 'task' => $task->id]) }}" class="mr-1">
                    <x-svg-icon path="/assets/icons/free.svg#cil-pencil" class="c-icon"/>
                </a>

                <form method="post" action="{{ route('checklists.tasks.destroy', ['checklist' => $checklistId, 'task' => $task->id]) }}" onsubmit="return confirm('Are you sure?');">
                    @csrf
                    @method('delete')
                    <button class="btn btn-link p-0">
                        <x-svg-icon path="/assets/icons/free.svg#cil-trash" class="c-icon"/>
                    </button>
                </form>
                @endrole
            </div>
        </li>
    @endforeach
</ul>
