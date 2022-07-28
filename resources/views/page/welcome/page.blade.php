<x-app-layout>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">{{ $page->title }}</div>
            </div>
            <div class="card page-content">
                <div class="card-body">{!! $page->content !!}</div>
            </div>
        </div>
    </div>
</x-app-layout>
