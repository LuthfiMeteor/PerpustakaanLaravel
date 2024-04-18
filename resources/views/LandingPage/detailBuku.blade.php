@extends('layouts.LandingPageApp')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="row">
                    <div class="col-lg-4">
                        <img src="{{ asset('storage/uploads/cover/' . $buku->gambarCover) }}" alt="" class="img-fluid"
                            style="width: 300px" />
                    </div>
                    <div class="col-lg-8 mt-4 mt-lg-0 text-break">
                        <div class="fs-2 fw-bold mb-1 ">{{ $buku->judul }}</div>
                        <ul class=" fs-3">
                            <li style="list-style: square">Penulis &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; :
                                {{ $buku->penulis }}
                            </li>
                            <li style="list-style: square">Penerbit &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; :
                                {{ $buku->penerbit }} </li>
                            <li style="list-style: square">kategori &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; :
                                {{ $buku->Kategori->kategori }} </li>
                            <li style="list-style: square">Tahun Terbit :
                                {{ date('d-m-Y', strtotime($buku->tahunTerbit)) }}</li>
                        </ul>
                        <br>
                        <br>
                        <br>
                        <div class="fs-5 mb-4">
                            <!-- Empty heart icon -->
                            @php
                                $user = Auth::user();
                                $kaloFav = $user
                                    ->favoritBy()
                                    ->where('buku_id', $buku->id)
                                    ->exists();
                            @endphp
                            @if (!$kaloFav)
                                <a href="#" id="tambahFavorit" class="btn btn-primary heart-icon like"
                                    data-id="{{ Crypt::encrypt($buku->id) }}">
                                    <img src="{{ asset('tabler-icons-2.45.0/png/heart.png') }}" width="20px"
                                        alt="">
                                </a>
                            @else
                                <!-- Filled heart icon (hidden by default) -->
                                <a href="#" class="btn btn-primary heart-icon unlike"
                                    data-id="{{ Crypt::encrypt($buku->id) }}">
                                    <img src="{{ asset('tabler-icons-2.45.0/png/heart-filled.png') }}" width="20px"
                                        alt="">
                                </a>
                            @endif
                            <a target="_blank" href="{{ route('bacaBuku', [Crypt::encrypt($buku->id)]) }}"
                                class="btn btn-primary">baca
                                sekarang</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-5">
            <div class="fs-4">
                ULASAN
            </div>
            <div class="row p-0">
                <div class="col-10">
                    <input class="form-control" type="text" name="" id="">
                </div>
                <div class="col-2">
                    <div class="btn btn-primary">kirim</div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('jquey/dist/jquery.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('.like').click(function(e) {
                e.preventDefault();
                var $this = $(this);
                var id = $(this).data('id');
                console.log(id);
                $.ajax({
                    url: '{{ route('favorit') }}',
                    type: 'post',
                    data: {
                        id: id
                    },
                    success: function(res) {
                        $this.addClass('d-none');
                        $this.siblings('.like').removeClass('d-none');
                        window.location.reload();
                    },
                    error: function(err) {

                    },
                });
            });
            $('.unlike').click(function(e) {
                e.preventDefault();
                var id = $(this).data('id');
                var $this = $(this);
                $.ajax({
                    url: '{{ route('favorit') }}',
                    type: 'post',
                    data: {
                        id: id
                    },
                    success: function(res) {
                        $this.addClass('d-none');
                        $this.siblings('.unlike').removeClass('d-none');
                        window.location.reload();
                    },
                    error: function(err) {

                    },
                });
            });
        });
    </script>
@endsection
