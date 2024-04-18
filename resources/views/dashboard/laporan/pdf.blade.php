<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    {{-- <link rel="stylesheet" href="{{ asset('bootstrap-5.3.3-dist/css/bootstrap.min.css') }}"> --}}
</head>

<body>
    <h2 style="text-align: center">LAPORAN BUKU

    </h2>
    <table class="table" border="1" cellspacing='0' style="width: 100%">
        <thead>
            <tr>
                <td>NO</td>
                <td>Judul</td>
                <td>Kategori</td>
                <td>Penulis</td>
                <td>Penerbit</td>
                <td>Tahun Terbit</td>
            </tr>
        </thead>
        <tbody>
            @foreach ($buku as $no => $item)
                <tr>
                    <td>{{ $no + 1 }}</td>
                    {{-- <img src="{{ 'localhost:8000/storage/uploads/cover'.$item->gambarCover }}" alt=""> --}}
                    <td>{{ $item->judul }}</td>
                    <td>{{ $item->Kategori->kategori }}</td>
                    <td>{{ $item->penulis }}</td>
                    <td>{{ $item->penerbit }}</td>
                    <td>{{ date('d-m-Y', strtotime($item->tahunTerbit)) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
