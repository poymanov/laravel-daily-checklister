<div>
    @if ($plannedDate)
        <b>Due {{ $plannedDate->format('F d, Y') }}</b> <a wire:click.prevent="remove()" href="#">Remove</a>
    @else
        <a wire:click.prevent="openOptions()" href="">Add Due Date</a>

        @if ($showOptions)
            <ul>
                <li><a wire:click.prevent="planToday()" href="">Today</a></li>
                <li><a wire:click.prevent="planTomorrow()" href="">Tomorrow</a></li>
                <li><a wire:click.prevent="planNextWeek()" href="">Next week</a></li>
                <li><input wire:model="selectPlanDate" class="form-control" type="date" /></li>
            </ul>
        @endif
    @endif
</div>
