@extends('Dashboard.Header')

@if (session()->has('update'))
    <script>alert("{{ session('update') }}")</script>
@endif

@if (session()->has('delete'))
    <script>alert("{{ session('delete') }}")</script>
@endif

@if (session()->has('success'))
    <script>alert("{{ session('success') }}")</script>
@endif

@section('container')
<div class="main-content">
    <div class="header-content">
        
    </div>

    <div class="isi-content">
        <div class="card" style="border: none;">
            <div class="card-header" style="background-color: none;">
                <!-- Menu Button of Tambah Akun -->
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahakun">Tambah Akun</button>
                
                <!-- Modal Tambah Akun -->
                <div class="modal fade" id="tambahakun" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Tambah Akun</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('simpan-akun') }}" method="POST" enctype="multipart/form-data">
                                    @csrf

                                    <div class="form-outline mb-2">
                                        <label class="form-label" for="name">Full name</label>
                                        <input type="text" id="name" name="name" value="{{ Session::get('name') }}" class="form-control form-control-lg"/>
                                        @error('name')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-outline mb-2">
                                        <label class="form-label">Pilih Jabatan</label>
                                        <select class="form-select form-control form-control-lg" aria-label="Default select example" name="jabatan_id" value="{{ Session::get('jabatan') }}">
                                            @foreach ($jabatan as $key)
                                                <option value="{{ $key->id }}">{{ $key->jabatan }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-outline mb-2">
                                        <label class="form-label" for="email">Email address</label>
                                        <input type="text" id="email" name="email" value="{{ Session::get('email') }}" class="form-control form-control-lg"/>
                                        @error('email')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror	
                                    </div>

                                    <div class="form-outline mb-2">
                                        <label class="form-label" for="password">Password</label>
                                        <input type="password" id="password" name="password" class="form-control form-control-lg"/>
                                        @error('password')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror	
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Save changes</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End of Modal Tambah Akun -->
            </div>

            <div class="card-body">
                <!-- Table data Akun User -->
                <table id ="dataTables" class="display nowrap">
                    <thead>
                        <tr>
                            <th style="width: 425px;">Nama</th>
                            <th style="width: 425px;">Email</th>
                            <th>Jabatan</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @for ($i=1; $i < count($akun); $i++)
                            <tr>
                                <td>{{ $akun[$i]->name }}</td>
                                <td>{{ $akun[$i]->email }}</td>
                                <td>{{ $akun[$i]->jabatan->jabatan }}</td>
                                <td>
                                    <!-- Button Edit Akun User -->
                                    <button data-bs-toggle="modal" data-bs-target="#edit-data{{ $akun[$i]->id }}" style="border: none"><img src=" {{ asset('image/edit.png') }} " alt="" style="width: 25px; height: 25px"></button> |
                                    
                                    <!-- Button Hapus Akun User -->
                                    <a href="/akun/hapus/{{ $akun[$i]->id }}"><img src=" {{ asset('image/delete.png') }} " alt="" style="width: 25px; height: 25px"></a>

                                    <!-- Modal Edit Akun User -->
                                    <div class="modal fade" id="edit-data{{ $akun[$i]->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Edit Data</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="/akun/update/{{ $akun[$i]->id }}" method="POST" enctype="multipart/form-data">
                                                        @csrf
                                                        <div style="margin-right: 15px;">
                                                            <div class="mb-3">
                                                                <label for="recipient-name" class="col-form-label">Nama</label>
                                                                <input type="text" class="form-control" name="name" value="{{ $akun[$i]->name }}">
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label" for="email">Pilih Jabatan</label>
                                                                <select class="form-select form-control form-control-lg" aria-label="Default select example" name="jabatan_id" value="{{ $akun[$i]->id }}" required>
                                                                @foreach ($jabatan as $key)
                                                                    <option value="{{ $key->id }}">{{ $key->jabatan }}</option>
                                                                @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="recipient-name" class="col-form-label">Email</label>
                                                                <input type="text" class="form-control" name="email" value="{{ $akun[$i]->email }}" readonly>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="recipient-name" class="col-form-label">Password</label>
                                                                <input type="text" class="form-control" name="password" required>
                                                            </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="submit" class="btn btn-primary">Save</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End of Modal Edit Akun User -->
                                </td>
                            </tr>
                        @endfor
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection()