@section('js')
    <script src="{{ asset('components/ckeditor/ckeditor.js') }}"></script>
@endsection

@include('core::admin._buttons-form')

{!! BootForm::hidden('id') !!}

<div class="row">
    <div class="col-md-6">
        {!! BootForm::text(trans('validation.attributes.title'), 'title') !!}
    </div>
    <div class="col-sm-6">

        <div class="form-group @if($errors->has('slug'))has-error @endif">
            {!! Form::label('<span>'.trans('validation.attributes.slug').'</span>')->addClass('control-label')->forId('slug') !!}
            <span></span>
            <div class="input-group">
                {!! Form::text('slug')->addClass('form-control')->id('slug')->data('slug', 'title') !!}
                <span class="input-group-btn">
                    <button class="btn btn-default btn-slug @if($errors->has('slug'))btn-danger @endif" type="button">@lang('validation.attributes.generate')</button>
                </span>
            </div>
            {!! $errors->first('slug', '<p class="help-block">:message</p>') !!}
        </div>


    </div>
</div>

{!! BootForm::hidden('status')->value(0) !!}
{!! BootForm::checkbox(trans('validation.attributes.online'), 'status') !!}
