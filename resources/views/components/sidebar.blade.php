<div class="c-sidebar c-sidebar-dark c-sidebar-fixed c-sidebar-lg-show" id="sidebar">
    <div class="c-sidebar-brand d-lg-down-none">
        <svg class="c-sidebar-brand-full" width="118" height="46">
            <use xlink:href="/assets/icons/coreui.svg#full"></use>
        </svg>
        <svg class="c-sidebar-brand-minimized" width="46" height="46">
            <use xlink:href="/assets/icons/coreui.svg#signet"></use>
        </svg>
    </div>
    <ul class="c-sidebar-nav">
        <li class="c-sidebar-nav-item">
            <a class="c-sidebar-nav-link" href="{{ route('dashboard') }}">
                <x-svg-icon path="/assets/icons/free.svg#cil-speedometer" class="c-sidebar-nav-icon"/>
                Dashboard
            </a>
        </li>
        @role('admin')
        <li class="c-sidebar-nav-title">Manage Checklists</li>
        @foreach ($checklistGroups as $checklistGroup)
            <li class="c-sidebar-nav-item c-sidebar-nav-dropdown c-show">
                <a class="c-sidebar-nav-link"
                   href="{{ route('admin.checklist-groups.edit', $checklistGroup->id) }}">
                    <x-svg-icon path="/assets/icons/free.svg#cil-folder-open" class="c-sidebar-nav-icon"/>
                    {{ $checklistGroup->name }}
                </a>
            </li>
        @endforeach
        <li class="c-sidebar-nav-item c-sidebar-nav-dropdown">
            <a class="c-sidebar-nav-link" href="{{ route('admin.checklist-groups.create') }}">
                <x-svg-icon path="/assets/icons/free.svg#cil-library-add" class="c-sidebar-nav-icon"/>
                New checklist group</a>
        </li>
        @endrole
    </ul>
    <button class="c-sidebar-minimizer c-class-toggler" type="button" data-target="_parent" data-class="c-sidebar-minimized"></button>
</div>
