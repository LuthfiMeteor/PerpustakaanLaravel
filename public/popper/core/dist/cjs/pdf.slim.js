// PDF BACA
var pdfUrl = "{{ asset('storage/uploads/isiBuku/' . $bukuPDF->isiBuku) }}";
const member = document.getElementById("member").value;
var pdfViewer = document.querySelector('.pdf-viewer');
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

for (var i = 1; i <= numVisiblePages; i++) { renderPage(i); } // scroll Macam Web Manga Ini
    window.addEventListener('scroll', function() { var scrollTop=window.scrollY; var
    scrollHeight=document.body.scrollHeight; var clientHeight=window.innerHeight; var scrollPercentage=(scrollTop /
    (scrollHeight - clientHeight)) * 100; if (scrollPercentage> 70) {
    var nextPage = Object.keys(renderedPages).length + 1;
    if (nextPage <= pageCount) { renderPage(nextPage); } } }); });




// Datatable
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
                    // url: '{{ route('deletePetugas') }}',
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
});


// Ckeditor
$(document).ready(function() {
    ClassicEditor
        .create(document.querySelector('#editor'))
        .then(editor => {
            $('#kirim').click(function(e) {
                e.preventDefault();

                // Get the CKEditor instance
                var editorData = editor.getData();

                // Set the content of CKEditor as the value of the textarea
                $('#deskripsi').val(editorData);

                // Submit the form
                $('#form').submit();
            });
        })
        .catch(error => {
            console.error(error);
        });
});


// Style Buku Page

// .image-card {
//     /* position: relative; */
//     padding-bottom: 120%;
//     /* 9:16 ratio (9 / 16 * 100) */
//     height: 0;
//     overflow: hidden;
// }

// .image-card img {
//     /* position: absolute; */
//     object-fit: cover;
//     /* Untuk memastikan gambar terisi penuh di dalam kotak */
// }



// Style Saat Baca Buku

// .pdf-page {
//     margin: 0;
//     padding: 0;
// }

// .pdf-viewer {
//     margin: 0;
//     padding: 0;
// }

// body {
//     line-height: 0;
// }

// /* Set initial scale for mobile devices */
// @media only screen and (max-width: 767px) {
//     .pdf-viewer canvas {
//         max-width: 100%;
//         width: 100%;
//     }
// }


// Buat Tambah Favorit
$('.like').click(function(e) {
    e.preventDefault();
    var $this = $(this);
    var id = $(this).data('id');
    console.log(id);
    $.ajax({
        // url: '{{ route('favorit') }}',
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


// Datatable Controller

// if (request()->ajax()) {
//     $buku = BukuModel::query();
//     return DataTables::of($buku)
//         ->addindexColumn()
//         ->addColumn('judul', function ($buku) {
//             return $buku->judul;
//         })->addColumn('kategori', function ($buku) {
//             return $buku->Kategori->kategori;
//         })->addColumn('gambar', function ($buku) {
//             return "<img src='" . asset('storage/uploads/cover/' . $buku->gambarCover) . "' alt='' style='width: 130px;'>";
//         })
//         ->addColumn('file', function ($buku) {
//             return "<a href='" . asset('storage/uploads/isiBuku/' . $buku->isiBuku) . "' >$buku->isiBuku</a>";
//         })
//         ->addColumn('penulis', function ($buku) {
//             return $buku->penulis;
//         })
//         ->addColumn('penerbit',  function ($buku) {
//             return $buku->penerbit;
//         })
//         ->addColumn('tahunterbit', function ($buku) {
//             return date('d-m-Y', strtotime($buku->tahunTerbit));
//         })
//         ->addColumn('action', function ($buku) {
//             return '<a href="' . route('editBuku', $buku->id) . '" class="btn btn-warning">Edit</a> <button id="deleteBuku" data-id="' . $buku->id . '" class="deleteBuku btn btn-danger">Hapus</button>';
//         })
//         ->rawColumns(['gambar', 'file', 'action'])
//         ->make();
// }





