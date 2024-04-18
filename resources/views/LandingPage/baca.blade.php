<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('bootstrap-5.3.3-dist/css/bootstrap.min.css') }}">
    <style>
        /* Adjust for better appearance */
        .pdf-page {
            margin: 0;
            padding: 0;
        }

        .pdf-viewer {
            margin: 0;
            padding: 0;
        }

        body {
            line-height: 0;
        }

        /* Set initial scale for mobile devices */
        @media only screen and (max-width: 767px) {
            .pdf-viewer canvas {
                max-width: 100%;
                width: 100%;
            }
        }

        .scaling-squares-spinner,
        .scaling-squares-spinner * {
            box-sizing: border-box;
        }

        .scaling-squares-spinner {
            height: 65px;
            width: 65px;
            position: relative;
            /* display: none; */
            flex-direction: row;
            align-items: center;
            justify-content: center;
            animation: scaling-squares-animation 1250ms;
            animation-iteration-count: infinite;
            transform: rotate(0deg);
        }

        .scaling-squares-spinner .square {
            height: calc(65px * 0.25 / 1.3);
            width: calc(65px * 0.25 / 1.3);
            margin-right: auto;
            margin-left: auto;
            border: calc(65px * 0.04 / 1.3) solid #ff1d5e;
            position: absolute;
            animation-duration: 1250ms;
            animation-iteration-count: infinite;
        }

        .scaling-squares-spinner .square:nth-child(1) {
            animation-name: scaling-squares-spinner-animation-child-1;
        }

        .scaling-squares-spinner .square:nth-child(2) {
            animation-name: scaling-squares-spinner-animation-child-2;
        }

        .scaling-squares-spinner .square:nth-child(3) {
            animation-name: scaling-squares-spinner-animation-child-3;
        }

        .scaling-squares-spinner .square:nth-child(4) {
            animation-name: scaling-squares-spinner-animation-child-4;
        }


        @keyframes scaling-squares-animation {

            50% {
                transform: rotate(90deg);
            }

            100% {
                transform: rotate(180deg);
            }
        }

        @keyframes scaling-squares-spinner-animation-child-1 {
            50% {
                transform: translate(150%, 150%) scale(2, 2);
            }
        }

        @keyframes scaling-squares-spinner-animation-child-2 {
            50% {
                transform: translate(-150%, 150%) scale(2, 2);
            }
        }

        @keyframes scaling-squares-spinner-animation-child-3 {
            50% {
                transform: translate(-150%, -150%) scale(2, 2);
            }
        }

        @keyframes scaling-squares-spinner-animation-child-4 {
            50% {
                transform: translate(150%, -150%) scale(2, 2);
            }
        }
    </style>
    <script src="{{ asset('pdf.min.js') }}"></script>
    <script src="{{ asset('pdf.worker.js') }}"></script>
    <script src="{{ asset('sweetalert2.min\sweetalert2.min.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('sweetalert2.min\sweetalert2.min.css') }}">
    <script src="{{ asset('bootstrap-5.3.3-dist/js/bootstrap.min.js') }}"></script>
</head>

<body style="background-color: black">
    <div class="position-absolute top-50 start-50 translate-middle scaling-squares-spinner" id="loader"
        :style="spinnerStyle">
        <div class="square"></div>
        <div class="square"></div>
        <div class="square"></div>
        <div class="square"></div>
    </div>
    <div class="container">
        {{-- <div class="row justify-content-center">
            <div class="col-12 col-md-8"> <!-- Adjust the column width based on your preference -->
                <div class="pdf-viewer">
                </div>
            </div>
        </div> --}}
        <center>

            <div class="pdf-viewer">
            </div>
        </center>
    </div>

    @if ($check_member == 0)
        <script src="{{ asset('jquey/dist/jquery.min.js') }}"></script>
        <script>
            // swal.fire({
            //     icon: "warning",
            //     text: "Kamu Bukan Member, Buku Akan Ditampilkan Setengah Dari Total Halaman. Silahkan daftar member untuk mendapatkan benefit"
            // })
            Swal.fire({
                title: "PERHATIAN?",
                text: "Kamu Bukan Member, Buku Akan Ditampilkan Setengah Dari Total Halaman. Silahkan daftar member untuk mendapatkan benefit!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Ya, Daftar!"
            }).then((result) => {
                if (result.isConfirmed) {
                    // Swal.fire({
                    //     title: "Deleted!",
                    //     text: "Your file has been deleted.",
                    //     icon: "success"
                    // });
                    $('#staticBackdrop').modal('show');
                }
            });
        </script>
    @endif
    <input type="hidden" name="" id="member" value="{{ $check_member }}">
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog ">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Daftar Member</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('daftarMember') }}" method="post">
                        @csrf
                        <div class="row">
                            <div class="mb-3 col-12">
                                <label for="">Nomor Telfon</label>
                                <input type="number" name="no_telp" id="no_telp" class="form-control">
                            </div>
                            <div class="mb-3 col-12">
                                <label for="">tanggal & tahun lahir</label>
                                <input type="date" name="tgllahir" id="no_telp" class="form-control">
                            </div>
                            <div class="mb-3 col-12">
                                <label for="">Alamat</label>
                                <textarea name="alamat" class="form-control" id="" cols="30" rows="10"></textarea>
                            </div>
                            <button class="btn btn-primary" type="submit">Daftar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        var pdfUrl = "{{ asset('storage/uploads/isiBuku/' . $bukuPDF->isiBuku) }}";
        const member = document.getElementById("member").value;
        var pdfViewer = document.querySelector('.pdf-viewer');

        // Memuat PDF menggunakan PDF.js
        // Show loader function
        function showLoader() {
            var loader = document.getElementById('loader');
            loader.style.display = 'block';
        }

        // Hide loader function
        function hideLoader() {
            var loader = document.getElementById('loader');
            loader.style.display = 'none';
        }

        pdfjsLib.getDocument(pdfUrl).promise.then(function(pdf) {
            if (member == 0) {
                var pageCount = Math.ceil(pdf.numPages / 3);
            } else {
                var pageCount = pdf.numPages;
                console.log(pdf.numPages);
            }

            var scale = 1.2;
            var numVisiblePages = 5;
            var renderedPages = {};

            function renderPage(pageNum) {
                if (!renderedPages[pageNum]) {
                    showLoader(); // Show loader before rendering

                    pdf.getPage(pageNum).then(function(page) {
                        var viewport = page.getViewport({
                            scale: scale
                        });
                        var canvas = document.createElement('canvas');
                        var context = canvas.getContext('2d');
                        canvas.height = viewport.height;
                        canvas.width = viewport.width;

                        var renderContext = {
                            canvasContext: context,
                            viewport: viewport
                        };

                        page.render(renderContext).promise.then(function() {
                            var pdfPage = document.createElement('div');
                            pdfPage.classList.add('pdf-page');
                            pdfPage.appendChild(canvas);
                            pdfViewer.appendChild(pdfPage);

                            renderedPages[pageNum] = true;
                            hideLoader(); // Hide loader after rendering
                        });
                    });
                }
            }

            for (var i = 1; i <= numVisiblePages; i++) {
                renderPage(i);
            }

            // scroll Macam Web Manga Ini
            window.addEventListener('scroll', function() {
                var scrollTop = window.scrollY;
                var scrollHeight = document.body.scrollHeight;
                var clientHeight = window.innerHeight;
                var scrollPercentage = (scrollTop / (scrollHeight - clientHeight)) * 100;

                if (scrollPercentage > 70) {
                    var nextPage = Object.keys(renderedPages).length + 1;
                    if (nextPage <= pageCount) {
                        renderPage(nextPage);
                    }
                }
            });
        });
    </script>
    @if (session('success'))
        <script>
            swal.fire({
                icon: 'success',
                text: 'Terima Kasih Kamu Telah Terdaftar Sebagai Member.'
            })
        </script>
    @endif
    <script src="{{ asset('popper/core/dist/umd/popper.min.js') }}"></script>
    <script src="{{ asset('datatables/datatables.js') }}"></script>
</body>

</html>
