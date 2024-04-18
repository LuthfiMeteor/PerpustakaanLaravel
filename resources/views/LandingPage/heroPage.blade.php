@extends('layouts.landingPageApp')
@section('content')
    <div class="container col-xxl-8 px-4 py-5">
        <div class="row flex-lg-row-reverse align-items-center g-5">
            <div class="col-10 col-sm-8 col-lg-6">
                <img src="{{ asset('storage/uploads/cover/' . $buku->gambarCover) }}" class="d-block mx-lg-auto img-fluid"
                    alt="Bootstrap Themes" width="300" height="200" loading="lazy">
            </div>
            <div class="col-lg-6">
                <h1 class="display-5 fw-bold lh-1 mb-3">Perpustakaan Digital</h1>
                <p class="lead">Baca Buku Secara Gratis dan secara praktis.</p>
                <div class="d-grid gap-2 d-md-flex justify-content-md-start">
                    <button type="button" class="btn btn-primary btn-lg px-4 me-md-2">Daftar</button>
                    {{-- <button type="button" class="btn btn-outline-secondary btn-lg px-4">Default</button> --}}
                </div>
            </div>
        </div>
    </div>
@endsection
