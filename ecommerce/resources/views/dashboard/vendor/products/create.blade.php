@extends('layouts.app')
@section('content')@include('dashboard.vendor.products.form',['action'=>route('vendor.products.store'),'method'=>'POST','product'=>null])@endsection
