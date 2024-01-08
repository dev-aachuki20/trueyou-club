<div class="content-wrapper">
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    @if($formMode)
                        @include('livewire.admin.quote.form')
                    @elseif($viewMode)
                        @livewire('admin.quote.show', ['quote_id' => $quote_id])
                    @else
                        <div wire:loading wire:target="create" class="loader"></div>
                        <div class="card-title top-box-set">
                            <h4 class="card-title-heading">@lang('cruds.quote.title') @lang('global.list') </h4>
                            <div class="card-top-box-item">
                                @can('quote_create')
                                    @if(!$todayDateExist)
                                        <button wire:click="create()" type="button" class="btn joinBtn btn-sm btn-icon-text btn-header">
                                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M8.73956 14.3355C8.55177 14.5232 8.2948 14.6418 7.99829 14.6418C7.42503 14.6418 6.95062 14.1674 6.95062 13.5942L6.95062 2.40586C6.95062 1.8326 7.42503 1.35819 7.99828 1.35819C8.57154 1.35819 9.04595 1.8326 9.04595 2.40586L9.04595 13.5942C9.05584 13.8808 8.92735 14.1477 8.73956 14.3355Z" fill="#0A2540"/>
                                                <path d="M14.3337 8.74129C14.1459 8.92908 13.889 9.04769 13.5924 9.04769L2.40412 9.04769C1.83087 9.04769 1.35645 8.57327 1.35645 8.00002C1.35645 7.42676 1.83087 6.95235 2.40412 6.95235L13.5924 6.95235C14.1657 6.95235 14.6401 7.42676 14.6401 8.00002C14.6401 8.29653 14.5215 8.5535 14.3337 8.74129Z" fill="#0A2540"/>
                                            </svg>                                                        
                                                {{__('global.add')}}
                                        </button>
                                    @endif
                                @endcan
                            </div>
                        </div> 
                        <div class="table-responsive search-table-data">                           
                            @livewire('admin.quote.quote-table')
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="quote_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ $modalType }} @lang('cruds.quote.title_singular')</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                @if($modalType == 'View')
                    <div class="modal-body">
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label font-weight-bold">@lang('cruds.quote.fields.message')</label>
                            <div class="col-sm-9 col-form-label">
                                {{ ucwords($quote->message) }}
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button wire:click.prevent="cancel" class="btn btn-secondary">
                            {{ __('global.cancel')}}
                            <span wire:loading wire:target="cancel">
                                <i class="fa fa-solid fa-spinner fa-spin" aria-hidden="true"></i>
                            </span>
                        </button>
                    </div>
                @else
                    <form wire:submit.prevent="{{ $updateMode ? 'update' : 'store' }}" class="forms-sample">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="font-weight-bold justify-content-start">{{ __('cruds.quote.fields.message')}}<i class="fas fa-asterisk"></i></label>
                                        <textarea class="form-control" wire:model.defer="message" placeholder="{{ __('cruds.quote.fields.message')}}" autocomplete="off"></textarea>
                                        @error('message') <span class="error text-danger">{{ $message }}</span>@enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" wire:loading.attr="disabled" class="btn btn-primary mr-2">
                                {{ $updateMode ? __('global.update') : __('global.submit') }}
                                <span wire:loading wire:target="{{ $updateMode ? 'update' : 'store' }}">
                                    <i class="fa fa-solid fa-spinner fa-spin" aria-hidden="true"></i>
                                </span>
                            </button>
                            <button wire:click.prevent="cancel" class="btn btn-secondary">
                                {{ __('global.cancel')}}
                                <span wire:loading wire:target="cancel">
                                    <i class="fa fa-solid fa-spinner fa-spin" aria-hidden="true"></i>
                                </span>
                            </button>
                        </div>
                    </form>
                @endif
                
            </div>
        </div>
    </div>
</div>

@push('styles')
<link rel="stylesheet" href="{{ asset('admin/assets/select2-bootstrap-theme/select2-bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ asset('admin/css/vertical-layout-light/style.css') }}">

@endpush

@push('scripts')
<script type="text/javascript">

    document.addEventListener('loadPlugins', function (event) {
        $('#quote_modal').modal('hide');
    });

    document.addEventListener('openModal', function (event) {
        $('#quote_modal').modal('show');
    });

</script>
@endpush
