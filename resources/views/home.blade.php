@extends('layouts.master')

@section('title', 'Trang chủ')

@section('content')
    <div class="container">
        <div class="row justify-content-center align-items-center">
            <div class="col-md-6">
                <img type="image" class="img-fluid object-fit-cover" src="{{ asset('general/images/home/1.jpeg')}} " alt="">
            </div>
        </div>
    </div>
@endsection