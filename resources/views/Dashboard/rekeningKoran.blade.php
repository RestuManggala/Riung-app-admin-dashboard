@extends('Dashboard.Header')

@section('container')
            <div class="main-content">
                <div class="header-content">

                </div>
                <div class="isi-content">
                @if (session()->has('pesan'))
                    <div class="alert alert-success" role="alert">
                        {{ session()->get('pesan') }}
                    </div>
                @endif
                @if (!$errors->isEmpty())
                    <script>
                        alert("Input data tidak lengkap, cek kembali!")
                    </script>
                @endif
                    <div class="card" style="border: none;">
                        <div class="card-header" style="background-color: none;">
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahRekening">Tambah Rekening Koran</button>
                            <div class="modal fade" id="tambahRekening" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Tambah Rekening Koran</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('simpan-rekening') }}" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                <div class="form-outline mb-3">
                                                    <label class="form-label" for="nama_bank">Nama Bank</label>
                                                    <input type="text" id="nama_bank" name="nama_bank" value="{{ old('nama_bank') }}" class="form-control form-control-lg
                                                    @error('nama_bank')
                                                    is-invalid
                                                    @enderror"/>
                                                    @error('nama_bank')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>

                                                <div class="form-outline mb-3">
                                                    <label class="form-label" for="kode_rekening">Nomer Rekening</label>
                                                    <input type="text" id="kode_rekening" name="kode_rekening" value="{{ old('kode_rekening') }}"  class="form-control form-control-lg
                                                    @error('kode_rekening')
                                                    is-invalid
                                                    @enderror"/>
                                                    @error('kode_rekening')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>

                                                <div class="form-outline mb-3 excel">
                                                    <label class="form-label">Pilih Berkas :</label>
                                                    <input type="file" name="pdf">
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

                        </div>
                        <div class="card-body">
                            <table id ="dataTables" >
                                <thead>
                                    <tr>
                                        <th>Nama Bank</th>
                                        <th>Nomer Rekening</thstyle=>
                                        <th>File</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($rekening as $value)
                                        <tr>
                                            <td>{{ $value->nama_bank }}</td>
                                            <td>{{ $value->kode_rekening }}</td>
                                            <td>{{ $value->pdf }}</td>
                                            <td>
                                                <button data-bs-toggle="modal" data-bs-target="#edit-rekening{{ $value->id }}" style="border: none;"><img src=" {{ asset('image/edit.png') }} " alt="" style="width: 25px; height: 25px"></button> |
                                                <a href="/rekening-koran/hapus-rekening/{{ $value->id }}"><img src=" {{ asset('image/delete.png') }} " alt="" style="width: 25px; height: 25px"></a> | 
                                                <a href="/rekening-koran/download-rekening/{{ $value->id }}"><img src=" {{ asset('image/download.png') }} " alt="" style="width: 25px; height: 25px"></a>

                                                <div class="modal fade" id="edit-rekening{{ $value->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLabel">Edit Data</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form action="/rekening-koran/update-rekening/{{ $value->id }}" method="POST" enctype="multipart/form-data">
                                                                    @csrf
                                                                    <input type="hidden" name="fileLama" value="{{ $value->pdf }}">
                                                                    <div style="margin-right: 15px;">
                                                                        <div class="form-outline mb-3">
                                                                            <label class="col-form-label">Nama Bank</label>
                                                                            <input type="text" class="form-control
                                                                            @error('nama_bank')
                                                                            is-invalid
                                                                            @enderror" name="nama_bank" value="{{ old('nama_bank') ? old('nama_bank') : $value->nama_bank }}">
                                                                            @error('nama_bank')
                                                                                <div class="invalid-feedback">
                                                                                    {{ $message }}
                                                                                </div>
                                                                            @enderror
                                                                        </div>
                                                                        <div class="form-outline mb-3">
                                                                            <label class="col-form-label">Nomer Rekening</label>
                                                                            <input type="text" class="form-control
                                                                            @error('kode_rekening')
                                                                            is-invalid
                                                                            @enderror" name="kode_rekening" value="{{ old('kode_rekening') ? old('kode_rekening') : $value->kode_rekening }}">
                                                                            @error('kode_rekening')
                                                                                <div class="invalid-feedback">
                                                                                    {{ $message }}
                                                                                </div>
                                                                            @enderror
                                                                        </div>
                                                                        <div class="form-outline mb-3">
                                                                            <label class="form-label">Pilih Berkas :</label>
                                                                            <input type="file" name="pdf">
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                        <button type="submit" class="btn btn-primary">Save Changes</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
@endsection()