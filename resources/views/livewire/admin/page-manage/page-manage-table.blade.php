<div class="relative">

    <!-- Show entries & Search box -->
    @include('admin.partials.table-show-entries-search-box')
    <!-- End Show entries & Search box -->

    <div class="table-responsive mt-3 my-team-details table-record">
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th class="text-gray-500 text-xs font-medium">{{ trans('global.sno') }}</th>

                    <th class="text-gray-500 text-xs">
                        {{ __('cruds.pages.fields.page_name')}}
                    </th>

                    <th class="text-gray-500 text-xs">
                        {{ __('cruds.pages.fields.title')}}
                    </th>

                    <th class="text-gray-500 text-xs">@lang('global.created')
                        <span wire:click="sortBy('created_at')" class="float-right text-sm" style="cursor: pointer;">
                            <i class="fa fa-arrow-up {{ $sortColumnName === 'created_at' && $sortDirection === 'asc' ? '' : 'text-muted' }}"></i>
                            <i class="fa fa-arrow-down m-0 {{ $sortColumnName === 'created_at' && $sortDirection === 'desc' ? '' : 'text-muted' }}"></i>
                        </span>
                    </th>

                    {{-- <th class="text-gray-500 text-xs">
                        @lang('global.status')
                        <span wire:click="sortBy('status')" class="float-right text-sm" style="cursor: pointer;">
                            <i class="fa fa-arrow-up {{ $sortColumnName === 'status' && $sortDirection === 'asc' ? '' : 'text-muted' }}"></i>
                    <i class="fa fa-arrow-down m-0 {{ $sortColumnName === 'status' && $sortDirection === 'desc' ? '' : 'text-muted' }}"></i>
                    </span>
                    </th> --}}



                    <th class="text-gray-500 text-xs">@lang('global.action')</th>
                </tr>
            </thead>
            <tbody>
                @if($allPages->count() > 0)
                @foreach($allPages as $serialNo => $page)
                <tr>
                    <td>{{ $serialNo+1 }}</td>
                    <td>{{ ucwords($page->page_name) }}</td>
                    <td>{{ ucwords($page->title) }}</td>

                    <td>{{ convertDateTimeFormat($page->created_at,'date_month_year') }}</td>
                    {{-- <td>
                        <label class="toggle-switch">
                            <input type="checkbox" class="toggleSwitch" wire:click.prevent="$emitUp('toggle',{{$page->id}})" {{ $page->status == 1 ? 'checked' : '' }}>
                    <div class="switch-slider round"></div>
                    </label>
                    </td> --}}

                    <td>

                        @can('page_show')
                        <button title="Show" type="button" wire:click.prevent="$emitUp('show', {{$page->id}})" class="btn btn-info view-btn btn-rounded btn-icon">
                            <i class="ti-eye"></i>
                        </button>
                        @endcan

                        @can('page_edit')
                        <button title="Edit" type="button" wire:click.prevent="$emitUp('edit', {{$page->id}})" class="btn btn-info btn-rounded btn-icon">
                            <i class="ti-pencil"></i>
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
    {{ $allPages->links('vendor.pagination.custom-pagination') }}

</div>