<div>

    <h4 class="card-title">@lang('global.view') @lang('cruds.title_singular.title_singular')</h4>

    <div class="form-group row">
        <label class="col-sm-3 col-form-label font-weight-bold">@lang('cruds.user.fields.full_name')</label>
        <div class="col-sm-9 col-form-label">
            {{ ucwords($detail->first_name) }} {{ ucwords($detail->last_name) }}
        </div>
    </div>


    <div class="form-group row">
        <label class="col-sm-3 col-form-label font-weight-bold">@lang('cruds.user.fields.phone')</label>
        <div class="col-sm-9 col-form-label">
            {{ $detail->phone }}
        </div>
    </div>

    <div class="form-group row">
        <label class="col-sm-3 col-form-label font-weight-bold">@lang('cruds.user.fields.email')</label>
        <div class="col-sm-9 col-form-label">
            {{ $detail->email }}
        </div>
    </div>


    <div class="form-group row">
        <label class="col-sm-3 col-form-label font-weight-bold">@lang('global.status')</label>
        <div class="col-sm-9 col-form-label">
            @if($detail->status)
            <div class="badge badge-success">@lang('global.active')</div>
            @else
            <div class="badge badge-danger">@lang('global.inactive')</div>
            @endif

        </div>
    </div>

    <button wire:click.prevent="cancel" class="btn btn-secondary">
        {{ __('global.cancel')}}
        <span wire:loading wire:target="cancel">
            <i class="fa fa-solid fa-spinner fa-spin" aria-hidden="true"></i>
        </span>
    </button>

</div>