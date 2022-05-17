<div class="c-subheader px-3">
    <ol class="breadcrumb border-0 m-0">
        @foreach($breadcrumbs as $breadcrumb)
            <li class="breadcrumb-item {{ $breadcrumb['active'] ? 'active' : '' }}">{{ $breadcrumb['name'] }}</li>
        @endforeach
    </ol>
</div>
