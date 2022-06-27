<x-app-layout>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">{{ $page->title }}</div>
                <div class="card-body">
                    <div class="d-flex">
                        <div class="mr-2">
                            <a href="{{ route('admin.pages.edit', $page->id) }}" class="btn btn-sm btn-primary">Edit</a>
                        </div>
                        <div>
                            <form method="post" action="{{ route('admin.pages.destroy', $page->id) }}" onsubmit="return confirm('Are you sure?');">
                                @csrf
                                @method('delete')
                                <button class="btn btn-sm btn-danger" type="submit">Delete</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    {!! $page->content !!}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
