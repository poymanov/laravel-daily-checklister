<x-app-layout>
    <div class="mb-1">
        <h3>Top Checklists</h3>
        <x-checklist-top/>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">{{ $checklist->name }}</div>
                @role('admin')
                <div class="card-body">
                    <div class="d-flex">
                        <div class="mr-2">
                            <a href="{{ route('checklist-groups.checklists.edit', ['checklist_group' => $checklist->checklistGroupId, 'checklist' => $checklist->id]) }}" class="btn btn-sm btn-primary">Edit</a>
                        </div>
                        <div>
                            <form method="post" action="{{ route('checklist-groups.checklists.destroy', ['checklist_group' => $checklist->checklistGroupId, 'checklist' => $checklist->id]) }}" onsubmit="return confirm('Are you sure?');">
                                @csrf
                                @method('delete')
                                <button class="btn btn-sm btn-danger" type="submit">Delete</button>
                            </form>
                        </div>
                    </div>
                </div>
                @endrole
            </div>
            <div class="card">
                <div class="card-header">Tasks</div>
                <div class="card-body">
                    @role('admin')
                    <div class="mb-4">
                        <a href="{{ route('checklists.tasks.create', $checklist->id) }}" class="btn btn-sm btn-primary">Create Task</a>
                    </div>
                    @endrole

                    @if($checklist->tasks)
                        @livewire('checklist.tasks', ['checklistId' => $checklist->id])
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
