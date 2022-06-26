<x-app-layout>
    <div class="card">
        <div class="card-header">Edit Page</div>
        <form action="{{ route('admin.pages.update', $page->id) }}" method="post">
            @csrf
            @method('put')
            <div class="card-body">
                <x-validation-errors class="mb-4" :errors="$errors"/>
                <div class="form-group mb-2">
                    <label for="title">Title</label>
                    <input class="form-control" id="title" type="text" name="title" value="{{ old('title', $page->title) }}">
                </div>
                <div class="form-group mb-0">
                    <label for="page-content">Content</label>
                    <textarea class="form-control" id="page-content" name="content">{{ old('content', $page->content) }}</textarea>
                </div>
            </div>
            <div class="card-footer">
                <button class="btn btn-sm btn-primary" type="submit">Save</button>
            </div>
        </form>
    </div>
</x-app-layout>
