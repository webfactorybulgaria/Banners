@section('js')
    <script src="{{ asset('components/ckeditor/ckeditor.js') }}"></script>
@endsection

@include('core::admin._buttons-form')

{!! BootForm::hidden('id') !!}

@include('core::admin._image-fieldset', ['field' => 'image'])

{!! BootForm::select(trans('banners::global.Bannerplace'), 'bannerplace_id', Bannerplaces::allForSelect()) !!}
{!! TranslatableBootForm::text(trans('validation.attributes.title'), 'title') !!}
{!! TranslatableBootForm::text(trans('banners::global.Link'), 'link') !!}
{!! TranslatableBootForm::hidden('status')->value(0) !!}
{!! TranslatableBootForm::checkbox(trans('validation.attributes.online'), 'status') !!}
{!! TranslatableBootForm::textarea(trans('validation.attributes.summary'), 'summary')->rows(4) !!}
{!! TranslatableBootForm::textarea(trans('validation.attributes.body'), 'body')->addClass('ckeditor') !!}

<label class="control-label"><span>@lang('banners::global.Select Pages')</span></label>
{!! BootForm::select('', 'all_pages', [
    1 => trans('banners::global.All pages except'),
    0 => trans('banners::global.Only on pages'),
]) !!}

{{--
We need an empty element to allow to deselect all items
and have a galleries key in the post data
--}}
{!! BootForm::hidden('pages')->value('') !!}
@foreach(Pages::allForSelect() as $key => $page)
    @if(!empty($key))
        {!! BootForm::checkbox($page, 'pages['.$key.']')->value($key)->{$model->pages->contains($key) ? 'check' : 'uncheck'}() !!}
    @endif
@endforeach
