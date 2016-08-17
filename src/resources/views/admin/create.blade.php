@extends('core::admin.master')

@section('title', trans('banners::global.New'))

@section('main')

    @include('core::admin._button-back', ['module' => 'banners'])
    <h1>
        @lang('banners::global.New')
    </h1>

    {!! BootForm::open()->action(route('admin::index-banners'))->multipart()->role('form') !!}
        @include('banners::admin._form')
    {!! BootForm::close() !!}

@endsection
