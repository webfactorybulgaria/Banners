@extends('core::admin.master')

@section('title', trans('bannerplaces::global.New'))

@section('main')

    @include('core::admin._button-back', ['module' => 'bannerplaces'])
    <h1>
        @lang('bannerplaces::global.New')
    </h1>

    {!! BootForm::open()->action(route('admin::index-bannerplaces'))->multipart()->role('form') !!}
        @include('banners::admin._bannerplace-form')
    {!! BootForm::close() !!}

@endsection
