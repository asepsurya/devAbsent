<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PDF Viewer</title>
    <style>
        #pdf-container {
            width: 100%;
            height: 600px;
            overflow: auto;
        }
    </style>
</head>
<body>
    <h1>PDF Viewer</h1>
    <div id="pdf-container"></div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.10.377/pdf.min.js"></script>
    <script>
        const url = "/download/J7ZkzWFEJHMmsgmf9taJdBBI1W2XMLJSU3K8a9Yl.pdf";  // Adjust to the PDF file you want to render

        pdfjsLib.getDocument(url).promise.then(function (pdf) {
            const pdfContainer = document.getElementById('pdf-container');
            let currentPage = 1;

            // Render the first page of the PDF
            renderPage(pdf, currentPage);

            function renderPage(pdf, pageNumber) {
                pdf.getPage(pageNumber).then(function (page) {
                    const scale = 1.5;
                    const viewport = page.getViewport({ scale: scale });

                    const canvas = document.createElement('canvas');
                    pdfContainer.appendChild(canvas);
                    const context = canvas.getContext('2d');
                    canvas.height = viewport.height;
                    canvas.width = viewport.width;

                    page.render({
                        canvasContext: context,
                        viewport: viewport
                    });
                });
            }
        });
    </script>
</body>
</html>
