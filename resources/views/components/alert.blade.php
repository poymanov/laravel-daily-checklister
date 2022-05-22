<div {!! $attributes !!}>
    @if ($status === 'success')
        <div class="alert alert-success" role="alert">{{ $message }}</div>
    @elseif ($status === 'error')
        <div class="alert alert-danger" role="alert">{{ $message }}</div>
    @endif
</div>
