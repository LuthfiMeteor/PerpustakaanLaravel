@extends('layouts.landingPageApp')
@section('content')
    <div class="container">
        <div class="fs-2 fw-bold text-center">
            DAFTAR BUKU
        </div>
        <div class="row mt-2">
            <div class="col-sm-3 col-md-4 col-xl-2">
                <div class="card">
                    <div class="card-body p-0">
                        <img src="{{ asset('image/assets/media/books/2.png') }}" alt="" srcset="" class="card-img">
                        <div class="p-1">
                            <div class="fs-5 fw-bold">
                                KANCIL
                            </div>
                            <a class="link-underline-primary" href="{{ route('detailBuku') }}">
                                baca Sekarang
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
