@extends('layouts.app')
@push('style')
    <link rel="stylesheet" href="{{ asset('datatables\datatables.css') }}">
    <link rel="stylesheet" href="{{ asset('sweetalert2.min\sweetalert2.min.css') }}">
@endpush
@section('content')
    <div class="container-fluid">
        <div class="">
            <h2>Managemen Buku</h2>
            <p><a href="{{ route('home') }}" class="link-underline-secondary text-dark">Dashboard </a>/
                <a href="" class="text-dark link-underline-secondary">Managemen Buku</a>
            </p>
        </div>
        @error('gambarCover')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
        @if (session('success'))
            <span class="invalid-feedback" role="alert">
                <strong>BERHASIL</strong>
            </span>
        @endif
        <div class="card">
            <div class="card-header"><button class="btn btn-primary" id="tambahBuku">+</button></div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr class="fw-bold">
                                <td>Judul</td>
                                <td>Kategori</td>
                                <td>Gambar</td>
                                <td>Nama File</td>
                                <td>Penulis</td>
                                <td>Penerbit</td>
                                <td>Tahun Terbit</td>
                                <td>Aksi</td>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Tambah Buku</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('tambahBuku') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="kategoru">Judul</label>
                            <input type="text" name="judul" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="">Deskripsi</label>
                            <textarea name="deskripsi" id="editor" cols="30" rows="10"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="kategori">kategori</label>
                            <select name="kategori" id="" class="form-select">
                                <option value="" selected>Pilih Kategori</option>
                                @foreach ($kategori as $item)
                                    <option value="{{ $item->id }}">{{ $item->kategori }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="gambar">Gambar Cover</label>
                            <input type="file" name="gambarCover" class="form-control" id="">
                        </div>
                        <div class="mb-3">
                            <label for="gambar">File Isi Buku</label>
                            <input type="file" name="isiBuku" class="form-control" id="">
                        </div>
                        <div class="mb-3">
                            <label for="gambar">Penulis</label>
                            <input type="text" name="penulis" class="form-control" id="">
                        </div>
                        <div class="mb-3">
                            <label for="gambar">Penerbit</label>
                            <input type="text" name="penerbit" class="form-control" id="">
                        </div>
                        <div class="mb-3">
                            <label for="gambar">Tahun Terbit</label>
                            <input type="date" name="tahunTerbit" class="form-control" id="">
                        </div>
                        <button type="submit" class="btn btn-primary">Tambah</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="staticBackdrops" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Edit Kategori</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('updateKategori') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <input type="hidden" id="idKategori" name="idKategori">
                            <label for="kategoru">Nama Kategori</label>
                            <input type="text" id="kategoriEdit" name="nama_kategori" class="form-control">
                        </div>
                        <button type="submit" class="btn btn-primary">edit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script src="{{ asset('jquey/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('datatables/datatables.js') }}"></script>
    <script src="{{ asset('sweetalert2.min\sweetalert2.min.js') }}"></script>
    <script src="{{ asset('ckeditor5-build-classic/ckeditor.js') }}"></script>
    <script>
        $(document).ready(function() {
            ClassicEditor
                .create(document.querySelector('#editor'))
                .catch(error => {
                    console.error(error);
                });
            $('.table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ url()->current() }}',
                columns: [{
                    data: 'judul',
                    name: 'judul'
                }, {
                    data: 'kategori',
                    name: 'kategori',
                }, {
                    data: 'gambar',
                    name: 'gambar',
                }, {
                    data: 'file',
                    name: 'file',
                }, {
                    data: 'penulis',
                    name: 'penulis',
                }, {
                    data: 'penerbit',
                    name: 'penerbit',
                }, {
                    data: 'tahunterbit',
                    name: 'tahunterbit',
                }, {
                    data: 'action',
                    name: 'action',
                }]
            });
        });
    </script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('#tambahBuku').click(function() {
            $('#staticBackdrop').modal('show');
        });
        $('.table').on('click', '.deleteBuku', function() {
            const id = $(this).data('id');
            Swal.fire({
                title: "Hapus Buku?",
                text: "Tidak Bisa Dikembalikan!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    // Swal.fire({
                    //     title: "Deleted!",
                    //     text: "Your file has been deleted.",
                    //     icon: "success"
                    // });
                    $.ajax({
                        url: '{{ route('deleteBuku') }}',
                        type: 'post',
                        data: {
                            id: id,
                        },
                        success: function(res) {
                            Swal.fire({
                                title: "Deleted!",
                                text: "Buku Berhasil Dihapus.",
                                icon: "success"
                            });
                            window.location.reload();
                        },
                        error: function(err) {
                            Swal.fire({
                                title: "Not Deleted!",
                                text: "Your file has been deleted.",
                                icon: "error"
                            });
                        }
                    })
                }
            });
        });
    </script>
    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                text: 'sukses tambah buku'
            })
        </script>
    @endif
@endpush
