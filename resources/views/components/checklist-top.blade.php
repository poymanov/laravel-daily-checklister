<div class="row">
    @foreach($checklists as $checklist)
        @livewire('checklist.checklist-top-item', ['checklistId' => $checklist->id])
    @endforeach
</div>
