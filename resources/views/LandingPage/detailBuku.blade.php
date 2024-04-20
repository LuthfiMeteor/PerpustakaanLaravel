@extends('layouts.LandingPageApp')
@section('content')
    <link rel="stylesheet" href="{{ asset('sweetalert2.min\sweetalert2.min.css') }}">
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
                        <ul class=" fs-5">
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
                        <small>
                            {!! $buku->deskripsi !!}
                        </small>
                        <br>
                        <br>
                        <br>
                        <div class="fs-5 mb-4">
                            <!-- Empty heart icon -->
                            @php
                                $user = Auth::user();

                                if ($user) {
                                    $kaloFav = $user
                                        ->favoritBy()
                                        ->where('buku_id', $buku->id)
                                        ->exists();
                                } else {
                                    $kaloFav = false;
                                }
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
            @php
                if (Auth::user()) {
                    $komentarCheck = Auth::user()
                        ->komentarBy()
                        ->where('buku_id', $buku->id)
                        ->first();
                } else {
                    $komentarCheck = false;
                }
                // dd($komentarCheck);
            @endphp
            @role('user')
                @if (!$komentarCheck)
                    <div class="fs-4">
                        ULASAN
                    </div>
                    @if (Auth::user())
                        <form action="{{ route('kirimKomentar') }}" method="post">
                            @csrf
                            <div class="row p-0">
                                <div class="col-11">
                                    <input class="form-control" type="text" name="komentar" id=""
                                        placeholder="tulis komentarmu">
                                    <input type="hidden" name="buku_id" value="{{ Crypt::encrypt($buku->id) }}">
                                </div>
                                <div class="col-1">
                                    <button type="submit" class="btn btn-primary">kirim</button>
                                </div>
                            </div>
                        </form>
                    @endif
                @else
                    <div class="fs-4">
                        ULASAN SAYA
                    </div>
                    {{-- <form action="{{ route('kirimKomentar') }}" method="post">
                    @csrf
                    <div class="row p-0">
                        <div class="col-10">
                            <input class="form-control" type="text" name="komentar" id=""
                                placeholder="tulis komentarmu">
                            <input type="hidden" name="buku_id" value="{{ Crypt::encrypt($buku->id) }}">
                        </div>
                        <div class="col-2">
                            <button type="submit" class="btn btn-primary">kirim</button>
                        </div>
                    </div>
                </form> --}}
                    <div class="row">
                        <div class="col-1 col-md-1  mt-4">
                            <img src="{{ asset('image\books\image\309236075_389292920078152_3685238632251069126_n.jpg') }}"
                                alt="" class="img-fluid" srcset="" width="70px">
                        </div>
                        <div class="col-11 mt-3">
                            <textarea style="resize: none;" readonly class="form-control" name="" id="" cols="2"
                                rows="3">{{ $komentarCheck->komentar }}</textarea>
                        </div>
                    </div>
                @endif
            @endrole

            <div class="fs-4 mt-2">SEMUA ULASAN</div>
            <hr>
            @php
                $allKomentar = \App\Models\KomentarModel::where('buku_id', $buku->id)
                    ->where('user_id', '!=', Auth::id())
                    ->get();
            @endphp
            @foreach ($allKomentar as $item)
                <div class="row">
                    <div class="col-1 col-md-1  mt-4">
                        <img src="{{ asset('image\books\image\309236075_389292920078152_3685238632251069126_n.jpg') }}"
                            alt="" class="img-fluid" srcset="" width="70px">
                    </div>
                    <div class="col-11 mt-3">
                        <div class="card">
                            <div class="fs-5 p-2">
                                {{ $item->komentarOleh->name }}
                            </div>
                            <p class="text-break p-2">
                                {{ $item->komentar }}
                            </p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <script src="{{ asset('jquey/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('sweetalert2.min\sweetalert2.min.js') }}"></script>
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
                        swal.fire({
                            icon: 'error',
                            text: 'silahkan login dahulu',
                        });
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
