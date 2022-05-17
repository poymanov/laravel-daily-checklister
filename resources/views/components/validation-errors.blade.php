@props(['errors'])

@if ($errors->any())
    <div {{ $attributes }}>
        <ul class="pl-0">
            @foreach ($errors->all() as $error)
                <div class="alert alert-danger" role="alert">{{ $error }}</div>
            @endforeach
        </ul>
    </div>
@endif
