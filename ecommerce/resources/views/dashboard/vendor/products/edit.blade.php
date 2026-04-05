@extends('layouts.app')
@section('content')
@include('dashboard.vendor.products.form',['action'=>route('vendor.products.update',$product),'method'=>'PUT','product'=>$product,'categories'=>$categories])
@endsection
