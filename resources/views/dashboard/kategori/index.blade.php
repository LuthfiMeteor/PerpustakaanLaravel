@extends('layouts.app')
@push('style')
    <link rel="stylesheet" href="{{ asset('datatables\datatables.css') }}">
    <link rel="stylesheet" href="{{ asset('sweetalert2.min\sweetalert2.min.css') }}">
@endpush
@section('content')
    <div class="container-fluid">
        <div class="">
            <h2>Managemen Kategori</h2>
            <p><a href="{{ route('home') }}" class="link-underline-secondary text-dark">Dashboard </a>/
                <a href="" class="text-dark link-underline-secondary">Managemen Kategori</a>
            </p>
        </div>
        <div class="card">
            <div class="card-header"><button class="btn btn-primary" id="tambahKategori">+</button></div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr class="fw-bold">
                                <td>Nama Kategori</td>
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
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Tambah Kategori</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('tambahKategori') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="kategoru">Nama Kategori</label>
                            <input type="text" name="nama_kategori" class="form-control">
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
    <script>
        $(document).ready(function() {
            $('.table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ url()->current() }}',
                columns: [{
                    data: 'name',
                    name: 'name'
                }, {
                    data: 'action',
                    name: 'action',
                }]
            });

            // Event delegation for dynamically generated elements
            // $('.table').on('click', '.editKategori', function() {
            //     console.log(1);
            //     $('#editModal').modal('show');
            // });
        });
    </script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $("#tambahKategori").on('click', function() {
            $('#staticBackdrop').modal('show');
        });


        $(".table").on('click', '.editKategori', function() {
            const KategoriID = $(this).data('id');
            console.log(KategoriID);
            $.ajax({
                url: '{{ route('editKategori') }}',
                type: 'get',
                data: {
                    id: KategoriID
                },
                success: function(res) {
                    // console.log(res);
                    $('#kategoriEdit').val(res.kategori);
                    $('#idKategori').val(res.id);
                    $('#staticBackdrops').modal('show');
                },
                error: function(err) {
                    console.log(err);
                },
            })
            // $('#staticBackdrops1').modal('show');
        });
        $('.table').on('click', '.deleteKategori', function() {
            const KategoriID = $(this).data('id');
            console.log(KategoriID);
            Swal.fire({
                title: "Hapus Kategori?",
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
                        url: '{{ route('deleteKategori') }}',
                        type: 'post',
                        data: {
                            id: KategoriID,
                        },
                        success: function(res) {
                            Swal.fire({
                                title: "Deleted!",
                                text: "Kategori Berhasil Dihapus.",
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
        })
    </script>
    @if (session('success'))
        <script>
            swal.fire({
                icon: 'success',
                text: 'berhasil update',
            });
        </script>
    @endif

@endpush
