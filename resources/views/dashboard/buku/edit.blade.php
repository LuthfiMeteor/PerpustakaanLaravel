@extends('layouts.app')
@push('style')
    <link rel="stylesheet" href="{{ asset('datatables\datatables.css') }}">
    <link rel="stylesheet" href="{{ asset('sweetalert2.min\sweetalert2.min.css') }}">
@endpush
@section('content')
    <div class="container-fluid">
        <div class="">
            <h2>Edit Buku</h2>
            <p><a href="{{ route('home') }}" class="link-underline-secondary text-dark">Dashboard </a>/
                <a href="{{ route('managemenBuku') }}" class="text-dark link-underline-secondary">Managemen Buku</a> / <a
                    href="" class="text-dark link-underline-secondary">edit Buku</a>
            </p>
        </div>
        <div class="card">
            <form action="{{ route('updateBuku', $buku->id) }}" method="POST" enctype="multipart/form-data">
                <div class="row p-2">
                    @csrf
                    <div class="mb-3 col-6">
                        <label for="kategoru">Judul</label>
                        <input type="text" name="judul" value="{{ $buku->judul }}" class="form-control">
                    </div>
                    <div class="mb-3 col-6">
                        <label for="">Deskripsi</label>
                        <textarea name="deskripsi" id="editor" cols="30" rows="10">{{ $buku->deskripsi }}</textarea>
                    </div>
                    <div class="mb-3 col-6">
                        <label for="kategori">kategori</label>
                        <select name="kategori" id="" class="form-select">
                            <option value="">Pilih Kategori</option>
                            @foreach ($kategori as $item)
                                <option value="{{ $item->id }}" {{ $buku->kategori == $item->id ? 'selected' : '' }}>
                                    {{ $item->kategori }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3 col-6">
                        <label for="gambar">Gambar Cover <small class="text-danger">*di isi saat ingin update cover
                                saja</small>
                            <br><a target="_blank" href="{{ asset('storage/uploads/cover/' . $buku->gambarCover) }}"><small
                                    class="text-primary link-underline-primary">Cover Saat
                                    Ini</small></a></label>
                        <input type="file" name="gambarCover" class="form-control" id="">
                    </div>
                    <div class="mb-3 col-6">
                        <label for="gambar">File Isi Buku <small class="text-danger">*di isi saat ingin update Isi buku
                                saja</small>
                            <br><a target="_blank" href="{{ asset('storage/uploads/isiBuku/' . $buku->isiBuku) }}"><small
                                    class="text-primary link-underline-primary">Isi
                                    Buku Saat
                                    Ini</small></a></label>
                        <input type="file" name="isiBuku" class="form-control" id="">
                    </div>
                    <div class="mb-3 col-6">
                        <label for="gambar">Penulis</label>
                        <input type="text" name="penulis" value="{{ $buku->penulis }}" class="form-control"
                            id="">
                    </div>
                    <div class="mb-3 col-6">
                        <label for="gambar">Penerbit</label>
                        <input type="text" value="{{ $buku->penerbit }}" name="penerbit" class="form-control"
                            id="">
                    </div>
                    <div class="mb-3 col-6">
                        <label for="gambar">Tahun Terbit</label>
                        <input type="date" name="tahunTerbit" value="{{ $buku->tahunTerbit }}" class="form-control"
                            id="">
                    </div>
                </div>
                <button type="submit" class="btn btn-primary col-12 ">edit</button>
            </form>
        </div>
    </div>
@endsection
@push('script')
    <script src="{{ asset('jquey/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('datatables/datatables.js') }}"></script>
    <script src="{{ asset('sweetalert2.min\sweetalert2.min.js') }}"></script>
    <script src="{{ asset('ckeditor5-build-classic/ckeditor.js') }}"></script>
    <script>
        ClassicEditor
            .create(document.querySelector('#editor'))
            .catch(error => {
                console.error(error);
            });
    </script>
@endpush
