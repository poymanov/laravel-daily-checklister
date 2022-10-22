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
            <a class="c-sidebar-nav-link" href="{{ route('page.welcome') }}">
                <x-svg-icon path="/assets/icons/free.svg#cil-speedometer" class="c-sidebar-nav-icon"/>
                Home
            </a>
        </li>
        @unlessrole('admin')
        <li class="c-sidebar-nav-item">
            <a class="c-sidebar-nav-link" href="{{ route('subscription.index') }}">
                <x-svg-icon path="/assets/icons/free.svg#cil-money" class="c-sidebar-nav-icon"/>
                Subscription
            </a>
        </li>
        @endunlessrole
        <li class="c-sidebar-nav-item">
            @livewire('task.day-menu-item')
        </li>
        <li class="c-sidebar-nav-item">
            @livewire('task.important-menu-item')
        </li>
        <li class="c-sidebar-nav-item">
            @livewire('task.plan-menu-item')
        </li>
        @role('admin')
        <li class="c-sidebar-nav-title">Manage Checklists</li>
        @endrole
        @foreach ($checklistGroups as $checklistGroup)
            <li class="c-sidebar-nav-item c-sidebar-nav-dropdown c-show">

                @role('admin')
                <a class="c-sidebar-nav-link" href="{{ route('checklist-groups.edit', $checklistGroup->id) }}">
                    <x-svg-icon path="/assets/icons/free.svg#cil-folder-open" class="c-sidebar-nav-icon"/>
                    {{ $checklistGroup->name }}
                </a>
                @else
                    @if(!empty($checklistGroup->checklists))
                        <a class="c-sidebar-nav-link" href="#">
                            <x-svg-icon path="/assets/icons/free.svg#cil-folder-open" class="c-sidebar-nav-icon"/>
                            {{ $checklistGroup->name }}
                        </a>
                    @endif
                    @endrole

                    <ul class="c-sidebar-nav-dropdown-items">
                        @foreach ($checklistGroup->checklists as $checklist)
                            <li class="c-sidebar-nav-item">
                                @livewire('checklist.checklist-menu-item', ['checklistGroupId' => $checklistGroup->id, 'checklistId' => $checklist->id, 'checklistName' => $checklist->name])
                            </li>
                        @endforeach
                        @role('admin')
                        <li class="c-sidebar-nav-item">
                            <a class="c-sidebar-nav-link" style="padding: 1rem .5rem .5rem 76px"
                               href="{{ route('checklist-groups.checklists.create', $checklistGroup->id) }}">
                                <x-svg-icon path="/assets/icons/free.svg#cil-note-add" class="c-sidebar-nav-icon"/>
                                Add checklist</a>
                        </li>
                        @endrole
                    </ul>
            </li>
        @endforeach
        @role('admin')
        <li class="c-sidebar-nav-item c-sidebar-nav-dropdown">
            <a class="c-sidebar-nav-link" href="{{ route('checklist-groups.create') }}">
                <x-svg-icon path="/assets/icons/free.svg#cil-library-add" class="c-sidebar-nav-icon"/>
                New checklist group</a>
        </li>
        @endrole
        @role('admin')
        <li class="c-sidebar-nav-title">Manage Pages</li>
        <li class="c-sidebar-nav-item c-sidebar-nav-dropdown c-show">
            <ul class="c-sidebar-nav-dropdown-items">
                @foreach ($pages as $page)
                    <li class="c-sidebar-nav-item">
                        <a class="c-sidebar-nav-link" style="padding: .5rem .5rem .5rem 76px"
                           href="{{ route('admin.pages.show', $page->id) }}">
                            <x-svg-icon path="/assets/icons/free.svg#cil-folder-open" class="c-sidebar-nav-icon"/>
                            {{ $page->title }}</a>
                    </li>
                @endforeach
            </ul>
        </li>
        <li class="c-sidebar-nav-item c-sidebar-nav-dropdown">
            <a class="c-sidebar-nav-link" href="{{ route('admin.pages.create') }}">
                <x-svg-icon path="/assets/icons/free.svg#cil-library-add" class="c-sidebar-nav-icon"/>
                New page</a>
        </li>
        <li class="c-sidebar-nav-title">Manage Users</li>
        <li class="c-sidebar-nav-item c-sidebar-nav-dropdown c-show">
            <a class="c-sidebar-nav-link" href="{{ route('admin.users.index') }}">
                <x-svg-icon path="/assets/icons/free.svg#cil-folder-open" class="c-sidebar-nav-icon"/>
                Users List
            </a>
        </li>
        @endrole
    </ul>
    <button class="c-sidebar-minimizer c-class-toggler" type="button" data-target="_parent" data-class="c-sidebar-minimized"></button>
</div>
