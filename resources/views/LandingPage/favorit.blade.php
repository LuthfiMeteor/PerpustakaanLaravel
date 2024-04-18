@extends('layouts.landingPageApp')
@section('content')
    <div class="container">
        <div class="fs-2 fw-bold text-center">
            DAFTAR FAVORIT
        </div>
        <div class="row mt-2">
            @foreach ($favorit as $item)
                <div class="col-sm-3 col-md-4 col-xl-2 mb-2 col-6">
                    <div class="card">
                        <style>
                            /* Menentukan tinggi tetap dengan rasio aspek 16:9 */
                            .image-card {
                                /* position: relative; */
                                padding-bottom: 120%;
                                /* 9:16 ratio (9 / 16 * 100) */
                                height: 0;
                                overflow: hidden;
                            }

                            .image-card img {
                                /* position: absolute; */
                                object-fit: cover;
                                /* Untuk memastikan gambar terisi penuh di dalam kotak */
                            }
                        </style>
                        <div class="card-body p-0">
                            <div class="image-card rounded-3 text-center mb-3 overflow-hidden">
                                <img src="{{ asset('storage/uploads/cover/' . $item->gambarCover) }}" alt=""
                                    srcset="" class=" img-fluid">
                            </div>
                            <div class="p-1">
                                <a class="btn heart-icon unlike float-end" data-id="{{ Crypt::encrypt($item->id) }}">
                                    <img src="{{ asset('tabler-icons-2.45.0/png/heart-filled.png') }}" width="20px"
                                        alt="">
                                </a>
                                <div class="fs-5 fw-bold">
                                    KANCIL
                                </div>
                                <a class="link-underline-primary"
                                    href="{{ route('detailBuku', [Crypt::encrypt($item->id)]) }}">
                                    baca Sekarang
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
@push('script')
    <script src="{{ asset('jquey/dist/jquery.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('.unlike').click(function() {
                // console.log(1);
                const id = $(this).data('id');
                $.ajax({
                    url: '{{ route('favorit') }}',
                    type: 'post',
                    data: {
                        id: id
                    },
                    success: function(res) {
                        window.location.reload();
                    },
                    error: function(err) {

                    }
                })
            })
        })
    </script>
@endpush
