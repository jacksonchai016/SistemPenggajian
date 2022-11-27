@extends('layouts.main')
@section('title', 'Web Programing UPH')
<nav class="navbar navbar-expand-lg bg-light">
    <div class="container">              
      <a class="navbar-brand" href="#">Home</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="{{url('/')}}"><strong>Home</strong></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{url('/about')}}">About</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{url('/sistem')}}">Sistem Penggajian</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{url('/attendance')}}">Attendance</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{url('/kontrak')}}">Kontrak</a>
          </li>
          
        </ul>
    </div>
    </div>
    </nav>

@section('container')
    <div class="container">
        <div class="row">
            <div class="col-10">
                <h1 class="mt-3">Selamat datang di Website Kami !</h1>
            </div>
        </div>
    </div>
@endsection

    
  