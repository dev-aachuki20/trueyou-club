<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <div class="user-profile-box">
        <div class="profile-img refresh-profile-image">
            <img class="img-fluid" src="{{ isset(auth()->user()->profile_image_url) && !empty(auth()->user()->profile_image_url) ? auth()->user()->profile_image_url : asset(config('constants.default.profile_image')) }}" alt="">
        </div>
        <div class="title-profile">
            <h2>
                Welcome Back!
            </h2>
            <p class="auth-user-name">
                {{ auth()->user()->name }}
            </p>
        </div>
        {{-- <div class="vip-box">
            <svg width="16" height="12" viewBox="0 0 16 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M12.3498 11.1449C12.3498 11.6172 11.9678 12.01 11.486 12.01H3.54835C3.07138 12.01 2.68457 11.6232 2.68457 11.1449C2.68457 10.676 3.0647 10.2811 3.54835 10.2811H11.486C11.963 10.2811 12.3498 10.668 12.3498 11.1449Z" fill="url(#paint0_linear_277_9430)" />
                <path d="M13.2887 4.91434L13.1192 5.36215L11.4398 9.80052L11.2575 10.2803H3.77542L3.59311 9.80052L1.91369 5.36219L1.74414 4.91437C1.99685 4.81838 2.21116 4.64567 2.35831 4.42492C2.50546 4.5001 2.65261 4.56568 2.79976 4.62485C4.33519 5.21824 5.86422 4.7816 6.87026 2.93267C6.94544 2.79674 7.01579 2.65279 7.08457 2.50085C7.22054 2.54885 7.36607 2.57441 7.51642 2.57441C7.66836 2.57441 7.81551 2.54885 7.94986 2.50085C8.01864 2.65279 8.08899 2.79677 8.16417 2.93267C9.17183 4.78322 10.6992 5.21824 12.2347 4.62485C12.3818 4.56568 12.529 4.5001 12.6761 4.42492C12.8233 4.64563 13.036 4.81676 13.2887 4.91434Z" fill="url(#paint1_linear_277_9430)" />
                <path d="M8.80514 1.28719C8.80514 1.99809 8.22888 2.57568 7.51668 2.57568C6.80579 2.57568 6.22949 1.99809 6.22949 1.28719C6.22949 0.576296 6.80579 0 7.51668 0C8.22888 3.51615e-05 8.80514 0.576296 8.80514 1.28719Z" fill="url(#paint2_linear_277_9430)" />
                <path d="M2.57565 3.70939C2.57565 4.42029 1.99935 4.99789 1.28719 4.99789C0.576297 4.99789 0 4.42029 0 3.70939C0 2.9985 0.576297 2.4222 1.28719 2.4222C1.99939 2.4222 2.57565 2.9985 2.57565 3.70939Z" fill="url(#paint3_linear_277_9430)" />
                <path d="M15.0346 3.70939C15.0346 4.42029 14.4584 4.99789 13.7462 4.99789C13.0353 4.99789 12.459 4.42029 12.459 3.70939C12.459 2.9985 13.0353 2.4222 13.7462 2.4222C14.4584 2.4222 15.0346 2.9985 15.0346 3.70939Z" fill="url(#paint4_linear_277_9430)" />
                <path d="M8.73414 7.20297C8.73414 8.17543 8.18875 8.96392 7.51699 8.96392C6.84523 8.96392 6.2998 8.17543 6.2998 7.20297C6.2998 6.23054 6.84519 5.44201 7.51699 5.44201C8.18875 5.44201 8.73414 6.23054 8.73414 7.20297Z" fill="url(#paint5_linear_277_9430)" />
                <defs>
                    <linearGradient id="paint0_linear_277_9430" x1="7.5172" y1="12.01" x2="7.5172" y2="10.2811" gradientUnits="userSpaceOnUse">
                        <stop stop-color="#F9403E" />
                        <stop offset="1" stop-color="#F77953" />
                    </linearGradient>
                    <linearGradient id="paint1_linear_277_9430" x1="7.51646" y1="10.2804" x2="7.51646" y2="2.50082" gradientUnits="userSpaceOnUse">
                        <stop stop-color="#F79808" />
                        <stop offset="1" stop-color="#EDBB0B" />
                    </linearGradient>
                    <linearGradient id="paint2_linear_277_9430" x1="7.51732" y1="2.57568" x2="7.51732" y2="3.53097e-05" gradientUnits="userSpaceOnUse">
                        <stop stop-color="#F79808" />
                        <stop offset="1" stop-color="#EDBB0B" />
                    </linearGradient>
                    <linearGradient id="paint3_linear_277_9430" x1="1.28782" y1="4.99789" x2="1.28782" y2="2.4222" gradientUnits="userSpaceOnUse">
                        <stop stop-color="#F79808" />
                        <stop offset="1" stop-color="#EDBB0B" />
                    </linearGradient>
                    <linearGradient id="paint4_linear_277_9430" x1="13.7468" y1="4.99789" x2="13.7468" y2="2.4222" gradientUnits="userSpaceOnUse">
                        <stop stop-color="#F79808" />
                        <stop offset="1" stop-color="#EDBB0B" />
                    </linearGradient>
                    <linearGradient id="paint5_linear_277_9430" x1="7.51699" y1="8.96392" x2="7.51699" y2="5.44201" gradientUnits="userSpaceOnUse">
                        <stop offset="0.0168" stop-color="#CCCCCC" />
                        <stop offset="1" stop-color="#F2F2F2" />
                    </linearGradient>
                </defs>
            </svg>
            VIP
        </div> --}}
    </div>
    <ul class="nav">
        <li class="nav-item {{ request()->is('admin/dashboard') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.dashboard') }}">
                <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <g clip-path="url(#clip0_527_1881)">
                        <path d="M14.25 7.5625H12.75C11.9316 7.5625 11.3723 7.33895 11.0167 6.98332C10.661 6.62769 10.4375 6.06842 10.4375 5.25V3.75C10.4375 2.93158 10.661 2.37231 11.0167 2.01668C11.3723 1.66105 11.9316 1.4375 12.75 1.4375H14.25C15.0684 1.4375 15.6277 1.66105 15.9833 2.01668C16.339 2.37231 16.5625 2.93158 16.5625 3.75V5.25C16.5625 6.06842 16.339 6.62769 15.9833 6.98332C15.6277 7.33895 15.0684 7.5625 14.25 7.5625ZM12.75 1.5625C12.101 1.5625 11.5186 1.69803 11.1083 2.10832C10.698 2.51861 10.5625 3.10103 10.5625 3.75V5.25C10.5625 5.89897 10.698 6.48139 11.1083 6.89168C11.5186 7.30197 12.101 7.4375 12.75 7.4375H14.25C14.899 7.4375 15.4814 7.30197 15.8917 6.89168C16.302 6.48139 16.4375 5.89897 16.4375 5.25V3.75C16.4375 3.10103 16.302 2.51861 15.8917 2.10832C15.4814 1.69803 14.899 1.5625 14.25 1.5625H12.75Z" fill="#0A2540" stroke="#0A2540" />
                        <path d="M5.25 16.5625H3.75C2.93158 16.5625 2.37231 16.339 2.01668 15.9833C1.66105 15.6277 1.4375 15.0684 1.4375 14.25V12.75C1.4375 11.9316 1.66105 11.3723 2.01668 11.0167C2.37231 10.661 2.93158 10.4375 3.75 10.4375H5.25C6.06842 10.4375 6.62769 10.661 6.98332 11.0167C7.33895 11.3723 7.5625 11.9316 7.5625 12.75V14.25C7.5625 15.0684 7.33895 15.6277 6.98332 15.9833C6.62769 16.339 6.06842 16.5625 5.25 16.5625ZM3.75 10.5625C3.10103 10.5625 2.51861 10.698 2.10832 11.1083C1.69803 11.5186 1.5625 12.101 1.5625 12.75V14.25C1.5625 14.899 1.69803 15.4814 2.10832 15.8917C2.51861 16.302 3.10103 16.4375 3.75 16.4375H5.25C5.89897 16.4375 6.48139 16.302 6.89168 15.8917C7.30197 15.4814 7.4375 14.899 7.4375 14.25V12.75C7.4375 12.101 7.30197 11.5186 6.89168 11.1083C6.48139 10.698 5.89897 10.5625 5.25 10.5625H3.75Z" stroke="#0A2540" />
                        <path d="M4.5 7.5625C2.81114 7.5625 1.4375 6.18886 1.4375 4.5C1.4375 2.81114 2.81114 1.4375 4.5 1.4375C6.18886 1.4375 7.5625 2.81114 7.5625 4.5C7.5625 6.18886 6.18886 7.5625 4.5 7.5625ZM4.5 1.5625C2.88136 1.5625 1.5625 2.88136 1.5625 4.5C1.5625 6.11864 2.88136 7.4375 4.5 7.4375C6.11864 7.4375 7.4375 6.11864 7.4375 4.5C7.4375 2.88136 6.11864 1.5625 4.5 1.5625Z" stroke="#0A2540" />
                        <path d="M13.5 16.5625C11.8111 16.5625 10.4375 15.1889 10.4375 13.5C10.4375 11.8111 11.8111 10.4375 13.5 10.4375C15.1889 10.4375 16.5625 11.8111 16.5625 13.5C16.5625 15.1889 15.1889 16.5625 13.5 16.5625ZM13.5 10.5625C11.8814 10.5625 10.5625 11.8814 10.5625 13.5C10.5625 15.1186 11.8814 16.4375 13.5 16.4375C15.1186 16.4375 16.4375 15.1186 16.4375 13.5C16.4375 11.8814 15.1186 10.5625 13.5 10.5625Z" stroke="#0A2540" />
                    </g>
                    <defs>
                        <clipPath id="clip0_527_1881">
                            <rect width="18" height="18" fill="white" />
                        </clipPath>
                    </defs>
                </svg>
                <span class="menu-title">{{__('global.dashboard')}}</span>
            </a>
        </li>

        @if(auth()->user()->is_admin)

        @can('user_access')


        @endcan

        @can('webinar_access')
        <li class="nav-item {{ request()->is('admin/webinars') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.webinars') }}">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M22 11.89V12.78C22 16.34 21.11 17.22 17.56 17.22H6.44C2.89 17.22 2 16.33 2 12.78V6.44C2 2.89 2.89 2 6.44 2H8" stroke="#0A2540" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M12 17.22V22" stroke="#0A2540" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M2 13H22" stroke="#0A2540" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M7.5 22H16.5" stroke="#0A2540" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M17.86 9.37001H13.1C11.72 9.37001 11.26 8.45001 11.26 7.53001V4.01001C11.26 2.91001 12.16 2.01001 13.26 2.01001H17.86C18.88 2.01001 19.7 2.83001 19.7 3.85001V7.53001C19.7 8.55001 18.88 9.37001 17.86 9.37001Z" stroke="#0A2540" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M20.91 7.91998L19.7 7.06998V4.30998L20.91 3.45998C21.51 3.04998 22 3.29998 22 4.02998V7.35998C22 8.08998 21.51 8.33998 20.91 7.91998Z" stroke="#0A2540" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                <span class="menu-title"> {{ __('cruds.webinar.title') }} </span>
            </a>
        </li>
        @endcan

        @can('seminar_access')
        <li class="nav-item {{ request()->is('admin/seminars') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.seminars') }}">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M17.01 12.7301C17.601 12.7301 18.08 12.251 18.08 11.6601C18.08 11.0691 17.601 10.5901 17.01 10.5901C16.4191 10.5901 15.94 11.0691 15.94 11.6601C15.94 12.251 16.4191 12.7301 17.01 12.7301Z" stroke="#0A2540" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M20 6V7.78998C19.75 7.75998 19.46 7.73999 19.15 7.73999H14.87C12.73 7.73999 12.02 8.45003 12.02 10.59V15.7H6C2.8 15.7 2 14.9 2 11.7V6C2 2.8 2.8 2 6 2H16C19.2 2 20 2.8 20 6Z" stroke="#0A2540" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M9 15.7V20" stroke="#0A2540" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M2 11.8999H12" stroke="#0A2540" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M5.95001 20H12" stroke="#0A2540" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M17.01 12.7301C17.601 12.7301 18.08 12.251 18.08 11.6601C18.08 11.0691 17.601 10.5901 17.01 10.5901C16.4191 10.5901 15.94 11.0691 15.94 11.6601C15.94 12.251 16.4191 12.7301 17.01 12.7301Z" stroke="#0A2540" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M20 7.78998C19.75 7.75998 19.46 7.73999 19.15 7.73999H14.87C12.73 7.73999 12.02 8.45003 12.02 10.59V19.15C12.02 21.29 12.73 22 14.87 22H19.15C21.29 22 22 21.29 22 19.15V10.59C22 8.76003 21.48 7.97998 20 7.78998ZM17.01 10.59C17.6 10.59 18.08 11.07 18.08 11.66C18.08 12.25 17.6 12.73 17.01 12.73C16.42 12.73 15.94 12.25 15.94 11.66C15.94 11.07 16.42 10.59 17.01 10.59ZM17.01 19.15C15.83 19.15 14.87 18.19 14.87 17.01C14.87 16.52 15.04 16.06 15.32 15.7C15.71 15.2 16.32 14.87 17.01 14.87C17.55 14.87 18.04 15.07 18.41 15.39C18.86 15.79 19.15 16.37 19.15 17.01C19.15 18.19 18.19 19.15 17.01 19.15Z" stroke="#0A2540" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M19.15 17.0101C19.15 18.1901 18.19 19.1501 17.01 19.1501C15.83 19.1501 14.87 18.1901 14.87 17.0101C14.87 16.5201 15.04 16.0601 15.32 15.7001C15.71 15.2001 16.32 14.8701 17.01 14.8701C17.55 14.8701 18.04 15.0701 18.41 15.3901C18.86 15.7901 19.15 16.3701 19.15 17.0101Z" stroke="#0A2540" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M17.01 12.7301C17.601 12.7301 18.08 12.251 18.08 11.6601C18.08 11.0691 17.601 10.5901 17.01 10.5901C16.4191 10.5901 15.94 11.0691 15.94 11.6601C15.94 12.251 16.4191 12.7301 17.01 12.7301Z" stroke="#0A2540" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                <span class="menu-title"> {{ __('cruds.seminar.title') }} </span>
            </a>
        </li>
        @endcan

        @can('blog_access')
        {{-- <li class="nav-item {{ request()->is('admin/blogs') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.blogs') }}">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M7.25997 2H16.73C17.38 2 17.96 2.02003 18.48 2.09003C21.25 2.40003 22 3.70001 22 7.26001V13.58C22 17.14 21.25 18.44 18.48 18.75C17.96 18.82 17.39 18.84 16.73 18.84H7.25997C6.60997 18.84 6.02997 18.82 5.50997 18.75C2.73997 18.44 1.98999 17.14 1.98999 13.58V7.26001C1.98999 3.70001 2.73997 2.40003 5.50997 2.09003C6.02997 2.02003 6.60997 2 7.25997 2Z" stroke="#0A2540" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M13.58 8.32007H17.26" stroke="#0A2540" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M6.73999 14.1101H6.75997H17.27" stroke="#0A2540" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M7 22H17" stroke="#0A2540" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M7.1947 8.30005H7.20368" stroke="#0A2540" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M10.4945 8.30005H10.5035" stroke="#0A2540" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                <span class="menu-title"> {{ __('cruds.blog.title') }} </span>
            </a>
        </li> --}}
        @endcan

        @can('news_access')
        <li class="nav-item {{ request()->is('admin/news') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.news') }}">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M7.5 4H16.5C17.12 4 17.67 4.02 18.16 4.09C20.79 4.38 21.5 5.62 21.5 9V15C21.5 18.38 20.79 19.62 18.16 19.91C17.67 19.98 17.12 20 16.5 20H7.5C6.88 20 6.33 19.98 5.84 19.91C3.21 19.62 2.5 18.38 2.5 15V9C2.5 5.62 3.21 4.38 5.84 4.09C6.33 4.02 6.88 4 7.5 4Z" stroke="#0A2540" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M13 9H17" stroke="#0A2540" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M13 12.5H13.02H17" stroke="#0A2540" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M7 16H7.02H17" stroke="#0A2540" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M8 8.5H10C10.2761 8.5 10.5 8.72386 10.5 9V12.5C10.5 12.7761 10.2761 13 10 13H8C7.72386 13 7.5 12.7761 7.5 12.5V9C7.5 8.72386 7.72386 8.5 8 8.5Z" stroke="#0A2540" />
                </svg>
                <span class="menu-title"> {{ __('cruds.news.title') }} </span>
            </a>
        </li>
        @endcan

        @can('health_access')
        <li class="nav-item {{ request()->is('admin/health') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.health') }}">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M8.96997 22H14.97C19.97 22 21.97 20 21.97 15V9C21.97 4 19.97 2 14.97 2H8.96997C3.96997 2 1.96997 4 1.96997 9V15C1.96997 20 3.96997 22 8.96997 22Z" stroke="#0A2540" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M1.96997 12.7001H3.99997M9.31947 12.7001C10.0695 12.7001 11.5 12.9401 11.84 13.9501L12.98 16.8301C13.24 17.4801 13.65 17.4801 13.91 16.8301L16.2 11.0201C16.42 10.4601 16.83 10.4401 17.11 10.9701L18.15 12.9401C18.46 13.5301 19.26 14.0101 19.92 14.0101H21.98" stroke="#0A2540" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M6.655 14.9747C6.57 15.0084 6.43 15.0084 6.345 14.9747C5.62 14.6966 4 13.5365 4 11.5702C4 10.7022 4.6225 10 5.39 10C5.845 10 6.2475 10.2472 6.5 10.6292C6.7525 10.2472 7.1575 10 7.61 10C8.3775 10 9 10.7022 9 11.5702C9 13.5365 7.38 14.6966 6.655 14.9747Z" stroke="#0A2540" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                <span class="menu-title"> {{ __('cruds.health.title') }} </span>
            </a>
        </li>
        @endcan

        @can('quote_access')
        <li class="nav-item {{ request()->is('admin/quotes') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.quotes') }}">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M9 22H15C20 22 22 20 22 15V9C22 4 20 2 15 2H9C4 2 2 4 2 9V15C2 20 4 22 9 22Z" stroke="#0A2540" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M7 12.1599H9.68C10.39 12.1599 10.87 12.6999 10.87 13.3499V14.8399C10.87 15.4899 10.39 16.0299 9.68 16.0299H8.19C7.54 16.0299 7 15.4899 7 14.8399V12.1599Z" stroke="#0A2540" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M7 12.16C7 9.36997 7.52 8.89997 9.09 7.96997" stroke="#0A2540" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M13.14 12.1599H15.82C16.53 12.1599 17.01 12.6999 17.01 13.3499V14.8399C17.01 15.4899 16.53 16.0299 15.82 16.0299H14.33C13.68 16.0299 13.14 15.4899 13.14 14.8399V12.1599Z" stroke="#0A2540" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M13.14 12.16C13.14 9.36997 13.66 8.89997 15.23 7.96997" stroke="#0A2540" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                <span class="menu-title"> {{ __('cruds.quote.title') }} </span>
            </a>
        </li>
        @endcan

        @can('contact_access')
        <li class="nav-item {{ request()->is('admin/contacts') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.contacts') }}">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M8 22H14C17 22 18 21 18 18V6C18 3 17 2 14 2H8C5 2 4 3 4 6V18C4 21 5 22 8 22Z" stroke="#0A2540" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M11.0056 10.827C10.9612 10.827 10.9057 10.827 10.8614 10.827C9.81886 10.7943 8.98706 9.94632 8.98706 8.91348C8.98706 7.8589 9.86323 7 10.939 7C12.0148 7 12.891 7.8589 12.891 8.91348C12.8799 9.95719 12.0481 10.7943 11.0056 10.827Z" stroke="#0A2540" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M8.79852 13.8706C7.73383 14.5664 7.73383 15.708 8.79852 16.4038C10.0074 17.1974 11.9926 17.1974 13.2015 16.4038C14.2662 15.708 14.2662 14.5664 13.2015 13.8706C12.0037 13.077 10.0185 13.077 8.79852 13.8706Z" stroke="#0A2540" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M20.5 4.5L20.5 7.5" stroke="#0A2540" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M20.5 11L20.5 14" stroke="#0A2540" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M20.5 17L20.5 20" stroke="#0A2540" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                <span class="menu-title"> {{ __('cruds.contacts.title') }} {{ __('global.list') }}</span>
            </a>
        </li>
        @endcan

        @can('user_access')
        <li class="nav-item {{ request()->is('admin/users') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.users') }}">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M9.16006 10.87C9.06006 10.86 8.94006 10.86 8.83006 10.87C6.45006 10.79 4.56006 8.84 4.56006 6.44C4.56006 3.99 6.54006 2 9.00006 2C11.4501 2 13.4401 3.99 13.4401 6.44C13.4301 8.84 11.5401 10.79 9.16006 10.87Z" stroke="#0A2540" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M16.41 4C18.35 4 19.91 5.57 19.91 7.5C19.91 9.39 18.41 10.93 16.54 11C16.46 10.99 16.37 10.99 16.28 11" stroke="#0A2540" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M4.15997 14.56C1.73997 16.18 1.73997 18.82 4.15997 20.43C6.90997 22.27 11.42 22.27 14.17 20.43C16.59 18.81 16.59 16.17 14.17 14.56C11.43 12.73 6.91997 12.73 4.15997 14.56Z" stroke="#0A2540" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M18.34 20C19.06 19.85 19.74 19.56 20.3 19.13C21.86 17.96 21.86 16.03 20.3 14.86C19.75 14.44 19.08 14.16 18.37 14" stroke="#0A2540" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <span class="menu-title"> {{ __('cruds.user.title') }} </span>
            </a>
        </li>
        @endcan

        @can('page_access')
        <li class="nav-item {{ request()->is('admin/page-manage') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.page-manage') }}">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M13.01 2.92007L18.91 5.54007C20.61 6.29007 20.61 7.53007 18.91 8.28007L13.01 10.9001C12.34 11.2001 11.24 11.2001 10.57 10.9001L4.67002 8.28007C2.97002 7.53007 2.97002 6.29007 4.67002 5.54007L10.57 2.92007C11.24 2.62007 12.34 2.62007 13.01 2.92007Z" stroke="#0A2540" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M3 11C3 11.84 3.63 12.81 4.4 13.15L11.19 16.17C11.71 16.4 12.3 16.4 12.81 16.17L19.6 13.15C20.37 12.81 21 11.84 21 11" stroke="#0A2540" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M3 16C3 16.93 3.55 17.77 4.4 18.15L11.19 21.17C11.71 21.4 12.3 21.4 12.81 21.17L19.6 18.15C20.45 17.77 21 16.93 21 16" stroke="#0A2540" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <span class="menu-title"> {{ __('cruds.pages.title') }} </span>
            </a>
        </li>
        @endcan

        @can('transaction_access')
        {{-- <li class="nav-item {{ request()->is('admin/transactions') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.transactions') }}">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M12 5.56055H22" stroke="#0A2540" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                <path d="M14.22 2H19.78C21.56 2 22 2.44 22 4.2V8.31C22 10.07 21.56 10.51 19.78 10.51H14.22C12.44 10.51 12 10.07 12 8.31V4.2C12 2.44 12.44 2 14.22 2Z" stroke="#0A2540" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                <path d="M2 17.0605H12" stroke="#0A2540" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                <path d="M4.22 13.5H9.78C11.56 13.5 12 13.94 12 15.7V19.81C12 21.57 11.56 22.01 9.78 22.01H4.22C2.44 22.01 2 21.57 2 19.81V15.7C2 13.94 2.44 13.5 4.22 13.5Z" stroke="#0A2540" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                <path d="M22 15C22 18.87 18.87 22 15 22L16.05 20.25" stroke="#0A2540" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                <path d="M2 9C2 5.13 5.13 2 9 2L7.95001 3.75" stroke="#0A2540" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
            <span class="menu-title"> {{ __('cruds.transaction.title') }} </span>
        </a>
        </li> --}}
        @endcan
        {{-- Settings --}}
        @can('setting_access')
        <li class="nav-item {{ request()->is('admin/settings') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.settings') }}">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M12 15C13.6569 15 15 13.6569 15 12C15 10.3431 13.6569 9 12 9C10.3431 9 9 10.3431 9 12C9 13.6569 10.3431 15 12 15Z" stroke="#0A2540" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                <path d="M2 12.8799V11.1199C2 10.0799 2.85 9.21994 3.9 9.21994C5.71 9.21994 6.45 7.93994 5.54 6.36994C5.02 5.46994 5.33 4.29994 6.24 3.77994L7.97 2.78994C8.76 2.31994 9.78 2.59994 10.25 3.38994L10.36 3.57994C11.26 5.14994 12.74 5.14994 13.65 3.57994L13.76 3.38994C14.23 2.59994 15.25 2.31994 16.04 2.78994L17.77 3.77994C18.68 4.29994 18.99 5.46994 18.47 6.36994C17.56 7.93994 18.3 9.21994 20.11 9.21994C21.15 9.21994 22.01 10.0699 22.01 11.1199V12.8799C22.01 13.9199 21.16 14.7799 20.11 14.7799C18.3 14.7799 17.56 16.0599 18.47 17.6299C18.99 18.5399 18.68 19.6999 17.77 20.2199L16.04 21.2099C15.25 21.6799 14.23 21.3999 13.76 20.6099L13.65 20.4199C12.75 18.8499 11.27 18.8499 10.36 20.4199L10.25 20.6099C9.78 21.3999 8.76 21.6799 7.97 21.2099L6.24 20.2199C5.33 19.6999 5.02 18.5299 5.54 17.6299C6.45 16.0599 5.71 14.7799 3.9 14.7799C2.85 14.7799 2 13.9199 2 12.8799Z" stroke="#0A2540" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
            <span class="menu-title"> {{ __('cruds.setting.title') }} </span>
        </a>
        </li>
        @endcan

        @livewire('auth.admin.logout',['type'=>'sidebar'])

        @endif
    </ul>
</nav>