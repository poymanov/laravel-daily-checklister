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
                    <a href="{{ route('admin.checklists.tasks.create', $checklist->id) }}" class="btn btn-sm btn-primary">Create Task</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
