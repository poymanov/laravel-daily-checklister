<x-app-layout>
    <div class="card">
        <div class="card-header">Edit Checklist Group</div>
        <form action="{{ route('admin.checklist-group.update', $checklistGroup) }}" method="post">
            @csrf
            @method('put')
            <div class="card-body">
                <x-validation-errors class="mb-4" :errors="$errors"/>
                <div class="form-group mb-0">
                    <label for="name">Name</label>
                    <input class="form-control" id="name" type="text" name="name" value="{{ old('name', $checklistGroup->name) }}">
                </div>
            </div>
            <div class="card-footer">
                <button class="btn btn-sm btn-primary" type="submit">Save</button>
            </div>
        </form>
    </div>
</x-app-layout>
