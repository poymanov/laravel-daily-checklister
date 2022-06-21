<x-app-layout>
    <div class="card">
        <div class="card-header">New Task in {{ $checklist->name }}</div>
        <form action="{{ route('admin.checklists.tasks.store', $checklist->id) }}" method="post">
            <div class="card-body">
                <x-validation-errors class="mb-4" :errors="$errors"/>
                @csrf
                <div class="form-group mb-2">
                    <label for="name">Name</label>
                    <input class="form-control" id="name" type="text" name="name" value="{{ old('name') }}">
                </div>
                <div class="form-group mb-0">
                    <label for="task-description">Description</label>
                    <textarea class="form-control" id="task-description" type="text" name="description">{{ old('description') }}</textarea>
                </div>
            </div>
            <div class="card-footer">
                <button class="btn btn-sm btn-primary" type="submit">Save</button>
            </div>
        </form>
    </div>
</x-app-layout>
