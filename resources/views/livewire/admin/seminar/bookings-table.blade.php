<div>
    <div wire:loading wire:target="create" class="loader"></div>
    <div class="card-title top-box-set">
        <h4 class="card-title-heading"> {{ ucfirst($seminarName) ?? '' }} </h4>
        <button wire:click.prevent="cancel" class="btn btn-secondary">
            {{ __('global.back')}}
            <span wire:loading wire:target="cancel">
                <i class="fa fa-solid fa-spinner fa-spin" aria-hidden="true"></i>
            </span>
        </button>
    </div>
    <div class="table-responsive search-table-data">
        <div class="relative">

            @include('admin.partials.table-show-entries-search-box', ['searchBoxPlaceholder'=>$searchBoxPlaceholder])
        
            <div class="table-responsive mt-3 my-team-details table-record">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th class="text-gray-500 text-xs font-medium">{{ trans('global.sno') }}</th>
                            <th class="text-gray-500 text-xs">@lang('cruds.booking.fields.user_name')
                                <span wire:click="sortBy('user.name')" class="float-right text-sm" style="cursor: pointer;">
                                    <i class="fa fa-arrow-up {{ $sortColumnName === 'user.name' && $sortDirection === 'asc' ? '' : 'text-muted' }}"></i>
                                    <i class="fa fa-arrow-down m-0 {{ $sortColumnName === 'user.name' && $sortDirection === 'desc' ? '' : 'text-muted' }}"></i>
                                </span>
                            </th>
                            <th class="text-gray-500 text-xs">@lang('cruds.booking.fields.booking_number')
                                <span wire:click="sortBy('booking_number')" class="float-right text-sm" style="cursor: pointer;">
                                    <i class="fa fa-arrow-up {{ $sortColumnName === 'booking_number' && $sortDirection === 'asc' ? '' : 'text-muted' }}"></i>
                                    <i class="fa fa-arrow-down m-0 {{ $sortColumnName === 'booking_number' && $sortDirection === 'desc' ? '' : 'text-muted' }}"></i>
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
                        @if($seminarBookings->count() > 0)
                        @foreach($seminarBookings as $serialNo => $booking)
                        <tr>
                            <td>{{ $serialNo+1 }}</td>
                            {{-- <td>{{ ucwords($booking->user->name) }}</td> --}}
                            <td>{{ ucwords($booking->user_details ? json_decode($booking->user_details, true)['name'] : '') }}</td>
                            <td>{{ $booking->booking_number }}</td>
                            <td>{{ convertDateTimeFormat($booking->created_at,'fulldate') }}</td>
            
                            <td>
                                <div class="update-webinar table-btns">
                                    <ul class="d-flex">
                                        <li>
                                            <a href="javascript:void()" wire:click.prevent="$emitUp('show', {{$booking->id}})">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" width="20" height="20">
                                                    <g id="_01_align_center" data-name="01 align center">
                                                        <path d="M23.821,11.181v0C22.943,9.261,19.5,3,12,3S1.057,9.261.179,11.181a1.969,1.969,0,0,0,0,1.64C1.057,14.739,4.5,21,12,21s10.943-6.261,11.821-8.181A1.968,1.968,0,0,0,23.821,11.181ZM12,19c-6.307,0-9.25-5.366-10-6.989C2.75,10.366,5.693,5,12,5c6.292,0,9.236,5.343,10,7C21.236,13.657,18.292,19,12,19Z" fill="#40658B"></path>
                                                        <path d="M12,7a5,5,0,1,0,5,5A5.006,5.006,0,0,0,12,7Zm0,8a3,3,0,1,1,3-3A3,3,0,0,1,12,15Z" fill="#40658B"></path>
                                                    </g>
                                                </svg>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
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
            {{ $seminarBookings->links('vendor.pagination.custom-pagination') }}
        
        </div>
    </div>
</div>