<div>
    @if ($isAdded)
        <a wire:click.prevent="remove()" href="#">Remove from my day</a>
    @else
        <a wire:click.prevent="add()" href="#">Add to my day</a>
    @endif
</div>
