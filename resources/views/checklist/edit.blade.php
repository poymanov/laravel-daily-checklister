<x-app-layout>
    <div class="card">
        <div class="card-header">Edit Checklist</div>
        <form action="{{ route('checklist-groups.checklists.update', ['checklist_group' => $checklistGroup, 'checklist' => $checklist]) }}" method="post">
            @csrf
            @method('put')
            <div class="card-body">
                <x-validation-errors class="mb-4" :errors="$errors"/>
                <div class="form-group mb-2">
                    <label for="name">Name</label>
                    <input class="form-control" id="name" type="text" name="name" value="{{ old('name', $checklist->name) }}">
                </div>
                <div class="form-group mb-0">
                    <input id="is_top" type="checkbox" name="is_top" @if (old('is_top', $checklist->is_top)) checked @endif>
                    <label for="is_top">Is Top?</label>
                </div>
            </div>
            <div class="card-footer">
                <button class="btn btn-sm btn-primary" type="submit">Save</button>
            </div>
        </form>
    </div>
</x-app-layout>
