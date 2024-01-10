@if($type == 'navbar')
    <li>
        <a class="dropdown-item" href="javascript:void(0)" wire:click.prevent="logout">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M8.89999 7.56023C9.20999 3.96023 11.06 2.49023 15.11 2.49023H15.24C19.71 2.49023 21.5 4.28023 21.5 8.75023V15.2702C21.5 19.7402 19.71 21.5302 15.24 21.5302H15.11C11.09 21.5302 9.23999 20.0802 8.90999 16.5402" stroke="#0A2540" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M2 12H14.88" stroke="#0A2540" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M12.65 8.65039L16 12.0004L12.65 15.3504" stroke="#0A2540" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
            </svg> {{ __('global.logout')}}
        </a>
    </li>
@elseif($type == 'sidebar')

    <li class="nav-item">
        <a class="nav-link" href="javascript:void(0)" wire:click.prevent="logout">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M8.89999 7.56023C9.20999 3.96023 11.06 2.49023 15.11 2.49023H15.24C19.71 2.49023 21.5 4.28023 21.5 8.75023V15.2702C21.5 19.7402 19.71 21.5302 15.24 21.5302H15.11C11.09 21.5302 9.23999 20.0802 8.90999 16.5402" stroke="#0A2540" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M2 12H14.88" stroke="#0A2540" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M12.65 8.65039L16 12.0004L12.65 15.3504" stroke="#0A2540" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>                                
            <span class="menu-title"> {{ __('global.logout')}}</span>
        </a>
    </li>

@endif