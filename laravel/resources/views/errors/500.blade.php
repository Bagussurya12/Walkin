@extends('errors::illustrated-layout')

@section('code', '500')
@section('title', __('Error'))

@section('image')
    <div style="background-image: url({{ asset('/assets_backend/img/logo/ocbd.png') }});" class="absolute pin bg-cover bg-no-repeat md:bg-left lg:bg-center">
    </div>
@endsection

@section('message', __('Upssss, mungkin ada yang error pada server..'))
