@extends('errors::minimal')

@section('title', __('Sin Servicio'))
@section('code', '503')
@section('message', __($exception->getMessage() ?: 'Sin Servicio'))
