<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item {{ request()->is('admin/dashboard') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.dashboard') }}">
                <i class="icon-grid menu-icon"></i>
                <span class="menu-title">{{__('global.dashboard')}}</span>
            </a>
        </li>

        @if(auth()->user()->is_admin)            

            @can('user_access')


            @endcan
            
            @can('webinar_access')
            <li class="nav-item {{ request()->is('admin/webinars') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('admin.webinars') }}">
                    <i class="icon-grid menu-icon far fa-file-video"></i>
                    <span class="menu-title"> {{ __('cruds.webinar.title') }} </span>
                </a>
            </li> 
            @endcan

            @can('blog_access')
            <li class="nav-item {{ request()->is('admin/blogs') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('admin.blogs') }}">
                    <i class="icon-grid menu-icon fab fa-blogger-b"></i>
                    <span class="menu-title"> {{ __('cruds.blog.title') }} </span>
                </a>
            </li> 
            @endcan

            @can('news_access')
            <li class="nav-item {{ request()->is('admin/news') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('admin.news') }}">
                    <i class="icon-grid menu-icon far fa-newspaper"></i>
                    <span class="menu-title"> {{ __('cruds.news.title') }} </span>
                </a>
            </li> 
            @endcan
            
            @can('transaction_access')
            {{-- <li class="nav-item {{ request()->is('admin/transactions') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('admin.transactions') }}">
                    <i class="icon-grid menu-icon fas fa-wallet"></i>
                    <span class="menu-title"> {{ __('cruds.transaction.title') }} </span>
                </a>
            </li> --}}
            @endcan


            {{-- Settings --}}
            @can('setting_access')
            <li class="nav-item {{ request()->is('admin/settings') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('admin.settings') }}">
                    <i class="menu-icon fas fa-cog"></i>
                    <span class="menu-title"> {{ __('cruds.setting.title') }} </span>
                </a>
            </li> 
            @endcan


        @endif
    </ul>
</nav>