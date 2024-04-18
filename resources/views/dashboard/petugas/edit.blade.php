@extends('layouts.app')
@push('style')
    <link rel="stylesheet" href="{{ asset('datatables\datatables.css') }}">
    <link rel="stylesheet" href="{{ asset('sweetalert2.min\sweetalert2.min.css') }}">
@endpush
@section('content')
    <div class="container-fluid">
        <div class="">
            <h2>Edit Petugas</h2>
            <p class="">
                <a href="{{ route('home') }}" class="link-underline-secondary text-dark">Dashboard</a> / <a
                    href="{{ route('managemenPetugas') }}" class="link-underline-secondary text-dark">Manamegemen Petugas</a>
                / <a href="#" class="link-underline-secondary text-dark">Edit Petugas</a>
            </p>
        </div>
        <div class="card">
            <form action="{{ route('updatePetugas', [Crypt::encrypt($petugas->id)]) }}" method="POST"
                enctype="multipart/form-data">
                <div class="row p-2">
                    @csrf
                    <div class="mb-3 col-6">
                        <label for="kategoru">Nama Petugas</label>
                        <input type="text" name="nama" class="form-control" value="{{ $petugas->name }}"
                            placeholder="Luthfi">
                    </div>
                    <div class="mb-3 col-6">
                        <label for="gambar">username</label>
                        <input type="text" name="username" value="{{ $petugas->username }}" class="form-control"
                            placeholder="luthfi" id="">
                    </div>
                    <div class="mb-3 col-6">
                        <label for="gambar">email</label>
                        <input type="email" value="{{ $petugas->email }}" name="email" class="form-control"
                            placeholder="contoh@gmail.com" id="">
                    </div>
                    <div class="mb-3 col-6">
                        <label for="gambar">Tahun & Tanggal Lahir</label>
                        <input type="date" value="{{ $petugas->tgl_lahir }}" name="tglLahir" class="form-control"
                            id="">
                    </div>
                    <div class="mb-3 col-6">
                        <label for="gambar">password <small class="text-danger">*Diisi Saat Ingin Mengubah Password
                                Saja</small></label>
                        <input type="password" name="password" class="form-control" placeholder="******" id="">
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary col-12">Tambah</button>

                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@push('script')
    <script src="{{ asset('jquey/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('datatables/datatables.js') }}"></script>
    <script src="{{ asset('sweetalert2.min\sweetalert2.min.js') }}"></script>
@endpush
