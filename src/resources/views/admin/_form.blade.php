@section('js')
    <script src="{{ asset('components/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('js/admin/form.js') }}"></script>
@endsection

@include('core::admin._buttons-form')

{!! BootForm::hidden('id') !!}

@include('core::admin._image-fieldset', ['field' => 'image'])

{!! BootForm::select(trans('validation.attributes.bannerplace'), 'bannerplace_id', Bannerplaces::allForSelect()) !!}
{!! TranslatableBootForm::text(trans('validation.attributes.title'), 'title') !!}
{!! TranslatableBootForm::text(trans('validation.attributes.link'), 'link') !!}
{!! TranslatableBootForm::hidden('status')->value(0) !!}
{!! TranslatableBootForm::checkbox(trans('validation.attributes.online'), 'status') !!}
{!! TranslatableBootForm::textarea(trans('validation.attributes.summary'), 'summary')->rows(4) !!}
{!! TranslatableBootForm::textarea(trans('validation.attributes.body'), 'body')->addClass('ckeditor') !!}

<!-- <div class="row">
    <div class="col-sm-12">
        <label class="control-label"><span>@lang('banners::global.Assign')</span></label>
    </div>
    <div class="col-sm-3">
        {!! BootForm::radio(trans('banners::global.show_on_checked'), 'show_on_pages', 'checked') !!}
    </div>
    <div class="col-sm-9">
        {!! BootForm::radio(trans('banners::global.show_on_unchecked'), 'show_on_pages', 'unchecked') !!}
    </div>
</div> -->

<label class="control-label"><span>@lang('banners::global.Select')</span></label>
@foreach(Pages::allForSelect() as $key => $page)
    @if(!empty($key))
        {!! BootForm::checkbox($page, 'pages['.$key.']')->value($key)->{$model->pages->contains($key) ? 'check' : 'uncheck'}() !!}
    @endif
@endforeach
