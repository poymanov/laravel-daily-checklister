@props(['status'])

@if ($status)
    <div class="alert alert-info" role="alert">{{ $status }}</div>
@endif
