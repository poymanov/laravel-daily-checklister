<div>
    <a class="c-sidebar-nav-link" style="padding: .5rem .5rem .5rem 76px"
       href="{{ route('checklist-groups.checklists.show', [$checklistGroupId, $checklistId]) }}">
        <x-svg-icon path="/assets/icons/free.svg#cil-list" class="c-sidebar-nav-icon"/>
        {{ $checklistName }}

        <span class="badge badge-info">{{ $completedTasks }}/{{ $totalTasks }}</span>
    </a>
</div>
