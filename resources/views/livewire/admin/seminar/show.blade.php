<div>
   
    <h4 class="card-title">@lang('global.view') @lang('cruds.seminar.title_singular')</h4>
    
        <div class="form-group row">
            <label class="col-sm-3 col-form-label font-weight-bold">@lang('global.image')</label>
            <div class="col-sm-9 col-form-label">
                <img class="rounded img-thumbnail" src="{{ $detail->image_url ? $detail->image_url : asset(config('constants.default_user_logo')) }}" width="100px"/>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-3 col-form-label font-weight-bold">@lang('cruds.seminar.fields.title')</label>
            <div class="col-sm-9 col-form-label">
                 {{ ucwords($detail->title) }}
            </div>
        </div>

    
        <div class="form-group row">
            <label class="col-sm-3 col-form-label font-weight-bold">@lang('cruds.seminar.fields.date')</label>
            <div class="col-sm-9 col-form-label">
                {{ convertDateTimeFormat($detail->date,'date') }}
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-3 col-form-label font-weight-bold">@lang('cruds.seminar.fields.time')</label>
            <div class="col-sm-9 col-form-label">
                {{-- \Carbon\Carbon::parse($detail->time)->format('H:i A') --}}
                {{ \Carbon\Carbon::createFromFormat('H:i:s', $detail->time)->format('h:i A') }}
            </div>
        </div>
    
        <div class="form-group row">
            <label class="col-sm-3 col-form-label font-weight-bold">@lang('cruds.seminar.fields.venue')</label>
            <div class="col-sm-9 col-form-label">
                {!! $detail->venue !!}
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
    