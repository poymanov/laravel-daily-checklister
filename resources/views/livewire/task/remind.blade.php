<div>
    @if ($savedRemindDate)
        <b>Reminder to be sent at {{ $savedRemindDate->format('F d, Y H:i') }}</b> <a wire:click.prevent="remove()" href="#">Remove</a>
    @else
        <a wire:click.prevent="openOptions()" href="">Remind me</a>

        @if ($showOptions)
            <ul>
                <li><a wire:click.prevent="remindTomorrow()" href="">Tomorrow {{ $this->remindTime }}</a></li>
                <li><a wire:click.prevent="remindNextMonday()" href="">Next Monday {{ $this->remindTime }}</a></li>
                <li>
                    Or pick a date & time
                    <input wire:model="remindDate" class="form-control" type="date"/>
                    <input wire:model="remindTime" class="form-control" type="time"/>
                    <button class="btn btn-primary" wire:click.prevent="add()">Save</button>
                </li>
            </ul>
        @endif
    @endif
</div>
