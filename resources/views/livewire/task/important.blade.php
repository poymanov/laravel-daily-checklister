<div>
    @if ($isAdded)
        <a wire:click.prevent="remove()" href="#">Remove from important</a>
    @else
        <a wire:click.prevent="add()" href="#">Add to important</a>
    @endif
</div>
