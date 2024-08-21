<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <div class="user-profile-box">
        <div class="profile-img refresh-profile-image">
            <img class="img-fluid" src="{{ isset(auth()->user()->profile_image_url) && !empty(auth()->user()->profile_image_url) ? auth()->user()->profile_image_url : asset(config('constants.default.profile_image')) }}" alt="">
        </div>
        <div class="title-profile">
            <h2>
               @lang('messages.welcome_back')
            </h2>
            <p class="auth-user-name">
                {{ auth()->user()->name }}
            </p>
        </div>
    </div>
    <ul class="nav">
        <li class="nav-item {{ request()->is('dashboard') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.dashboard') }}">
                <x-svg-icon icon="dashboard" />
                <span class="menu-title">{{__('global.dashboard')}}</span>
            </a>
        </li>

        @can('webinar_access')
        <li class="nav-item {{ request()->is('webinars') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.webinars') }}">
                <x-svg-icon icon="webinar" />
                <span class="menu-title"> {{ __('cruds.webinar.title') }} </span>
            </a>
        </li>
        @endcan

        @can('seminar_access')
        <li class="nav-item {{ request()->is('seminars') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.seminars') }}">
                <x-svg-icon icon="seminar" />
                <span class="menu-title"> {{ __('cruds.seminar.title') }} </span>
            </a>
        </li>
        @endcan

        @can('news_access')
        <li class="nav-item {{ request()->is('news') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.news') }}">
                <x-svg-icon icon="news" />
                <span class="menu-title"> {{ __('cruds.news.title') }} </span>
            </a>
        </li>
        @endcan

        @can('health_access')
        <li class="nav-item {{ request()->is('health') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.health') }}">
                <x-svg-icon icon="health" />
                <span class="menu-title"> {{ __('cruds.health.title') }} </span>
            </a>
        </li>
        @endcan

        @can('quote_access')
        <li class="nav-item {{ request()->is('quotes') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.quotes') }}">
                <x-svg-icon icon="quote" />
                <span class="menu-title"> {{ __('cruds.quote.title') }} </span>
            </a>
        </li>
        @endcan

        @can('contact_access')
        <li class="nav-item {{ request()->is('contacts') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.contacts') }}">
                <x-svg-icon icon="contact" />
                <span class="menu-title"> {{ __('cruds.contacts.title') }} {{ __('global.list') }}</span>
            </a>
        </li>
        @endcan

        @can('user_access')
        <li class="nav-item {{ request()->is('users') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.users') }}">
                <x-svg-icon icon="user" />
                <span class="menu-title"> {{ __('cruds.user.title') }} </span>
            </a>
        </li>
        @endcan

        @can('volunteer_access')    
        <li class="nav-item {{ request()->is('volunteers') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.volunteers') }}">
                <x-svg-icon icon="user" />
                <span class="menu-title"> {{ __('cruds.volunteer.list') }} </span>
            </a>
        </li>
        @endcan

        @can('page_access')
        <li class="nav-item {{ request()->is('page-manage*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.page-manage') }}">
                <x-svg-icon icon="page" />
                <span class="menu-title"> {{ __('cruds.pages.title') }} </span>
            </a>
        </li>
        @endcan

        @can('transaction_access')
        {{-- <li class="nav-item {{ request()->is('transactions') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.transactions') }}">
            <x-svg-icon icon="transaction" />
            <span class="menu-title"> {{ __('cruds.transaction.title') }} </span>
        </a>
        </li> --}}
        @endcan

        @can('mis_report_access')
        <li class="nav-item {{ request()->is('misreport') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.mis-report') }}">
                <x-svg-icon icon="mis_report" />
                <span class="menu-title"> {{ __('cruds.mis_reports.title_singular') }} </span>
            </a>
        </li>
        @endcan
        
        {{-- Settings --}}
        @can('setting_access')
        <li class="nav-item {{ request()->is('settings') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.settings') }}">
            <x-svg-icon icon="setting" />
            <span class="menu-title"> {{ __('cruds.setting.title') }} </span>
        </a>
        </li>
        @endcan

        @livewire('auth.admin.logout',['type'=>'sidebar'])

       
    </ul>
</nav>