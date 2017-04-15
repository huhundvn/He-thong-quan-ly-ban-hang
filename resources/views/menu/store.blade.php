@extends('layouts.app')

@section('title')
    Kho
@endsection

@section('location')
    <li> Kho </li>
@endsection

@section('content')
    <div class="list-group">
        <a href="{{route('list-store')}}" class="list-group-item"> Danh sách kho/cửa hàng </a>
    </div>
    <div class="list-group">
        <a href="" class="list-group-item"> Nhập kho </a>
        <a href="#" class="list-group-item"> Xuất kho </a>
    </div>
    <div class="list-group">
        <a href="#" class="list-group-item"> Điều chỉnh kho </a>
        <a href="#" class="list-group-item"> Chuyển kho </a>
    </div>

    <div class="list-group">
        <a href="{{route('list-manufacturer')}}" class="list-group-item"> Nhà sản xuất </a>
        <a href="{{route('list-supplier')}}" class="list-group-item"> Nhà cung cấp </a>
    </div>
@endsection