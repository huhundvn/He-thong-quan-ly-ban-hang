@extends('layouts.app')

@section('title')
    Sản phẩm
@endsection

@section('location')
    <li> Sản phẩm </li>
@endsection

@section('content')
    <div class="list-group">
        <a href="{{route('list-product')}}" class="list-group-item"> Danh sách sản phẩm </a>
        <a href="{{route('list-category')}}" class="list-group-item"> Nhóm sản phẩm </a>
    </div>

    <div class="list-group">
        <a href="{{route('list-attribute')}}" class="list-group-item"> Thuộc tính sản phẩm </a>
        <a href="{{route('list-unit')}}" class="list-group-item"> Đơn vị tính </a>
    </div>
@endsection