@extends('layouts.app')
@push('style')
    <link rel="stylesheet" href="{{ asset('datatables\datatables.css') }}">
    <link rel="stylesheet" href="{{ asset('sweetalert2.min\sweetalert2.min.css') }}">
@endpush
@section('content')
    <div class="container-fluid">
        <div class="">
            <h2>Managemen Petugas</h2>
            <p class="">
                <a href="{{ route('home') }}" class="link-underline-secondary text-dark">Dashboard</a> / <a href="#"
                    class="link-underline-secondary text-dark">Manamegemen Petugas</a>
            </p>
        </div>
        <div class="card">
            <div class="card-header">
                <button class="btn btn-primary" id="tambahPetugas">Tambah Petugas</button>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr class="fw-bold">
                                <td>Nama Petugas</td>
                                <td>Username</td>
                                <td>Email</td>
                                <td>Tahun & Tanggal Lahir</td>
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
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Tambah Petugas</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('tambahPetugas') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="kategoru">Nama Petugas</label>
                            <input type="text" name="nama" class="form-control" placeholder="Luthfi">
                        </div>
                        <div class="mb-3">
                            <label for="gambar">username</label>
                            <input type="text" name="username" class="form-control" placeholder="luthfi" id="">
                        </div>
                        <div class="mb-3">
                            <label for="gambar">email</label>
                            <input type="email" name="email" class="form-control" placeholder="contoh@gmail.com"
                                id="">
                        </div>
                        <div class="mb-3">
                            <label for="gambar">Tahun & Tanggal Lahir</label>
                            <input type="date" name="tglLahir" class="form-control" id="">
                        </div>
                        <div class="mb-3">
                            <label for="gambar">password</label>
                            <input type="password" name="password" class="form-control" placeholder="******" id="">
                        </div>
                        <button type="submit" class="btn btn-primary">Tambah</button>
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
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $(document).ready(function() {
            $('.table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ url()->current() }}',
                columns: [{
                    data: 'name',
                    name: 'name',
                }, {
                    data: 'username',
                    name: 'username',
                }, {
                    data: 'email',
                    name: 'email',
                }, {
                    data: 'tgllahir',
                    name: 'tgllahir',
                }, {
                    data: 'action',
                    name: 'action',
                }]
            });
            $('#tambahPetugas').click(function() {
                $('#staticBackdrop').modal('show');
            });

            $('.table').on('click', '.deletePetugas', function() {
                const id = $(this).data('id');
                Swal.fire({
                    title: "Hapus Petugas?",
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
                            url: '{{ route('deletePetugas') }}',
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
        })
    </script>
    @if (session('successTambah'))
        <script>
            swal.fire({
                icon: "success",
                text: "Berhasil Tambah Petugas",
                title: "Sukses!"
            });
        </script>
    @endif
    @if (session('successEdit'))
        <script>
            swal.fire({
                icon: "success",
                text: "Berhasil edit Petugas",
                title: "Sukses!"
            });
        </script>
    @endif
@endpush
