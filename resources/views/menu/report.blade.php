@extends('layouts.app')

@section('title')
    Báo cáo
@endsection

@section('location')
    <li> Báo cáo </li>
@endsection

@section('content')
    <div class="list-group">
        <a href="" class="list-group-item w3-blue-grey"> Doanh thu bán hàng </a>
        <a href="#" class="list-group-item"> Doanh thu theo sản phẩm </a>
        <a href="#" class="list-group-item"> Doanh thu theo nhân viên bán hàng </a>
        <a href="#" class="list-group-item"> Doanh thu tổng hợp </a>
    </div>

    <div class="list-group">
        <a href="" class="list-group-item w3-blue-grey"> Kho hàng</a>
        <a href="#" class="list-group-item"> Bảng kê nhập kho </a>
        <a href="#" class="list-group-item"> Bảng kê xuất kho </a>
        <a href="#" class="list-group-item"> Bảng kê tồn kho </a>
    </div>
@endsection