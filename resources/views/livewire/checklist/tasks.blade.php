<ul class="list-group">
    @foreach($tasks as $task)
        <li class="list-group-item list-group-item-action" :wire:key="$task->id">
            <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <label class="c-switch c-switch-primary mr-2">
                        @if($task->completed)
                            <input class="c-switch-input" wire:click.prevent="incomplete({{$task->id }})" type="checkbox" checked=""><span class="c-switch-slider"></span>
                        @else
                            <input class="c-switch-input" wire:click.prevent="complete({{$task->id }})" type="checkbox"><span class="c-switch-slider"></span>
                        @endif
                    </label>

                    <span wire:click.prevent="toggle({{$task->id }})">{{ $task->name }}</span>
                </div>
                @role('admin')
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
                </div>
                @endrole
            </div>
            <div class="@if (in_array($task->id, $openedTasks)) d-block @else d-none @endif">
                <hr>
                <div class="task-content">
                    {!! $task->description !!}
                </div>
            </div>
            <div class="task-controls mb-2 d-flex">
                <div class="mr-2">
                    @livewire('task.day', ['taskId' => $task->id], key($task->id . rand()))
                </div>
                <div class="mr-2">
                    @livewire('task.important', ['taskId' => $task->id], key($task->id . rand()))
                </div>
            </div>
            <div class="task-controls mb-2 d-flex">
                @livewire('task.plan', ['taskId' => $task->id], key($task->id . rand()))
            </div>
            <div class="task-controls mb-2 d-flex">
                @livewire('task.note', ['taskId' => $task->id], key($task->id . rand()))
            </div>
            <div class="task-controls d-flex">
                @livewire('task.remind', ['taskId' => $task->id], key($task->id . rand()))
            </div>
        </li>
    @endforeach
</ul>

@unlessrole('admin')
@if($totalTasks > $maxTasksWithoutSubscription && !$userHasSubscription)
    <div class="text-center mt-3">
        <h2 class="mb-2">Want to see all tasks?</h2>

        <a class="btn btn-lg btn-success btn-block" href="{{ route('subscription.index') }}">Subscribe</a>
    </div>
@endif
@endunlessrole
