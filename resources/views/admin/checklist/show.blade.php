<x-app-layout>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">{{ $checklist->name }}</div>
                <div class="card-body">
                    <div class="d-flex">
                        <div class="mr-2">
                            <a href="{{ route('admin.checklist-groups.checklists.edit', ['checklist_group' => $checklist->checklistGroupId, 'checklist' => $checklist->id]) }}" class="btn btn-sm btn-primary">Edit</a>
                        </div>
                        <div>
                            <form method="post" action="{{ route('admin.checklist-groups.checklists.destroy', ['checklist_group' => $checklist->checklistGroupId, 'checklist' => $checklist->id]) }}" onsubmit="return confirm('Are you sure?');">
                                @csrf
                                @method('delete')
                                <button class="btn btn-sm btn-danger" type="submit">Delete</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">Tasks</div>
                <div class="card-body">
                    <div>
                        <a href="{{ route('admin.checklists.tasks.create', $checklist->id) }}" class="btn btn-sm btn-primary">Create Task</a>
                    </div>

                    @if($checklist->tasks)
                        <ul class="list-group mt-4">
                            @foreach($checklist->tasks as $task)
                                <li class="list-group-item d-flex list-group-item-action justify-content-between align-items-center">{{ $task->name }}<a href="{{ route('admin.checklists.tasks.edit', ['checklist' => $checklist->id, 'task' => $task->id]) }}"><x-svg-icon path="/assets/icons/free.svg#cil-pencil" class="c-icon"/></a></li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
