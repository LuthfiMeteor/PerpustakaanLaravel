
{/* var pdfUrl = "{{ asset('storage/uploads/isiBuku/' . $bukuPDF->isiBuku) }}"; */}
const member = document.getElementById("member").value;
var pdfViewer = document.querySelector('.pdf-viewer');

// Memuat PDF menggunakan PDF.js
pdfjsLib.getDocument(pdfUrl).promise.then(function(pdf) {
    if (member == 0) {
        var pageCount = Math.ceil(pdf.numPages / 2);
    } else {
        var pageCount = pdf.numPages;
    }

    var scale = 1.5;

    for (var pageNum = 1; pageNum <= pageCount; pageNum++) {
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

            // Memuat dan merender halaman
            page.render(renderContext).promise.then(function() {
                // Menambahkan canvas ke dalam container
                var pdfPage = document.createElement('div');
                pdfPage.classList.add('pdf-page');
                pdfPage.appendChild(canvas);
                pdfViewer.appendChild(pdfPage);
            });
        });
    }
});
