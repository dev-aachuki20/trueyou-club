<div>
    {{--<div class="relative">
       
        <!-- Show entries & Search box -->
        <div class="flex items-center justify-between mb-1">
            <div class="w-100 flex items-center">                
                <div class="w-100 items-center justify-between p-2 sm:flex">
                    <div class="flex items-center my-2 sm:my-0">
                        <span class="items-center justify-between p-2 sm:flex"> 
                            Show 
                            <select name="perPage" class="ml-2 mr-2 border block w-full py-2 pl-3 pr-10 mt-1 text-base border-gray-300 form-select leading-6 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 sm:text-sm sm:leading-5" wire:change="$emit('updatePaginationLength', $event.target.value)">
                                @foreach(config('constants.datatable_entries') as $length)
                                    <option value="{{ $length }}">{{ $length }}</option>
                                @endforeach
                            </select>
                            entries
                        </span>
                    </div>
                    <div class="flex justify-end text-gray-600">
                        <div class="flex rounded-lg w-96 shadow-sm">
                                <div class="relative flex-grow focus-within:z-10">
                                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                        <svg class="w-5 h-5 text-gray-400" viewBox="0 0 20 20" stroke="currentColor" fill="none">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                        </svg>
                                    </div>
                                    <input wire:model.debounce.500ms="search" class="block w-full py-3 pl-10 text-sm border-gray-300 leading-4 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 focus:outline-none" placeholder="Search" type="text">
                                    <div class="absolute inset-y-0 right-0 flex items-center pr-2">
                                        <button wire:click="$set('search', null)" class="text-gray-300 hover:text-red-600 focus:outline-none">
                                            <svg class="h-5 w-5 stroke-current w-5 h-5 stroke-current" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
            </div>
        </div>
        <!-- End Show entries & Search box -->
            
        <div class="table-responsive mt-3 my-team-details table-record">
            <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th class="text-gray-500 text-xs font-medium">{{ trans('global.sno') }}</th>
                    <th class="text-gray-500 text-xs">
                        {{ __('cruds.webinar.fields.title')}}
                        <span wire:click="sortBy('title')" class="float-right text-sm" style="cursor: pointer;">
                            <i class="fa fa-arrow-up {{ $sortColumnName === 'title' && $sortDirection === 'asc' ? '' : 'text-muted' }}"></i>
                            <i class="fa fa-arrow-down m-0 {{ $sortColumnName === 'title' && $sortDirection === 'desc' ? '' : 'text-muted' }}"></i>
                        </span>
                    </th>

                    <th class="text-gray-500 text-xs">
                        {{ __('cruds.webinar.fields.date')}}
                    </th>
                
                    <th class="text-gray-500 text-xs">
                        @lang('global.status')
                        <span wire:click="sortBy('status')" class="float-right text-sm" style="cursor: pointer;">
                            <i class="fa fa-arrow-up {{ $sortColumnName === 'status' && $sortDirection === 'asc' ? '' : 'text-muted' }}"></i>
                            <i class="fa fa-arrow-down m-0 {{ $sortColumnName === 'status' && $sortDirection === 'desc' ? '' : 'text-muted' }}"></i>
                        </span>
                    </th>
                    <th class="text-gray-500 text-xs">@lang('global.created')
                        <span wire:click="sortBy('created_at')" class="float-right text-sm" style="cursor: pointer;">
                            <i class="fa fa-arrow-up {{ $sortColumnName === 'created_at' && $sortDirection === 'asc' ? '' : 'text-muted' }}"></i>
                            <i class="fa fa-arrow-down m-0 {{ $sortColumnName === 'created_at' && $sortDirection === 'desc' ? '' : 'text-muted' }}"></i>
                        </span>
                    </th>
                    <th class="text-gray-500 text-xs">@lang('global.action')</th>
                </tr>
            </thead>
            <tbody>
                @if($allWebinar->count() > 0)
                @foreach($allWebinar as $serialNo => $webinar)
                    <tr>
                        <td>{{ $serialNo+1 }}</td>
                        <td>{{ ucwords($webinar->title) }}</td>
                        <td>{{ convertDateTimeFormat($webinar->date,'date') }}</td>
                        <td>
                            <label class="toggle-switch">
                                <input type="checkbox" class="toggleSwitch" wire:click.prevent="$emitUp('toggle',{{$webinar->id}})" {{ $webinar->status == 1 ? 'checked' : '' }}>
                                <div class="switch-slider round"></div>
                            </label>

                        </td>
                        <td>{{ convertDateTimeFormat($webinar->created_at,'date') }}</td>
                        <td>

                            @can('webinar_show')
                            <button title="Show" type="button" wire:click.prevent="$emitUp('show', {{$webinar->id}})" class="btn btn-primary btn-rounded btn-icon">
                                <i class="ti-eye"></i>
                            </button>
                            @endcan

                            @can('webinar_edit')
                            <button title="Edit" type="button" wire:click.prevent="$emitUp('edit', {{$webinar->id}})" class="btn btn-info btn-rounded btn-icon">
                                <i class="ti-pencil-alt"></i>
                            </button>
                            @endcan

                            @can('webinar_delete')
                            <button title="Delete" type="button" wire:click.prevent="$emitUp('delete', {{$webinar->id}})" class="btn btn-danger btn-rounded btn-icon">
                                <i class="ti-trash"></i>
                            </button>
                            @endcan

                        </td>
                    </tr>
                @endforeach
            @else
            <tr>
                <td class="text-center" colspan="7">{{ __('messages.no_record_found')}}</td>
            </tr>
            @endif
            
            </tbody>
            </table>
        </div>

        {{ $allWebinar->links('vendor.pagination.custom-pagination') }}
    </div>--}}

    <div class="flex items-center justify-between mb-1">
        <div class="w-100 flex items-center">                
            <div class="w-100 items-center justify-between p-2 sm:flex">
                <div class="flex items-center my-2 sm:my-0">
                    <span class="items-center justify-between p-2 sm:flex"> 
                        Show 
                        <select name="perPage" class="ml-2 mr-2 border block w-full py-2 pl-3 pr-10 mt-1 text-base border-gray-300 form-select leading-6 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 sm:text-sm sm:leading-5" wire:model="perPage">
                            @foreach(config('constants.datatable_entries') as $length)
                                <option value="{{ $length }}">{{ $length }}</option>
                            @endforeach
                        </select>
                        entries
                    </span>
                </div>
                <div class="flex justify-end text-gray-600">
                    <div class="flex rounded-lg w-96 shadow-sm">
                            <div class="relative flex-grow focus-within:z-10">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" viewBox="0 0 20 20" stroke="currentColor" fill="none">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                                </div>
                                <input wire:model.debounce.500ms="search" class="block w-full py-3 pl-10 text-sm border-gray-300 leading-4 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 focus:outline-none" placeholder="Search" type="text">
                                <div class="absolute inset-y-0 right-0 flex items-center pr-2">
                                    <button wire:click="$set('search', null)" class="text-gray-300 hover:text-red-600 focus:outline-none">
                                        <svg class="h-5 w-5 stroke-current w-5 h-5 stroke-current" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
    </div>
    <div class="webinar_listing row">
        @if($allWebinar->count() > 0)
            @foreach($allWebinar as $serialNo => $webinar)
                @php 
                    $date = $webinar->date;
                    $time = $webinar->time; 
                    $dateTime = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $date . ' ' . $time);
                
                    $now = now();
                    $startWebinarTime = \Carbon\Carbon::parse($dateTime);

                    $startDays    = 00;
                    $startHours   = 00;
                    $startMinutes = 00;
                    $startSeconds = 00;
                    if($now < $startWebinarTime){
                        $timeDiff = $now->diff($startWebinarTime);
                        $diffInSeconds = $now->diffInSeconds($startWebinarTime);

                        $startDays    = $timeDiff->days;
                        $startHours   = $timeDiff->h;
                        $startMinutes = $timeDiff->i;
                        $startSeconds = $timeDiff->s;
                    }
                @endphp
                <div class="col-12 col-md-6">
                    <div class="webinar-item" data-diff_in_seconds="{{ $diffInSeconds }}">
                        <div class="webinar-item-inner">
                            <div class="webinar-img">
                                <img class="img-fluid" src="{{ $webinar->image_url ? $webinar->image_url : asset(config('constants.default.no_image')) }}" alt="">
                            </div>
                            <div class="webinar-content">
                                <h3>
                                    {{ ucwords($webinar->title) }}
                                </h3>
                                <a href="{{ $webinar->meeting_link }}" class="btn btn-primary joinBtn">
                                    Join The Webinar
                                </a>
                                <div class="webinar-time-system webinar-time-{{ $webinar->id }} counter-main">
                                    
                                    <div class="time-item counter-outer" data-label="days" data-value="{{ $startDays }}">
                                        <b class="counter" >{{ $startDays }}</b><span>Days</span>
                                    </div>:
                                    <div class="time-item counter-outer" data-label="hours" data-value="{{ $startHours }}">
                                        <b class="counter" >{{ $startHours }}</b><span>Hours</span>
                                    </div>:
                                    <div class="time-item counter-outer" data-label="minutes" data-value="{{ $startMinutes }}">
                                        <b class="counter" >{{ $startMinutes }}</b><span>Minute</span>
                                    </div>:
                                    <div class="time-item counter-outer" data-label="seconds" data-value="{{ $startSeconds }}">
                                        <b class="counter" >{{ $startSeconds }}</b><span>Second</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="update-webinar">
                            <ul class="d-flex">
                                @can('webinar_show')
                                <li>
                                    <a href="javascript:void()" wire:click.prevent="$emitUp('edit', {{$webinar->id}})">
                                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M12.5003 18.9583H7.50033C2.97533 18.9583 1.04199 17.025 1.04199 12.5V7.49996C1.04199 2.97496 2.97533 1.04163 7.50033 1.04163H9.16699C9.50866 1.04163 9.79199 1.32496 9.79199 1.66663C9.79199 2.00829 9.50866 2.29163 9.16699 2.29163H7.50033C3.65866 2.29163 2.29199 3.65829 2.29199 7.49996V12.5C2.29199 16.3416 3.65866 17.7083 7.50033 17.7083H12.5003C16.342 17.7083 17.7087 16.3416 17.7087 12.5V10.8333C17.7087 10.4916 17.992 10.2083 18.3337 10.2083C18.6753 10.2083 18.9587 10.4916 18.9587 10.8333V12.5C18.9587 17.025 17.0253 18.9583 12.5003 18.9583Z" fill="#40658B"/>
                                            <path d="M7.08311 14.7417C6.57478 14.7417 6.10811 14.5584 5.76645 14.225C5.35811 13.8167 5.18311 13.225 5.27478 12.6L5.63311 10.0917C5.69978 9.60838 6.01645 8.98338 6.35811 8.64172L12.9248 2.07505C14.5831 0.416716 16.2664 0.416716 17.9248 2.07505C18.8331 2.98338 19.2414 3.90838 19.1581 4.83338C19.0831 5.58338 18.6831 6.31672 17.9248 7.06672L11.3581 13.6334C11.0164 13.975 10.3914 14.2917 9.90811 14.3584L7.39978 14.7167C7.29145 14.7417 7.18311 14.7417 7.08311 14.7417ZM13.8081 2.95838L7.24145 9.52505C7.08311 9.68338 6.89978 10.05 6.86645 10.2667L6.50811 12.775C6.47478 13.0167 6.52478 13.2167 6.64978 13.3417C6.77478 13.4667 6.97478 13.5167 7.21645 13.4834L9.72478 13.125C9.94145 13.0917 10.3164 12.9084 10.4664 12.75L17.0331 6.18338C17.5748 5.64172 17.8581 5.15838 17.8998 4.70838C17.9498 4.16672 17.6664 3.59172 17.0331 2.95005C15.6998 1.61672 14.7831 1.99172 13.8081 2.95838Z" fill="#40658B"/>
                                            <path d="M16.5413 8.19173C16.483 8.19173 16.4246 8.1834 16.3746 8.16673C14.183 7.55006 12.4413 5.8084 11.8246 3.61673C11.733 3.2834 11.9246 2.94173 12.258 2.84173C12.5913 2.75006 12.933 2.94173 13.0246 3.27506C13.5246 5.05006 14.933 6.4584 16.708 6.9584C17.0413 7.05006 17.233 7.40006 17.1413 7.7334C17.0663 8.01673 16.8163 8.19173 16.5413 8.19173Z" fill="#40658B"/>
                                        </svg>
                                    </a>
                                </li>
                                @endcan

                                @can('webinar_edit')
                                <li>
                                    <a href="javascript:void()" wire:click.prevent="$emitUp('delete', {{$webinar->id}})">
                                    <svg xmlns="http://www.w3.org/2000/svg" id="Outline" fill="none" viewBox="0 0 24 24" width="20" height="20"><path d="M21,4H17.9A5.009,5.009,0,0,0,13,0H11A5.009,5.009,0,0,0,6.1,4H3A1,1,0,0,0,3,6H4V19a5.006,5.006,0,0,0,5,5h6a5.006,5.006,0,0,0,5-5V6h1a1,1,0,0,0,0-2ZM11,2h2a3.006,3.006,0,0,1,2.829,2H8.171A3.006,3.006,0,0,1,11,2Zm7,17a3,3,0,0,1-3,3H9a3,3,0,0,1-3-3V6H18Z" fill="#40658B"/><path d="M10,18a1,1,0,0,0,1-1V11a1,1,0,0,0-2,0v6A1,1,0,0,0,10,18Z" fill="#40658B"/><path d="M14,18a1,1,0,0,0,1-1V11a1,1,0,0,0-2,0v6A1,1,0,0,0,14,18Z" fill="#40658B"/></svg>
                                    </a>
                                </li>
                                @endcan

                                @can('webinar_delete')
                                <li>
                                    <a href="javascript:void()" wire:click.prevent="$emitUp('show', {{$webinar->id}})">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" width="20" height="20"><g id="_01_align_center" data-name="01 align center"><path d="M23.821,11.181v0C22.943,9.261,19.5,3,12,3S1.057,9.261.179,11.181a1.969,1.969,0,0,0,0,1.64C1.057,14.739,4.5,21,12,21s10.943-6.261,11.821-8.181A1.968,1.968,0,0,0,23.821,11.181ZM12,19c-6.307,0-9.25-5.366-10-6.989C2.75,10.366,5.693,5,12,5c6.292,0,9.236,5.343,10,7C21.236,13.657,18.292,19,12,19Z" fill="#40658B"/><path d="M12,7a5,5,0,1,0,5,5A5.006,5.006,0,0,0,12,7Zm0,8a3,3,0,1,1,3-3A3,3,0,0,1,12,15Z" fill="#40658B"/></g></svg>
                                    </a>
                                </li>
                                @endcan
                            </ul>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <div class="no-record">{{ __('messages.no_record_found')}}</div>
        @endif

        {{ $allWebinar->links('vendor.pagination.custom-pagination') }}
            
        <!-- <div class="col-12 col-md-6">
            <div class="webinar-item">
                <div class="webinar-item-inner">
                    <div class="webinar-img">
                        <img class="img-fluid" src="https://trueyouclub.hipl-staging3.com/images/webinar.png" alt="">
                    </div>
                    <div class="webinar-content">
                        <h3>
                            Trueyou.Club Realise Your Potential
                        </h3>
                        <a href="javascript:void()" class="btn btn-primary joinBtn">
                            Join The Webinar
                        </a>
                        <div class="webinar-time-system">
                            <div class="time-item">
                                <b>21</b><span>Days</span>
                            </div>:
                            <div class="time-item">
                                <b>08</b><span>Hours</span>
                            </div>:
                            <div class="time-item">
                                <b>35</b><span>Minute</span>
                            </div>:
                            <div class="time-item">
                                <b>09</b><span>Second</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="update-webinar">
                    <ul class="d-flex">
                        <li>
                            <a href="javascript:void()">
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M12.5003 18.9583H7.50033C2.97533 18.9583 1.04199 17.025 1.04199 12.5V7.49996C1.04199 2.97496 2.97533 1.04163 7.50033 1.04163H9.16699C9.50866 1.04163 9.79199 1.32496 9.79199 1.66663C9.79199 2.00829 9.50866 2.29163 9.16699 2.29163H7.50033C3.65866 2.29163 2.29199 3.65829 2.29199 7.49996V12.5C2.29199 16.3416 3.65866 17.7083 7.50033 17.7083H12.5003C16.342 17.7083 17.7087 16.3416 17.7087 12.5V10.8333C17.7087 10.4916 17.992 10.2083 18.3337 10.2083C18.6753 10.2083 18.9587 10.4916 18.9587 10.8333V12.5C18.9587 17.025 17.0253 18.9583 12.5003 18.9583Z" fill="#40658B"/>
                                    <path d="M7.08311 14.7417C6.57478 14.7417 6.10811 14.5584 5.76645 14.225C5.35811 13.8167 5.18311 13.225 5.27478 12.6L5.63311 10.0917C5.69978 9.60838 6.01645 8.98338 6.35811 8.64172L12.9248 2.07505C14.5831 0.416716 16.2664 0.416716 17.9248 2.07505C18.8331 2.98338 19.2414 3.90838 19.1581 4.83338C19.0831 5.58338 18.6831 6.31672 17.9248 7.06672L11.3581 13.6334C11.0164 13.975 10.3914 14.2917 9.90811 14.3584L7.39978 14.7167C7.29145 14.7417 7.18311 14.7417 7.08311 14.7417ZM13.8081 2.95838L7.24145 9.52505C7.08311 9.68338 6.89978 10.05 6.86645 10.2667L6.50811 12.775C6.47478 13.0167 6.52478 13.2167 6.64978 13.3417C6.77478 13.4667 6.97478 13.5167 7.21645 13.4834L9.72478 13.125C9.94145 13.0917 10.3164 12.9084 10.4664 12.75L17.0331 6.18338C17.5748 5.64172 17.8581 5.15838 17.8998 4.70838C17.9498 4.16672 17.6664 3.59172 17.0331 2.95005C15.6998 1.61672 14.7831 1.99172 13.8081 2.95838Z" fill="#40658B"/>
                                    <path d="M16.5413 8.19173C16.483 8.19173 16.4246 8.1834 16.3746 8.16673C14.183 7.55006 12.4413 5.8084 11.8246 3.61673C11.733 3.2834 11.9246 2.94173 12.258 2.84173C12.5913 2.75006 12.933 2.94173 13.0246 3.27506C13.5246 5.05006 14.933 6.4584 16.708 6.9584C17.0413 7.05006 17.233 7.40006 17.1413 7.7334C17.0663 8.01673 16.8163 8.19173 16.5413 8.19173Z" fill="#40658B"/>
                                </svg>
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void()">
                            <svg xmlns="http://www.w3.org/2000/svg" id="Outline" fill="none" viewBox="0 0 24 24" width="20" height="20"><path d="M21,4H17.9A5.009,5.009,0,0,0,13,0H11A5.009,5.009,0,0,0,6.1,4H3A1,1,0,0,0,3,6H4V19a5.006,5.006,0,0,0,5,5h6a5.006,5.006,0,0,0,5-5V6h1a1,1,0,0,0,0-2ZM11,2h2a3.006,3.006,0,0,1,2.829,2H8.171A3.006,3.006,0,0,1,11,2Zm7,17a3,3,0,0,1-3,3H9a3,3,0,0,1-3-3V6H18Z" fill="#40658B"/><path d="M10,18a1,1,0,0,0,1-1V11a1,1,0,0,0-2,0v6A1,1,0,0,0,10,18Z" fill="#40658B"/><path d="M14,18a1,1,0,0,0,1-1V11a1,1,0,0,0-2,0v6A1,1,0,0,0,14,18Z" fill="#40658B"/></svg>
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void()">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" width="20" height="20"><g id="_01_align_center" data-name="01 align center"><path d="M23.821,11.181v0C22.943,9.261,19.5,3,12,3S1.057,9.261.179,11.181a1.969,1.969,0,0,0,0,1.64C1.057,14.739,4.5,21,12,21s10.943-6.261,11.821-8.181A1.968,1.968,0,0,0,23.821,11.181ZM12,19c-6.307,0-9.25-5.366-10-6.989C2.75,10.366,5.693,5,12,5c6.292,0,9.236,5.343,10,7C21.236,13.657,18.292,19,12,19Z" fill="#40658B"/><path d="M12,7a5,5,0,1,0,5,5A5.006,5.006,0,0,0,12,7Zm0,8a3,3,0,1,1,3-3A3,3,0,0,1,12,15Z" fill="#40658B"/></g></svg>
                            </a>
                        </li>

                    </ul>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6">
            <div class="webinar-item">
                <div class="webinar-item-inner">
                    <div class="webinar-img">
                        <img class="img-fluid" src="https://trueyouclub.hipl-staging3.com/images/webinar.png" alt="">
                    </div>
                    <div class="webinar-content">
                        <h3>
                            Trueyou.Club Realise Your Potential
                        </h3>
                        <a href="javascript:void()" class="btn btn-primary joinBtn">
                            Join The Webinar
                        </a>
                        <div class="webinar-time-system">
                            <div class="time-item">
                                <b>21</b><span>Days</span>
                            </div>:
                            <div class="time-item">
                                <b>08</b><span>Hours</span>
                            </div>:
                            <div class="time-item">
                                <b>35</b><span>Minute</span>
                            </div>:
                            <div class="time-item">
                                <b>09</b><span>Second</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="update-webinar">
                    <ul class="d-flex">
                        <li>
                            <a href="javascript:void()">
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M12.5003 18.9583H7.50033C2.97533 18.9583 1.04199 17.025 1.04199 12.5V7.49996C1.04199 2.97496 2.97533 1.04163 7.50033 1.04163H9.16699C9.50866 1.04163 9.79199 1.32496 9.79199 1.66663C9.79199 2.00829 9.50866 2.29163 9.16699 2.29163H7.50033C3.65866 2.29163 2.29199 3.65829 2.29199 7.49996V12.5C2.29199 16.3416 3.65866 17.7083 7.50033 17.7083H12.5003C16.342 17.7083 17.7087 16.3416 17.7087 12.5V10.8333C17.7087 10.4916 17.992 10.2083 18.3337 10.2083C18.6753 10.2083 18.9587 10.4916 18.9587 10.8333V12.5C18.9587 17.025 17.0253 18.9583 12.5003 18.9583Z" fill="#40658B"/>
                                    <path d="M7.08311 14.7417C6.57478 14.7417 6.10811 14.5584 5.76645 14.225C5.35811 13.8167 5.18311 13.225 5.27478 12.6L5.63311 10.0917C5.69978 9.60838 6.01645 8.98338 6.35811 8.64172L12.9248 2.07505C14.5831 0.416716 16.2664 0.416716 17.9248 2.07505C18.8331 2.98338 19.2414 3.90838 19.1581 4.83338C19.0831 5.58338 18.6831 6.31672 17.9248 7.06672L11.3581 13.6334C11.0164 13.975 10.3914 14.2917 9.90811 14.3584L7.39978 14.7167C7.29145 14.7417 7.18311 14.7417 7.08311 14.7417ZM13.8081 2.95838L7.24145 9.52505C7.08311 9.68338 6.89978 10.05 6.86645 10.2667L6.50811 12.775C6.47478 13.0167 6.52478 13.2167 6.64978 13.3417C6.77478 13.4667 6.97478 13.5167 7.21645 13.4834L9.72478 13.125C9.94145 13.0917 10.3164 12.9084 10.4664 12.75L17.0331 6.18338C17.5748 5.64172 17.8581 5.15838 17.8998 4.70838C17.9498 4.16672 17.6664 3.59172 17.0331 2.95005C15.6998 1.61672 14.7831 1.99172 13.8081 2.95838Z" fill="#40658B"/>
                                    <path d="M16.5413 8.19173C16.483 8.19173 16.4246 8.1834 16.3746 8.16673C14.183 7.55006 12.4413 5.8084 11.8246 3.61673C11.733 3.2834 11.9246 2.94173 12.258 2.84173C12.5913 2.75006 12.933 2.94173 13.0246 3.27506C13.5246 5.05006 14.933 6.4584 16.708 6.9584C17.0413 7.05006 17.233 7.40006 17.1413 7.7334C17.0663 8.01673 16.8163 8.19173 16.5413 8.19173Z" fill="#40658B"/>
                                </svg>
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void()">
                            <svg xmlns="http://www.w3.org/2000/svg" id="Outline" fill="none" viewBox="0 0 24 24" width="20" height="20"><path d="M21,4H17.9A5.009,5.009,0,0,0,13,0H11A5.009,5.009,0,0,0,6.1,4H3A1,1,0,0,0,3,6H4V19a5.006,5.006,0,0,0,5,5h6a5.006,5.006,0,0,0,5-5V6h1a1,1,0,0,0,0-2ZM11,2h2a3.006,3.006,0,0,1,2.829,2H8.171A3.006,3.006,0,0,1,11,2Zm7,17a3,3,0,0,1-3,3H9a3,3,0,0,1-3-3V6H18Z" fill="#40658B"/><path d="M10,18a1,1,0,0,0,1-1V11a1,1,0,0,0-2,0v6A1,1,0,0,0,10,18Z" fill="#40658B"/><path d="M14,18a1,1,0,0,0,1-1V11a1,1,0,0,0-2,0v6A1,1,0,0,0,14,18Z" fill="#40658B"/></svg>
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void()">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" width="20" height="20"><g id="_01_align_center" data-name="01 align center"><path d="M23.821,11.181v0C22.943,9.261,19.5,3,12,3S1.057,9.261.179,11.181a1.969,1.969,0,0,0,0,1.64C1.057,14.739,4.5,21,12,21s10.943-6.261,11.821-8.181A1.968,1.968,0,0,0,23.821,11.181ZM12,19c-6.307,0-9.25-5.366-10-6.989C2.75,10.366,5.693,5,12,5c6.292,0,9.236,5.343,10,7C21.236,13.657,18.292,19,12,19Z" fill="#40658B"/><path d="M12,7a5,5,0,1,0,5,5A5.006,5.006,0,0,0,12,7Zm0,8a3,3,0,1,1,3-3A3,3,0,0,1,12,15Z" fill="#40658B"/></g></svg>
                            </a>
                        </li>

                    </ul>
                </div>
            </div>
        </div> -->
        <!-- <div class="col-12 col-md-6">
            <div class="webinar-item webinar-disabled">
                <div class="webinar-item-inner">
                    <div class="buyer-active-verfiy"><span>Expired Webinar </span></div>
                    <div class="webinar-img">
                        <img class="img-fluid" src="https://trueyouclub.hipl-staging3.com/images/webinar.png" alt="">
                    </div>
                    <div class="webinar-content">
                        <h3>
                            Trueyou.Club Realise Your Potential
                        </h3>
                        <a href="javascript:void()" class="btn btn-primary joinBtn">
                            Join The Webinar
                        </a>
                        <div class="webinar-time-system">
                            <div class="time-item">
                                <b>21</b><span>Days</span>
                            </div>:
                            <div class="time-item">
                                <b>08</b><span>Hours</span>
                            </div>:
                            <div class="time-item">
                                <b>35</b><span>Minute</span>
                            </div>:
                            <div class="time-item">
                                <b>09</b><span>Second</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="update-webinar">
                    <ul class="d-flex">
                        <li>
                            <a href="javascript:void()">
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M12.5003 18.9583H7.50033C2.97533 18.9583 1.04199 17.025 1.04199 12.5V7.49996C1.04199 2.97496 2.97533 1.04163 7.50033 1.04163H9.16699C9.50866 1.04163 9.79199 1.32496 9.79199 1.66663C9.79199 2.00829 9.50866 2.29163 9.16699 2.29163H7.50033C3.65866 2.29163 2.29199 3.65829 2.29199 7.49996V12.5C2.29199 16.3416 3.65866 17.7083 7.50033 17.7083H12.5003C16.342 17.7083 17.7087 16.3416 17.7087 12.5V10.8333C17.7087 10.4916 17.992 10.2083 18.3337 10.2083C18.6753 10.2083 18.9587 10.4916 18.9587 10.8333V12.5C18.9587 17.025 17.0253 18.9583 12.5003 18.9583Z" fill="#40658B"/>
                                    <path d="M7.08311 14.7417C6.57478 14.7417 6.10811 14.5584 5.76645 14.225C5.35811 13.8167 5.18311 13.225 5.27478 12.6L5.63311 10.0917C5.69978 9.60838 6.01645 8.98338 6.35811 8.64172L12.9248 2.07505C14.5831 0.416716 16.2664 0.416716 17.9248 2.07505C18.8331 2.98338 19.2414 3.90838 19.1581 4.83338C19.0831 5.58338 18.6831 6.31672 17.9248 7.06672L11.3581 13.6334C11.0164 13.975 10.3914 14.2917 9.90811 14.3584L7.39978 14.7167C7.29145 14.7417 7.18311 14.7417 7.08311 14.7417ZM13.8081 2.95838L7.24145 9.52505C7.08311 9.68338 6.89978 10.05 6.86645 10.2667L6.50811 12.775C6.47478 13.0167 6.52478 13.2167 6.64978 13.3417C6.77478 13.4667 6.97478 13.5167 7.21645 13.4834L9.72478 13.125C9.94145 13.0917 10.3164 12.9084 10.4664 12.75L17.0331 6.18338C17.5748 5.64172 17.8581 5.15838 17.8998 4.70838C17.9498 4.16672 17.6664 3.59172 17.0331 2.95005C15.6998 1.61672 14.7831 1.99172 13.8081 2.95838Z" fill="#40658B"/>
                                    <path d="M16.5413 8.19173C16.483 8.19173 16.4246 8.1834 16.3746 8.16673C14.183 7.55006 12.4413 5.8084 11.8246 3.61673C11.733 3.2834 11.9246 2.94173 12.258 2.84173C12.5913 2.75006 12.933 2.94173 13.0246 3.27506C13.5246 5.05006 14.933 6.4584 16.708 6.9584C17.0413 7.05006 17.233 7.40006 17.1413 7.7334C17.0663 8.01673 16.8163 8.19173 16.5413 8.19173Z" fill="#40658B"/>
                                </svg>
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void()">
                            <svg xmlns="http://www.w3.org/2000/svg" id="Outline" fill="none" viewBox="0 0 24 24" width="20" height="20"><path d="M21,4H17.9A5.009,5.009,0,0,0,13,0H11A5.009,5.009,0,0,0,6.1,4H3A1,1,0,0,0,3,6H4V19a5.006,5.006,0,0,0,5,5h6a5.006,5.006,0,0,0,5-5V6h1a1,1,0,0,0,0-2ZM11,2h2a3.006,3.006,0,0,1,2.829,2H8.171A3.006,3.006,0,0,1,11,2Zm7,17a3,3,0,0,1-3,3H9a3,3,0,0,1-3-3V6H18Z" fill="#40658B"/><path d="M10,18a1,1,0,0,0,1-1V11a1,1,0,0,0-2,0v6A1,1,0,0,0,10,18Z" fill="#40658B"/><path d="M14,18a1,1,0,0,0,1-1V11a1,1,0,0,0-2,0v6A1,1,0,0,0,14,18Z" fill="#40658B"/></svg>
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void()">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" width="20" height="20"><g id="_01_align_center" data-name="01 align center"><path d="M23.821,11.181v0C22.943,9.261,19.5,3,12,3S1.057,9.261.179,11.181a1.969,1.969,0,0,0,0,1.64C1.057,14.739,4.5,21,12,21s10.943-6.261,11.821-8.181A1.968,1.968,0,0,0,23.821,11.181ZM12,19c-6.307,0-9.25-5.366-10-6.989C2.75,10.366,5.693,5,12,5c6.292,0,9.236,5.343,10,7C21.236,13.657,18.292,19,12,19Z" fill="#40658B"/><path d="M12,7a5,5,0,1,0,5,5A5.006,5.006,0,0,0,12,7Zm0,8a3,3,0,1,1,3-3A3,3,0,0,1,12,15Z" fill="#40658B"/></g></svg>
                            </a>
                        </li>

                    </ul>
                </div>
            </div>
        </div> -->
    </div>

</div>