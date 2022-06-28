<x-app-layout>
    <div class="card">
        <div class="card-header">New Page</div>
        <form action="{{ route('admin.pages.store') }}" method="post">
            @csrf
            <div class="card-body">
                <x-validation-errors class="mb-4" :errors="$errors"/>
                @csrf
                <div class="form-group mb-2">
                    <label for="title">Title</label>
                    <input class="form-control" id="title" type="text" name="title" value="{{ old('title') }}">
                </div>
                <div class="form-group mb-2">
                    <label for="type">Type</label>
                    <select class="form-control" name="type" id="type">
                        <option></option>
                        @foreach($pagesList as $id => $page)
                            <option value="{{ $id }}">{{ $page }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group mb-0">
                    <label for="page-content">Content</label>
                    <textarea class="form-control" id="page-content" name="content">{{ old('content') }}</textarea>
                </div>
            </div>
            <div class="card-footer">
                <button class="btn btn-sm btn-primary" type="submit">Save</button>
            </div>
        </form>
    </div>
</x-app-layout>
