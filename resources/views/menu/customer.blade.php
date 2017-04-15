@extends('layouts.app')

@section('title')
    Khách hàng
@endsection

@section('location')
    <li> Khách hàng </li>
@endsection

@section('content')
<div class="list-group">
    <a href="{{route('list-customer')}}" class="list-group-item"> Thông tin khách hàng </a>
    <a href="{{route('list-customer-group')}}" class="list-group-item"> Nhóm khách hàng </a>
    <a href="" class="list-group-item"> Lịch sử mua hàng </a>
</div>
@endsection