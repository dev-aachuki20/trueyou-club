<div class="relative">

    @include('admin.partials.table-show-entries-search-box')

    <div class="table-responsive mt-3 my-team-details table-record">
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th class="text-gray-500 text-xs font-medium">{{ trans('global.sno') }}</th>
                    <th class="text-gray-500 text-xs">
                        {{ __('cruds.contacts.fields.full_name')}}
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

                    <td>{{ convertDateTimeFormat($contact->created_at,'date') }}</td>
                    <td>

                        {{-- <button type="button"  class="btn btn-info btn-rounded btn-icon">
                            <i class="ti-pencil-alt"></i>
                        </button> --}}
                        @can('contact_show')
                        <button title="Show" type="button" wire:click.prevent="$emitUp('show', {{$contact->id}})" class="btn btn-info view-btn btn-rounded btn-icon">
                            <i class="ti-eye"></i>
                        </button>
                        @endcan

                        @can('contact_delete')
                        <button title="Delete" type="button" wire:click.prevent="$emitUp('delete', {{$contact->id}})" class="btn btn-danger btn-rounded btn-icon">
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
    {{ $allContacts->links('vendor.pagination.custom-pagination') }}

</div>