<div class="relative">

    @include('admin.partials.table-show-entries-search-box')


    <div class="table-responsive mt-3 my-team-details table-record">
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th class="text-gray-500 text-xs font-medium">{{ trans('global.sno') }}</th>
                    <th class="text-gray-500 text-xs">
                        {{ __('cruds.user.fields.full_name')}}
                    </th>

                    <th class="text-gray-500 text-xs">
                        {{ __('cruds.user.fields.phone')}}
                    </th>

                    <th class="text-gray-500 text-xs">@lang('global.created')
                        <span wire:click="sortBy('created_at')" class="float-right text-sm" style="cursor: pointer;">
                            <i class="fa fa-arrow-up {{ $sortColumnName === 'created_at' && $sortDirection === 'asc' ? '' : 'text-muted' }}"></i>
                            <i class="fa fa-arrow-down m-0 {{ $sortColumnName === 'created_at' && $sortDirection === 'desc' ? '' : 'text-muted' }}"></i>
                        </span>
                    </th>

                    <th class="text-gray-500 text-xs">
                        Want A Break ?
                        <span wire:click="sortBy('is_active')" class="float-right text-sm" style="cursor: pointer;">
                            <i class="fa fa-arrow-up {{ $sortColumnName === 'is_active' && $sortDirection === 'asc' ? '' : 'text-muted' }}"></i>
                            <i class="fa fa-arrow-down m-0 {{ $sortColumnName === 'is_active' && $sortDirection === 'desc' ? '' : 'text-muted' }}"></i>
                        </span>
                    </th>



                    <th class="text-gray-500 text-xs">@lang('global.action')</th>
                </tr>
            </thead>
            <tbody>
                @if($allUsers->count() > 0)
                @foreach($allUsers as $serialNo => $user)
                <tr>
                    <td>{{ $serialNo+1 }}</td>
                    <td>{{ ucwords($user->first_name) }} {{ ucwords($user->last_name) }}</td>
                    <td>{{ ucwords($user->phone) }}</td>

                    <td>{{ convertDateTimeFormat($user->created_at,'date_month_year') }}</td>
                    <td>
                        <label class="toggle-switch">
                            <input type="checkbox" class="toggleSwitch" wire:click.prevent="$emitUp('toggle',{{$user->id}})" {{ $user->is_active == 1 ? 'checked' : '' }}>
                            <div class="switch-slider-other round"></div>
                        </label>

                    </td>

                    <td>

                        @can('user_show')
                        <button title="Show" type="button" wire:click.prevent="$emitUp('show', {{$user->id}})" class="btn btn-info view-btn btn-rounded btn-icon">
                            <i class="ti-eye"></i>
                        </button>
                        @endcan

                        @can('user_edit')
                        <button title="Edit" type="button" wire:click.prevent="$emitUp('edit', {{$user->id}})" class="btn btn-info btn-rounded btn-icon">
                            <i class="ti-pencil"></i>
                        </button>
                        @endcan

                        @can('user_delete')
                        <button title="Delete" type="button" wire:click.prevent="$emitUp('delete', {{$user->id}})" class="btn btn-danger btn-rounded btn-icon">
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
    {{ $allUsers->links('vendor.pagination.custom-pagination') }}

</div>