<div class="content-wrapper">

    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">

                    @if($formMode)

                        @include('livewire.admin.user.form')

                    @elseif($viewMode)

                        @livewire('admin.user.show', ['user_id' => $user_id])

                    @elseif($viewQuoteHistoryMode)

                        @livewire('admin.user.quote-history', ['user_id' => $user_id])

                    @else
                    <div wire:loading wire:target="create" class="loader"></div>
                    <div class="card-title top-box-set">
                        <h4 class="card-title-heading">@lang('cruds.user.title') @lang('global.list') </h4>
                    </div>
                    <div class="table-responsive search-table-data">

                        @livewire('admin.user.user-table')

                    </div>

                    @endif

                </div>
            </div>
        </div>
    </div>

</div>