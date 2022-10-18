<div>
    @if($textareaOpened)
        <textarea wire:model="textareaText" name="textareaText" class="form-control mb-2" cols="30" rows="5"></textarea>
        <button wire:click.prevent="@if($text) update() @else add() @endif" href="#" class="btn btn-primary">Save Note</button>
    @elseif($text)
        <div>
            {{ $text }}
        </div>

        <a wire:click.prevent="openTextarea()" href="#">Edit Note</a>
        <a wire:click.prevent="remove()" href="#">Remove Note</a>
    @else
        <a wire:click.prevent="openTextarea()" href="#">Add Note</a>
    @endif
</div>
