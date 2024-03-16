@extends('errors::illustrated-layout')

@section('code', '404')
@section('title', __('Page Not Found'))

@section('image')
    <div style="background-image: url({{ asset('/assets_backend/img/logo/ocbd.png') }});" class="absolute pin bg-cover bg-no-repeat md:bg-left lg:bg-center">
    </div>
@endsection

@section('message', __('Maaf link ini tidak ada di system, coba link lain yuk..'))
