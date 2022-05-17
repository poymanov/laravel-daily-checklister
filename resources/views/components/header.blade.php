<header class="c-header c-header-light c-header-fixed c-header-with-subheader">
    <button class="c-header-toggler c-class-toggler d-lg-none mfe-auto" type="button" data-target="#sidebar" data-class="c-sidebar-show">
        <x-svg-icon path="/assets/icons/free.svg#cil-menu" class="c-icon c-icon-lg"/>
    </button>
    <a class="c-header-brand d-lg-none" href="#">
        <svg width="118" height="46" alt="CoreUI Logo">
            <use xlink:href="/assets/icons/coreui.svg#full"></use>
        </svg>
    </a>
    <button class="c-header-toggler c-class-toggler mfs-3 d-md-down-none" type="button" data-target="#sidebar" data-class="c-sidebar-lg-show" responsive="true">
        <x-svg-icon path="/assets/icons/free.svg#cil-menu" class="c-icon c-icon-lg"/>
    </button>
    <ul class="c-header-nav ml-auto mr-4">
        <li class="c-header-nav-item dropdown"><a class="c-header-nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                <div class="c-avatar">Profile</div>
            </a>
            <div class="dropdown-menu dropdown-menu-right pt-0">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <button class="dropdown-item" type="submit">
                        <x-svg-icon path="/assets/icons/free.svg#cil-account-logout" class="c-icon mr-2"/> {{ __('Log Out') }}
                    </button>
                </form>
            </div>
        </li>
    </ul>
</header>
