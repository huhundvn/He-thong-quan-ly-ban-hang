@extends('layouts.app')

@section('title')
    Báo cáo nhập kho
@endsection

@section('location')
    <li> Báo cáo </li>
    <li> Báo cáo nhập kho </li>
@endsection

@section('content')
    <div ng-controller="ReportController">
        <div class="row">

        </div>
    </div>
@endsection

{{-- !ANGULARJS! --}}
@section('script')
    <script src="{{ asset('angularJS/ReportController.js') }}"></script>
@endsection