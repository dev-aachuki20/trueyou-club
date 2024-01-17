<h4 class="card-title">
    {{ $updateMode ? __('global.edit') : __('global.create') }}
    {{ __('cruds.pages.title')}}
</h4>

<form wire:submit.prevent="{{ $updateMode ? 'update' : 'store' }}" class="forms-sample">

    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label class="font-weight-bold justify-content-start">{{ __('cruds.pages.fields.page_name')}}<i class="fas fa-asterisk"></i></label>
                <input disabled type="text" class="form-control" wire:model.defer="page_key" placeholder="{{ __('cruds.pages.fields.page_name')}}" autocomplete="off">
                @error('page_key') <span class="error text-danger">{{ $message }}</span>@enderror
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label class="font-weight-bold justify-content-start">{{ __('cruds.pages.fields.title')}}<i class="fas fa-asterisk"></i></label>
                <input type="text" class="form-control" wire:model.defer="title" placeholder="{{ __('cruds.pages.fields.title')}}" autocomplete="off">
                @error('title') <span class="error text-danger">{{ $message }}</span>@enderror
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 mb-4">
            <div class="form-group mb-0" wire:ignore>
                <label class="font-weight-bold justify-content-start">{{ __('cruds.pages.fields.subtitle')}}<i class="fas fa-asterisk"></i></label>
                <input type="text" class="form-control" wire:model.defer="subtitle" placeholder="{{ __('cruds.pages.fields.subtitle')}}" autocomplete="off">
            </div>
            @error('subtitle') <span class="error text-danger">{{ $message }}</span>@enderror
        </div>
    </div>
           

    <div class="row logo-section">
        <div class="col-md-12 mb-4">
            <div class="form-group mb-0" wire:ignore>
                <label class="font-weight-bold justify-content-start">{{ __('global.image')}}</label>
                <input type="file" id="dropify-image" wire:model.defer="image" class="dropify" data-default-file="{{ $originalImage }}" data-show-loader="true" data-errors-position="outside" data-allowed-file-extensions="jpeg png jpg svg" data-min-file-size-preview="1M" data-max-file-size-preview="3M" accept="image/jpeg, image/png, image/jpg,image/svg">
                <span wire:loading wire:target="image">
                    <i class="fa fa-solid fa-spinner fa-spin" aria-hidden="true"></i> {{__('global.loading')}}
                </span>
            </div>
            @if($errors->has('image'))
            <span class="error text-danger">
                {{ $errors->first('image') }}
            </span>
            @endif
        </div>
    </div>

    <!-- add button for button title and link -->
    <div class="row mb-2">
        <div class="col-md-10"></div>
        <div class="col-md-2">
            <button type="button" wire:click="addMore" wire:loading.attr="disabled" class="btn btn-primary mr-2">
                {{ __('global.add_more') }} 
                <span wire:loading wire:target="addMore">
                    <i class="fa fa-solid fa-spinner fa-spin" aria-hidden="true"></i>
                </span>
            </button>
        </div>

    </div>

    @if($showAddMore)
    @foreach($button as $index=> $btn)
    <div class="row" wire:key="{{ $index }}">
        <div class="col-md-4">
            <div class="form-group">
                <label class="font-weight-bold justify-content-start">{{ __('cruds.pages.fields.button')}}</label>
                <input type="text" class="form-control" wire:model.defer="button.{{$index}}.title" placeholder="{{ __('cruds.pages.fields.button')}}" autocomplete="off">
                @error("button.$index.title") <span class="error text-danger">{{ $message }}</span>@enderror
            </div>
        </div>
        <div class="col-md-7">
            <div class="form-group">
                <label class="font-weight-bold justify-content-start">{{ __('cruds.pages.fields.link')}}</label>
                <input type="text" class="form-control" wire:model.defer="button.{{ $index }}.link" placeholder="{{ __('cruds.pages.fields.link')}}" autocomplete="off">
                @error("button.$index.link") <span class="error text-danger">{{ $message }}</span>@enderror
            </div>
        </div>

        <div class="col-md-1 mt-5">
           
            <button type="button" wire:click="remove({{ $index }})" wire:loading.attr="disabled" class="btn btn-danger"><i class="fas fa-subtract"></i>
            </button>
            
        </div>


    </div>
    @endforeach
    @endif
    <!-- end add button for button title and link -->



    {{-- <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label class="font-weight-bold">{{__('global.status')}}</label>
    <div class="form-group">
        <label class="toggle-switch">
            <input type="checkbox" class="toggleSwitch" wire:change.prevent="changeStatus({{$status}})" value="{{ $status }}" {{ $status ==1 ? 'checked' : '' }}>
            <span class="switch-slider"></span>
        </label>
    </div>
    @error('state.status') <span class="error text-danger">{{ $message }}</span>@enderror
    </div>
    </div>
    </div> --}}

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
</form>