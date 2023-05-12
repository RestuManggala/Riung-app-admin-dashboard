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
        <div class="card">
            <div class="card-header" style="display: flex; justify-content: flex-warp; gap: 10px;">
                <!-- Menu button tambah data -->
                <div class="dropdown">
                    <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                        Tambah Data
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                        <!-- Trigger Modal Tambah Manual -->
                        <li><button class="dropdown-item btn" data-bs-toggle="modal" data-bs-target="#tambahmanual">Manual</button></li>
                        <!-- Trigger Modal Tambah Import -->
                        <li><button class="dropdown-item btn" data-bs-toggle="modal" data-bs-target="#importdata">Import Excel</button></li>
                    </ul>
                </div>
                <!--End of Menu button tambah data -->

                <!-- Menu button Show data Category -->
                <!-- <div class="dropdown">
                    <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                        Show Category
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                        <li><a href="" class="dropdown-item btn">Show All</a></li>
                        @foreach ($rekening as $key)
                        <li><a href="" class="dropdown-item btn">{{ $key->kode_rekening }}</a></li>
                        @endforeach
                    </ul>
                </div> -->
                <!-- End of Menu button Show data Category -->

                <!-- Export Button -->
                <div class="dropdown">
                    <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                        Export Data
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                        <li><a href="{{ route('export-excel') }}" class="dropdown-item btn">Export All</a></li>
                        @foreach ($rekening as $key)
                        <li><a href="/laporan/export-category/{{ $key->id }}" class="dropdown-item btn">{{ $key->kode_rekening }}</a></li>
                        @endforeach
                    </ul>
                </div>
                <!-- End of Export Button -->

                <!-- Modal Tambah Manual -->
                <div class="modal fade" id="tambahmanual" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Tambah Data Manual</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('simpan-data') }}" method="POST" class="form-controls" enctype="multipart/form-data">
                                    @csrf
                                    <div class="mb-3">
                                        <label class="form-label" for="email">Pilih Bank</label>
                                        <select class="form-select form-control form-control-lg" aria-label="Default select example" name="kode_rekening">
                                            @foreach ($rekening as $key)
                                                <option value="{{ $key->id }}">{{ $key->kode_rekening }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-grup mb-3">
                                        <label class="form-label" for="tanggal">Tanggal</label>
                                        <input type="date" class="kolom-input form-control" id="tanggal" name="tanggal">
                                    </div>
                                    <div class="form-grup mb-3">
                                        <label class="form-label" for="rincian_transaksi">Rincian Transaksi</label>
                                        <input type="text" autofocus class="kolom-input form-control
                                        @error('rincian_transaksi')
                                        is-invalid
                                        @enderror" id="rincian_transaksi" name="rincian_transaksi" value="{{ old('rincian_transaksi') }}">
                                        @error('rincian_transaksi')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="form-grup mb-3">
                                        <label class="form-label" for="debit">Debit</label>
                                        <input type="text" class="kolom-input form-control
                                        @error('debit')
                                        is-invalid
                                        @enderror" id="debit" name="debit" value="{{ old('debit') }}">
                                        @error('debit')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="form-grup mb-3">
                                        <label class="form-label" for="kredit">Kredit</label>
                                        <input type="text" class="kolom-input form-control
                                        @error('kredit')
                                        is-invalid
                                        @enderror" id="kredit" name="kredit" value="{{ old('kredit') }}">
                                        @error('kredit')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="form-grup mb-3">
                                        <label class="form-label" for="no_dokumen">No. Dokumen</label>
                                        <input type="text" class="kolom-input form-control
                                        @error('no_dokumen')
                                        is-invalid
                                        @enderror" id="no_dokumen" name="no_dokumen" value="{{ old('no_dokumen') }}">
                                        @error('no_dokumen')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="form-grup mb-3">
                                        <label class="form-label" for="analisis_input">Analisis Input</label>
                                        <input type="text" class="kolom-input form-control
                                        @error('analisis_input')
                                        is-invalid
                                        @enderror" id="analisis_input" name="analisis_input" value="{{ old('analisis_input') }}">
                                        @error('analisis_input')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
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
                <!-- End of Modal Tambah Manual -->

                <!-- Modal Tambah Import Data -->
                <div class="modal fade" id="importdata" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Import Excel</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <h5>Gunakan template ini untuk import data! <br><a href="{{ route('template-download') }}" style="color: blue;">Download here</a></h5>
                                <hr>
                                <form action="{{ route('simpan-excel') }}" class="form-controls" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="mb-3">
                                        <label class="form-label" for="email">Pilih Bank</label>
                                        <select class="form-select form-control form-control-lg" aria-label="Default select example" name="kode_rekening" required>
                                            @foreach ($rekening as $key)
                                            <option value="{{ $key->id }}">{{ $key->kode_rekening }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-grup excel">
                                        <label class="form-label">Pilih Berkas :</label>
                                        <input type="file" name="file_excel">
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
                <!-- End of Modal Tambah Manual -->
            </div>

            <div class="card-body">
                <!-- Table Data Laporan -->
                <table id="dataTables" class="display nowrap">
                    <thead>
                        <tr>
                            <th style="width: 65px">Nama Bank</th>
                            <th style="width: 65px">Tanggal</th>
                            <th style="width: 440px">Rincian Transaksi</th>
                            <th style="width: 45px">Kredit</th>
                            <th style="width: 45px">Debit</th>
                            <th style="width: 100px">No. Dokumen</th>
                            <th style="width: 100px">Analisis Input</th>
                            @if ($id == 1)
                            <th style="width: 100px">User</th>
                            @endif
                            <th style="width: 100px">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($laporan as $key)
                        <tr>
                            <td>{{ $key->rekeningKoran->kode_rekening }}</td>
                            <td>{{ $key->tanggal }}</td>
                            <td>{{ $key->rincian_transaksi }}</td>
                            <td>{{ $key->kredit }}</td>
                            <td>{{ $key->debit }}</td>
                            <td>{{ $key->no_dokumen }}</td>
                            <td>{{ $key->analisis_input }}</td>
                            @if ($id == 1)
                            <td>{{ $key->user->name }}</td>
                            @endif
                            <td>
                                <!-- Button Edit data -->
                                <button data-bs-toggle="modal" data-bs-target="#edit-data{{ $key->id }}" style="border: none;"><img src=" {{ asset('image/edit.png') }} " alt="" style="width: 25px; height: 25px"></button> |

                                <!-- Button Hapus data -->
                                <a href="/laporan/hapus/{{ $key->id }}"><img src=" {{ asset('image/delete.png') }} " alt="" style="width: 25px; height: 25px"></a>

                                <!-- Modal Edit data -->
                                <div class="modal fade" id="edit-data{{ $key->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Edit Data</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="/laporan/update/{{ $key->id }}" method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    <div style="margin-right: 15px;">
                                                        <div class="mb-3">
                                                            <label class="form-label" for="email">Pilih Bank</label>
                                                            <select class="form-select form-control form-control-lg" aria-label="Default select example" name="kode_rekening" required>
                                                                @foreach ($rekening as $value)
                                                                <option value="{{ $value->id }}">{{ $value->kode_rekening }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="form-grup mb-3">
                                                            <label for="tanggal" class="col-form-label">Tanggal</label>
                                                            <input type="date" class="form-control" id="tanggal" name="tanggal" value="{{ old('tanggal') ? old('tanggal') : $key->tanggal }}" style="width: auto; display: flex; flex-direction: row;">
                                                        </div>
                                                        <div class="form-grup mb-3">
                                                            <label for="rincian" class="col-form-label">Rincian Transaksi</label>
                                                            <input type="text" class="form-control
                                                            @error('rincian_transaksi')
                                                            is-invalid
                                                            @enderror" id="rincian_transaksi" name="rincian_transaksi" value="{{ old('rincian_transaksi') ? old('rincian_transaksi') : $key->rincian_transaksi }}">
                                                            @error('rincian_transaksi')
                                                                <div class="invalid-feedback">
                                                                    {{ $message }}
                                                                </div>
                                                            @enderror
                                                        </div>
                                                        <div class="form-grup mb-3">
                                                            <label for="kredit" class="col-form-label">Kredit</label>
                                                            <input type="text" class="form-control
                                                            @error('kredit')
                                                            is-invalid
                                                            @enderror" id="kredit" name="kredit" value="{{ old('kredit') ? old('kredit') : $key->kredit }}">
                                                            @error('kredit')
                                                                <div class="invalid-feedback">
                                                                    {{ $message }}
                                                                </div>
                                                            @enderror
                                                        </div>
                                                        <div class="form-grup mb-3">
                                                            <label for="debit" class="col-form-label">Debit</label>
                                                            <input type="text" class="form-control 
                                                            @error('debit')
                                                            is-invalid
                                                            @enderror" id="debit" name="debit" value="{{ old('debit') ? old('debit') : $key->debit }}">
                                                            @error('debit')
                                                                <div class="invalid-feedback">
                                                                    {{ $message }}
                                                                </div>
                                                            @enderror
                                                        </div>
                                                        <div class="form-grup mb-3">
                                                            <label for="dokumen" class="col-form-label">No. Dokumen</label>
                                                            <input type="text" class="form-control
                                                            @error('no_dokumen')
                                                            is-invalid
                                                            @enderror" id="no_dokumen" name="no_dokumen" value="{{ old('no_dokumen') ? old('no_dokumen') : $key->no_dokumen }}">
                                                            @error('no_dokumen')
                                                                <div class="invalid-feedback">
                                                                    {{ $message }}
                                                                </div>
                                                            @enderror
                                                        </div>
                                                        <div class="form-grup mb-3">
                                                            <label for="analisis" class="col-form-label">Analisis Input</label>
                                                            <input type="text" class="form-control
                                                            @error('analisis_input')
                                                            is-invalid
                                                            @enderror" id="analisis_input" name="analisis_input" value="{{ old('analisis_input') ? old('analisis_input') : $key->analisis_input }}">
                                                            @error('analisis_input')
                                                                <div class="invalid-feedback">
                                                                    {{ $message }}
                                                                </div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-primary">Save</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- End of Modal Edit data -->
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