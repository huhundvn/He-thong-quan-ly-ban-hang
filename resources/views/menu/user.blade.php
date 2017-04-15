@extends('layouts.app')

@section('title')
    Nhân viên
@endsection

@section('location')
    <li> Nhân viên </li>
@endsection

@section('content')
    <div class="list-group">
        <a href="{{route('list-user')}}" class="list-group-item"> Quản lý nhân viên</a>
        <a href="{{route('list-position')}}" class="list-group-item"> Quản lý chức vụ </a>
    </div>
@endsection