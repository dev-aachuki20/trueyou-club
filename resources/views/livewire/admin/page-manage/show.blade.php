<div>

    <h4 class="card-title">@lang('global.view') {{ ucwords($detail->page_key) }} @lang('cruds.pages.title_singular')</h4>

    <div class="form-group row">
        <label class="col-sm-3 col-form-label font-weight-bold">@lang('global.image')</label>
        <div class="col-sm-9 col-form-label">
            <img class="rounded img-thumbnail" src="{{ $detail->image_url ? $detail->image_url : asset(config('constants.default.no_image')) }}" width="100px" />
        </div>
    </div>

    <div class="form-group row">
        <label class="col-sm-3 col-form-label font-weight-bold">@lang('cruds.pages.fields.title')</label>
        <div class="col-sm-9 col-form-label">
            {{ ucwords($detail->title) }}
        </div>
    </div>


    <div class="form-group row">
        <label class="col-sm-3 col-form-label font-weight-bold">@lang('cruds.pages.fields.subtitle')</label>
        <div class="col-sm-9 col-form-label">
            {!! ucwords($detail->subtitle) !!}
        </div>
    </div>


    <div class="form-group row">
        @if(json_decode($detail->button, true))
        @foreach(json_decode($detail->button, true) as $button)
        <!-- <div class="col-md-6"> -->
        <label class="col-sm-3 col-form-label font-weight-bold">@lang('cruds.pages.fields.button')</label>
        <div class="col-sm-9 col-form-label">{{ $button['title'] }}
        </div>
        <!-- </div> -->
        <!-- <div class="col-md-6"> -->
        <label class="col-sm-3 col-form-label font-weight-bold">@lang('cruds.pages.fields.link')</label>
        <div class="col-sm-9 col-form-label">{{ $button['link'] }}
        </div>
        <!-- </div> -->
        @endforeach
        @endif
    </div>

    {{-- <div class="form-group row">
        <label class="col-sm-3 col-form-label font-weight-bold">@lang('global.status')</label>
        <div class="col-sm-9 col-form-label">
            @if($detail->status)
            <div class="badge badge-success">@lang('global.active')</div>
            @else
            <div class="badge badge-danger">@lang('global.inactive')</div>
            @endif

        </div>
    </div> --}}

    <button wire:click.prevent="cancel" class="btn btn-secondary">
        {{ __('global.cancel')}}
        <span wire:loading wire:target="cancel">
            <i class="fa fa-solid fa-spinner fa-spin" aria-hidden="true"></i>
        </span>
    </button>

</div>