
<link rel="stylesheet" href="{{ asset ('css/pdf_identification.css') }}">

@if(Auth::user()->role == "Teacher" && $document->status == "Pending")
    <div class="hellneh">
        @if(Auth::user()->role == "Teacher" && $document->status == "Pending")
                <div class="hellneh">
                    <button id="approveBtn" class="btn">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            width="24"
                            height="24"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="url(#gradient)"
                            stroke-width="2"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            class="feather feather-check-square"
                        >
                            <defs>
                                <linearGradient id="gradient" x1="0%" y1="0%" x2="100%" y2="100%">
                                    <stop offset="0%" style="stop-color: rgba(105,255,78,1); stop-opacity: 1" />
                                    <stop offset="100%" style="stop-color: rgba(149, 254, 255, 1); stop-opacity: 1" />
                                </linearGradient>
                            </defs>
                            <polyline points="9 11 12 14 22 4"></polyline>
                            <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path>
                        </svg>
                        &nbsp;
                        Approve
                    </button>

                    <button id="revisionBtn" class="btn">
                        <svg xmlns="http://www.w3.org/2000/svg" 
                                width="24" height="24" 
                                viewBox="0 0 24 24" 
                                fill="none" 
                                stroke="currentColor" 
                                stroke-width="2" 
                                stroke-linecap="round" 
                                stroke-linejoin="round" 
                                class="feather feather-info">
                                <circle cx="12" cy="12" r="10" />
                                <line x1="12" y1="16" x2="12" y2="12" />
                                <line x1="12" y1="8" x2="12.01" y2="8" />
                            </svg>
                            &nbsp;
                            Needs Revisions
                    </button>

                    <button id="rejectBtn" class="btn">
                        <svg xmlns="http://www.w3.org/2000/svg" 
                                width="24" 
                                height="24" 
                                viewBox="0 0 24 24" 
                                fill="none" 
                                stroke="currentColor" 
                                stroke-width="2" 
                                stroke-linecap="round" 
                                stroke-linejoin="round" 
                                class="feather feather-x">
                                <line x1="18" y1="6" x2="6" y2="18" />
                                <line x1="6" y1="6" x2="18" y2="18" />
                            </svg>
                        &nbsp;
                        Reject
                    </button>
                </div>
            @endif

            @if(Auth::user()->role === "Student" && $document->status === "Pending")
                <button class="asd"
                    id="abandonBtn"
                    style="
                        background-color: #8e0404;
                        border-radius: 49px;
                        position: absolute;
                        margin-top: 140px;
                        margin-right: 40px;
                        width: 175px;
                        font-weight: lighter;
                        height: 40px;
                        display: flex;
                        border: none;
                        cursor: pointer;
                        transition: all 0.1s ease;
                        align-items: center;
                        justify-content: center;
                        color: white;
                        font-family: `rubik`;
                    ">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        width="20"
                        height="20"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        class="feather feather-trash"
                        >
                        <polyline points="3 6 5 6 21 6" />
                        <path
                            d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"
                        />
                    </svg>
                    &nbsp;
                    Abandon Document
                </button>
            @endif
    </div>
@endif

@if(Auth::user()->role == "Student" && $document->status == "Pending")
    <button class="asd open-modal" data-modal="abandonModal" data-document-id="{{ $document->id }}" 
    style="
        background-color: #8e0404;
        border-radius: 49px;
        position: absolute;
        margin-top: 140px;
        margin-right: 40px;
        width: 175px;
        font-weight: lighter;
        height: 40px;
        display: flex;
        border: none;
        cursor: pointer;
        transition: all 0.1s ease;
        align-items: center;
        justify-content: center;
        color: white;
        font-family: `rubik`;
    ">
    <svg
            xmlns="http://www.w3.org/2000/svg"
            width="20"
            height="20"
            viewBox="0 0 24 24"
            fill="none"
            stroke="currentColor"
            stroke-width="2"
            stroke-linecap="round"
            stroke-linejoin="round"
            class="feather feather-trash"
            >
            <polyline points="3 6 5 6 21 6" />
            <path
                d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"
            />
        </svg>
        &nbsp;
        Abandon Document
    </button>
@endif

<!-- Modals -->
@foreach(['approve' => 'Approve Document', 'revision' => 'Request Revisions', 'reject' => 'Reject Document', 'abandon' => 'Abandon Document'] as $action => $title)
<div id="{{ $action }}Modal" class="modal">
    <div class="modal-content">
        <h2>{{ $title }}</h2>
        <p>Are you sure you want to {{ strtolower($title) }}?</p>
        <div class="modal-actions">
            <form action="pdf_remove/{{ $document->id }}" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="action" value="{{ ucfirst($action) }}">
                <input type="hidden" name="document_id" class="document-id-input">
                <button type="submit" class="batan confirm">Confirm</button>
                <button type="button" class="batan cancel" onclick="closeModal()">Cancel</button>
            </form>
        </div>
    </div>
</div>
@endforeach

<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.10.377/pdf.min.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    const container = document.getElementById('pdf-container');
    const url = "{{ asset('storage/pdfs/' . $document->file_path) }}";
    let pdfDoc = null, scale = 1.5;

    pdfjsLib.getDocument(url).promise.then(pdf => {
        pdfDoc = pdf;
        document.getElementById('total-pages').textContent = pdfDoc.numPages;
        for (let i = 1; i <= pdfDoc.numPages; i++) {
            renderPage(i);
        }
        document.getElementById('loading-overlay').style.display = 'none';
        document.getElementById('pdf-content').style.display = 'flex';
    });

    function renderPage(num) {
        pdfDoc.getPage(num).then(page => {
            const viewport = page.getViewport({ scale });
            const canvas = document.createElement('canvas');
            canvas.className = 'page';
            const context = canvas.getContext('2d');
            canvas.height = viewport.height;
            canvas.width = viewport.width;
            container.appendChild(canvas);
            page.render({ canvasContext: context, viewport });
        });
    }

    // Modal Handling
    document.querySelectorAll(".open-modal").forEach(button => {
        button.addEventListener("click", () => {
            const modalId = button.getAttribute("data-modal");
            const documentId = button.getAttribute("data-document-id");
            const modal = document.getElementById(modalId);
            if (modal) {
                modal.style.display = "block";
                modal.querySelector(".document-id-input").value = documentId;
            }
        });
    });

    document.querySelectorAll(".cancel").forEach(button => {
        button.addEventListener("click", closeModal);
    });

    window.onclick = (event) => {
        document.querySelectorAll(".modal").forEach(modal => {
            if (event.target == modal) {
                closeModal();
            }
        });
    };

    function closeModal() {
        document.querySelectorAll(".modal").forEach(modal => modal.style.display = "none");
    }
});
</script>