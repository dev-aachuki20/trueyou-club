<div class="relative">

    @include('admin.partials.table-show-entries-search-box')

    <div class="table-responsive mt-3 my-team-details table-record">
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th class="text-gray-500 text-xs font-medium">{{ trans('global.sno') }}</th>

                    <th class="text-gray-500 text-xs">
                        {{ __('cruds.contacts.fields.full_name') }}
                        <span wire:click="sortByName('full_name')" class="float-right text-sm" style="cursor: pointer;">
                            <i class="fa fa-arrow-up {{ $sortColumnFullName === 'full_name' && $sortDirection === 'asc' ? '' : 'text-muted' }}"></i>
                            <i class="fa fa-arrow-down m-0 {{ $sortColumnFullName === 'full_name' && $sortDirection === 'desc' ? '' : 'text-muted' }}"></i>
                        </span>
                    </th>

                    <th class="text-gray-500 text-xs">
                        {{ __('cruds.contacts.fields.phone_number')}}
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
                @if($allContacts->count() > 0)
                @foreach($allContacts as $serialNo => $contact)
                <tr>
                    <td>{{ $serialNo+1 }}</td>
                    <td>{{ ucwords($contact->first_name) }} {{ ucwords($contact->last_name) }}</td>
                    <td>{{ ucwords($contact->phone_number) }}</td>

                    <td>{{ convertDateTimeFormat($contact->created_at,'date_month_year') }}</td>
                    <td>

                        <div class="update-webinar table-btns">
                            <ul class="d-flex">
                                @can('contact_show')
                                <li>
                                    <a href="javascript:void()" wire:click.prevent="$emitUp('show', {{$contact->id}})">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" width="20" height="20">
                                            <g id="_01_align_center" data-name="01 align center">
                                                <path d="M23.821,11.181v0C22.943,9.261,19.5,3,12,3S1.057,9.261.179,11.181a1.969,1.969,0,0,0,0,1.64C1.057,14.739,4.5,21,12,21s10.943-6.261,11.821-8.181A1.968,1.968,0,0,0,23.821,11.181ZM12,19c-6.307,0-9.25-5.366-10-6.989C2.75,10.366,5.693,5,12,5c6.292,0,9.236,5.343,10,7C21.236,13.657,18.292,19,12,19Z" fill="#40658B"></path>
                                                <path d="M12,7a5,5,0,1,0,5,5A5.006,5.006,0,0,0,12,7Zm0,8a3,3,0,1,1,3-3A3,3,0,0,1,12,15Z" fill="#40658B"></path>
                                            </g>
                                        </svg>
                                    </a>
                                </li>
                                @endcan

                                @can('contact_delete')
                                <li>
                                    <a href="javascript:void()" wire:click.prevent="$emitUp('delete', {{$contact->id}})">
                                        <svg xmlns="http://www.w3.org/2000/svg" id="Outline" fill="none" viewBox="0 0 24 24" width="20" height="20">
                                            <path d="M21,4H17.9A5.009,5.009,0,0,0,13,0H11A5.009,5.009,0,0,0,6.1,4H3A1,1,0,0,0,3,6H4V19a5.006,5.006,0,0,0,5,5h6a5.006,5.006,0,0,0,5-5V6h1a1,1,0,0,0,0-2ZM11,2h2a3.006,3.006,0,0,1,2.829,2H8.171A3.006,3.006,0,0,1,11,2Zm7,17a3,3,0,0,1-3,3H9a3,3,0,0,1-3-3V6H18Z" fill="#40658B"></path>
                                            <path d="M10,18a1,1,0,0,0,1-1V11a1,1,0,0,0-2,0v6A1,1,0,0,0,10,18Z" fill="#40658B"></path>
                                            <path d="M14,18a1,1,0,0,0,1-1V11a1,1,0,0,0-2,0v6A1,1,0,0,0,14,18Z" fill="#40658B"></path>
                                        </svg>
                                    </a>
                                </li>
                                @endcan
                            </ul>
                        </div>



                        {{-- <button type="button"  class="btn btn-info btn-rounded btn-icon">
                            <i class="ti-pencil-alt"></i>
                        </button> --}}

                        {{-- @can('contact_show')
                        <button title="Show" type="button" wire:click.prevent="$emitUp('show', {{$contact->id}})" class="btn btn-info view-btn btn-rounded btn-icon">
                        <i class="ti-eye"></i>
                        </button>
                        @endcan

                        @can('contact_delete')
                        <button title="Delete" type="button" wire:click.prevent="$emitUp('delete', {{$contact->id}})" class="btn btn-danger btn-rounded btn-icon">
                            <i class="ti-trash"></i>
                        </button>
                        @endcan --}}

                        {{-- @if($contact->is_draft == 1)
                        <button title="Reply" type="button" wire:click.prevent="$emitUp('reply', {{$contact->id}})" class="btn btn-success btn-rounded btn-icon">
                        <i class="fa fa-reply" aria-hidden="true"></i>
                        </button>
                        @endif --}}

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
    {{ $allContacts->links('vendor.pagination.custom-pagination') }}

</div>