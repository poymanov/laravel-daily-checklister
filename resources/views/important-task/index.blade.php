<x-app-layout>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">Important</div>
            </div>

            @if($importantTasks)
                <div class="card">
                    <ul class="list-group">
                        @foreach($importantTasks as $importantTask)
                            <li class="list-group-item list-group-item-action">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        {{ $importantTask->task->name }} (<a href="{{ route('checklist-groups.checklists.show', ['checklist_group' => $importantTask->checklist->checklistGroupId, 'checklist' => $importantTask->checklist->id]) }}">{{ $importantTask->checklist->name }}</a>)
                                    </div>
                                    <div>
                                        <form method="post" action="{{ route('tasks.important.destroy', $importantTask->task->id) }}" onsubmit="return confirm('Are you sure?');">
                                            @csrf
                                            @method('delete')
                                            <button class="btn btn-link p-0">
                                                <x-svg-icon path="/assets/icons/free.svg#cil-trash" class="c-icon"/>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
