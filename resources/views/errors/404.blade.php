@extends('layouts.app')

@section('title')
    Không tìm thấy trang
@endsection

@section('content')
    <h1 align="center">
        Lỗi 404 <br/>
    </h1>
    <h3 align="center">
        Trang không tồn tại <br/>
        Vui lòng kiểm tra đường dẫn hoặc nhấn (F5) để tải lại trang <br/>
    </h3>
    <hr/>
    <p align="center"> <a href="{{ route('home') }}" class="btn btn-success"> Trang chủ </a> </p>
@endsection