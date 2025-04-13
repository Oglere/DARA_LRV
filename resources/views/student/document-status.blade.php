<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>DARA - Student Dashboard</title>
    <link rel="stylesheet" href="{{ asset('../../css/mainpage.css') }}">
    <link rel="stylesheet" href="{{ asset('../../css/std.css') }}">
    <link rel="stylesheet" href="{{ asset('../../css/std_status.css') }}"> 
    <link rel="stylesheet" href="{{ asset('../../css/svg.css') }}">
</head>
<body>
    <main>
        <header> 
            <div class="ahh">
                <img src="../../Imgs/DARA.png" alt="" style="height: 40px;">
            </div>
        </header>
         
        <div class="main" style="height: 100%;">
            <div class="left">
                <div class="profile">
                    <h2>{{ auth()->user()->first_name }}</h2>
                </div>

                <nav class="nav-links">
                    <a href="/student"> 
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            width="24"
                            height="24"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            class="feather feather-home"
                            >
                            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
                            <polyline points="9 22 9 12 15 12 15 22" />
                        </svg>

                        Dashboard
                    </a>
                    <a href="document-submission">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            width="24"
                            height="24"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            class="feather feather-file-plus"
                            >
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                            <polyline points="14 2 14 8 20 8" />
                            <line x1="12" y1="18" x2="12" y2="12" />
                            <line x1="9" y1="15" x2="15" y2="15" />
                        </svg>
                    
                        Submit Studies
                    </a>
                    <a href="" style="color: #04128e; font-weight: normal;">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            width="24"
                            height="24"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            class="feather feather-eye"
                            >
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                            <circle cx="12" cy="12" r="3" />
                        </svg>

                        View Study Status
                    </a>

                    <div class="asd2" style=" width: 100%; margin-top: 10px; display: flex; justify-content: center;">
                        <div class="asd3" style="border-bottom: 1px solid grey; width: 150px;"></div>
                    </div>

                    <a href="/" class="unq">Search Studies</a>
                    <a href="edit" class="unq">Edit Account</a>

                    <div class="asd2" style=" width: 100%; display: flex; justify-content: center;">
                        <div class="asd3" style="border-bottom: 1px solid grey; width: 150px;"></div>
                    </div>

                    <form action="/out" method="POST">
                        @csrf
                        <button class="lgt">
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                width="24"
                                height="24"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                class="feather feather-log-in"
                                >
                                <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4" />
                                <polyline points="10 17 15 12 10 7" />
                                <line x1="15" y1="12" x2="3" y2="12" />
                            </svg>

                            Logout
                        </button>
                    </form>
                </nav>
            </div>

            <div class="right" style="overflow: auto;">
                <style>
                    .batan {
                        border-radius: 49px;
                        width: 175px;
                        margin-top: 40px;
                        font-weight: lighter;
                        height: 40px;
                        display: flex;
                        border: none;
                        cursor: pointer;
                        transition: all 0.1s ease;
                        align-items: center;
                        font-family: "rubik";
                        justify-content: center;
                    }

                    .confirm {
                        background-color: #8e0404;
                        color: white;
                    }

                    .confirm:hover {
                        box-shadow: 3px 3px 4px #7b7b7b, -3px -3px 4px #ffffff;
                        font-weight: normal;
                    }

                    .cancel {
                        color: #333;
                    }

                    form {
                        width: 100%;
                        display: flex;
                        justify-content: center;
                        justify-content: space-between;
                    }
                </style>

                <div class="status-container">
                    <h1 style="font-weight: lighter;">STATUS OF SUBMITTED DOCUMENTS</h1>
                    
                    @if ($documents->count() > 0)
                        <ul>
                            @foreach ($documents as $doc)
                                <li style="
                                    @if($doc->status == 'Approved') background: linear-gradient(90deg, rgba(2,0,36,1) 0%, rgba(105,255,78,1) 0%, rgba(149,254,255,1) 100%); border: none;
                                    @elseif($doc->status == 'Pending') background: linear-gradient(90deg, rgba(78,102,255,0.5) 0%, rgba(149,254,255,1) 100%);
                                    @elseif($doc->status == 'Abandoned') border: solid 1px black;
                                    @endif
                                ">
                                    <div class="okok">
                                        <span class="status {{ strtolower(str_replace(' ', '-', $doc->status)) }}">
                                            @if ($doc->status === "Approved")
                                                <svg
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    width="35"
                                                    height="35"
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

                                            @elseif ($doc->status === "Pending")
                                                <svg xmlns="http://www.w3.org/2000/svg" 
                                                    width="35" 
                                                    height="35" 
                                                    viewBox="0 0 24 24" 
                                                    fill="none" 
                                                    stroke="currentColor" 
                                                    stroke-width="2" 
                                                    stroke-linecap="round" 
                                                    stroke-linejoin="round" 
                                                    class="feather feather-loader">
                                                    <line x1="12" y1="2" x2="12" y2="6" />
                                                    <line x1="12" y1="18" x2="12" y2="22" />
                                                    <line x1="4.93" y1="4.93" x2="7.76" y2="7.76" />
                                                    <line x1="16.24" y1="16.24" x2="19.07" y2="19.07" />
                                                    <line x1="2" y1="12" x2="6" y2="12" />
                                                    <line x1="18" y1="12" x2="22" y2="12" />
                                                    <line x1="4.93" y1="19.07" x2="7.76" y2="16.24" />
                                                    <line x1="16.24" y1="7.76" x2="19.07" y2="4.93" />
                                                </svg>

                                            @elseif ($doc->status === "Needs Revision")
                                                <svg xmlns="http://www.w3.org/2000/svg" 
                                                    width="35" height="35" 
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

                                            @elseif ($doc->status === "Rejected")
                                                <svg xmlns="http://www.w3.org/2000/svg" 
                                                    width="35" 
                                                    height="35" 
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

                                            @elseif ($doc->status === "Abandoned")
                                                <svg
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    width="35"
                                                    height="35"
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

                                            @endif
                                        </span>

                                        <div class="continents">
                                            <div class="top">
                                                <span class="title" style="color: {{ $doc->status !== 'Abandoned' ? '#2E5256' : 'black' }};">
                                                    @if ($doc->status !== "Abandoned")
                                                        <a href="pdf-reader/{{ $doc->document_id }}">{{ $doc->title }}</a>
                                                    @else
                                                        {{ $doc->title }}
                                                    @endif

                                                    ({{ $doc->status }})
                                                </span>
                                            </div>
                                            <div class="bottom">
                                                <div class="wtf">
                                                    <span class="date" style="color: {{ $doc->status !== 'Abandoned' ? '#2E5256' : 'black' }};">
                                                        Date submitted: &nbsp;
                                                    </span>
                                                    <div class="datete" style="color: {{ $doc->status !== 'Abandoned' ? '#2E5256' : 'black' }};">
                                                        {{ \Carbon\Carbon::parse($doc->date_submitted)->format('M d, Y') }} at {{ \Carbon\Carbon::parse($doc->date_submitted)->format('h:i A') }}
                                                    </div>
 
                                                    @if ($doc->status == "Approved")
                                                        <span class="date" style="margin-left: 20px; color: #2E5256;">Date approved: &nbsp;</span>
                                                        <div class="datete" style="color: #2E5256;">
                                                            {{ \Carbon\Carbon::parse($doc->date_reviewed)->format('M d, Y') }} at {{ \Carbon\Carbon::parse($doc->date_reviewed)->format('h:i A') }}
                                                        </div>
                                                    @elseif ($doc->status == "Abandoned")
                                                        <span class="date" style="margin-left: 20px; color: black;">Date Abandoned: </span>
                                                        <div class="datete" style="color: black;">
                                                            {{ \Carbon\Carbon::parse($doc->abandoned_date)->format('M d, Y') }} at {{ \Carbon\Carbon::parse($doc->abandoned_date)->format('h:i A') }}
                                                        </div>
                                                    @endif
                                                </div>

                                                <div class="actions">
                                                    @if ($doc->status == "Pending")
                                                        <button class="btn abandon" onclick="openModal('abandonModal', {{ $doc->document_id }})">
                                                            <svg
                                                                xmlns="http://www.w3.org/2000/svg"
                                                                width="15"
                                                                height="15"
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
                                                        </button>

                                                    @elseif ($doc->status == "Abandoned")
                                                        <button class="btn recover" onclick="openModal('recoverModal', {{ $doc->document_id }})">
                                                            <svg
                                                                xmlns="http://www.w3.org/2000/svg"
                                                                width="15"
                                                                height="15"
                                                                viewBox="0 0 24 24"
                                                                fill="none"
                                                                stroke="currentColor"
                                                                stroke-width="2"
                                                                stroke-linecap="round"
                                                                stroke-linejoin="round"
                                                                class="feather feather-refresh-cw"
                                                                >
                                                                <polyline points="23 4 23 10 17 10" />
                                                                <polyline points="1 20 1 14 7 14" />
                                                                <path
                                                                    d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"
                                                                />
                                                            </svg>
                                                        </button>

                                                        <button class="btn removeperm" onclick="openModal('removepermModal', {{ $doc->document_id }})">
                                                            <svg
                                                                xmlns="http://www.w3.org/2000/svg"
                                                                width="15"
                                                                height="15"
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
                                                        </button>

                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p>No submissions found.</p>
                    @endif
                </div>



                <div id="abandonModal" class="modal">
                    <div class="modal-content">
                        <h2>Are you sure you want to abandon this document?</h2>
                        <p>You can still recover this document later.</p>
                        <div class="modal-actions">
                            <form action="../../controls/student/document_action.php" method="POST">
                                <input type="hidden" name="document_id" class="documentIdInput">
                                <input type="hidden" name="action" value="abandon">
                                <button type="submit" class="batan confirm">Confirm</button>
                                <button type="button" class="batan cancel" onclick="closeModal('abandonModal')">Cancel</button>
                            </form>
                        </div>
                    </div>
                </div>

                <div id="recoverModal" class="modal">
                    <div class="modal-content">
                        <h2>Recover this document?</h2>
                        <div class="modal-actions">
                            <form action="../../controls/student/document_action.php" method="POST">
                                <input type="hidden" name="document_id" class="documentIdInput">
                                <input type="hidden" name="action" value="recover">
                                <button type="submit" class="batan confirm">Confirm</button>
                                <button type="button" class="batan cancel" onclick="closeModal('recoverModal')">Cancel</button>
                            </form>
                        </div>
                    </div>
                </div>

                <div id="removepermModal" class="modal">
                    <div class="modal-content">
                        <h2>Are you sure you want to delete this document permanently?</h2>
                        <p>You cannot recover this document if you delete it permanently.</p>
                        <div class="modal-actions">
                            <form action="../../controls/student/document_action.php" method="POST">
                                <input type="hidden" name="document_id" class="documentIdInput">
                                <input type="hidden" name="action" value="delete">
                                <button type="submit" class="batan confirm">Confirm</button>
                                <button type="button" class="batan cancel" onclick="closeModal('removepermModal')">Cancel</button>
                            </form>
                        </div>
                    </div>
                </div>

                <script>
                    function openModal(modalId, documentId) {
                        const modal = document.getElementById(modalId);
                        modal.style.display = "block";

                        // Set document ID only
                        modal.querySelector('[name="document_id"]').value = documentId;
                    }

                    function closeModal(modalId) {
                        document.getElementById(modalId).style.display = "none";
                    }

                    // Close modal if clicking outside of it
                    window.onclick = function(event) {
                        const modals = ['abandonModal', 'recoverModal', 'removepermModal'];
                        modals.forEach(modalId => {
                            const modal = document.getElementById(modalId);
                            if (event.target === modal) {
                                closeModal(modalId);
                            }
                        });
                    };
                </script>
            </div>
        </div>

        <footer>
        </footer>
    </main>
</body>
</html>
<script src="../js/status.js"></script>
