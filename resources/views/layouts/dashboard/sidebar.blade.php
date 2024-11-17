<style>

    .menu-vertical .menu-sub .menu-link{
        padding-left: 3rem !important;
    }
</style>
<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="{{ route('dashboard') }}" class="app-brand-link d-flex align-items-center gap-2">
            <i class="fa-solid fa-house fa-2xl" style=""></i>
            {{-- <img src="{{ asset('asset/img/favicon/favicon.ico') }}" style="width: 50px" alt=""> --}}
            <span class="app-brand-text demo menu-text fw-bolder ms-2">{{ __('home.Dashboard') }}</span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1 pt-5">
        <!-- Dashboard -->
        <li class="menu-item {{ isActiveRoute(['dashboard']) }}">
            <a href="{{ route('dashboard') }}" class="menu-link d-flex align-items-center gap-2">
                <i class="fa-solid fa-house"></i>
                <div data-i18n="Analytics">{{ __('home.Dashboard') }}</div>
            </a>
        </li>


        <li class="menu-item {{ isActiveRoute(['assam']) }}">
            <a href="{{ route('assam') }}" class="menu-link d-flex align-items-center gap-2">
                <i class="fa-solid fa-globe"></i>
                <div data-i18n="Analytics">{{ __('assam') }}</div>
            </a>
        </li>

        <li class="menu-item {{ isActiveRoute(['arunachal_pradesh']) }}">
            <a href="{{ route('arunachal_pradesh') }}" class="menu-link d-flex align-items-center gap-2">
                <i class="fa-solid fa-globe"></i>
                <div data-i18n="Analytics">{{ __('arunachal pradesh') }}</div>
            </a>
        </li>

    </ul>
</aside>
