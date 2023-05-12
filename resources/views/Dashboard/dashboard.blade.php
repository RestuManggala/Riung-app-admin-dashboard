@extends('Dashboard.Header')

@section('container')
            <div class="main-content">
                <div class="header-content">

                </div>
                <div class="isi-content">
                    <h1>Hello <span style="color: rgb(255, 0, 0);">{{ $username }}</span> </br></br> Selamat Datang di Dashboard Admin</h1>
                </div>
            </div>
@endsection()