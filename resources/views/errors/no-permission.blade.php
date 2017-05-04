@extends('layouts.app')

@section('title')
    Không có quyền truy cập
@endsection

@section('content')
    <h1 align="center">
        Chức vụ hiện tại không có quyền truy cập vào chức năng này
    </h1>
    <h3 align="center">
        Vui lòng liên hệ quản trị để được cấp thêm quyền <br/>
    </h3>
    <hr/>
    <p align="center"> <a href="{{ route('home') }}" class="btn btn-success"> Trang chủ </a> </p>
@endsection