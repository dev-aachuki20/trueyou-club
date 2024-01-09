<div class="content-wrapper">

    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">

                    @if($formMode)

                    @include('livewire.admin.contact.form')

                    @elseif($viewMode)

                    @livewire('admin.contact.show', ['contact_id' => $contact_id])

                    @else
                    <div wire:loading wire:target="create" class="loader"></div>
                    <div class="card-title top-box-set">
                        <h4 class="card-title-heading">@lang('cruds.contacts.title') @lang('global.list') </h4>
                    </div>
                    <div class="table-responsive search-table-data">

                        @livewire('admin.contact.contact-table')

                    </div>

                    @endif

                </div>
            </div>
        </div>
    </div>

</div>