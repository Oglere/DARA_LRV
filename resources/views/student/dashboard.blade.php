<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>DARA - Student Dashboard</title>
    <link rel="stylesheet" href="{{ asset('css/std.css') }}">
    <link rel="stylesheet" href="{{ asset('css/mainpage.css') }}">
    <link rel="stylesheet" href="{{ asset('css/std_control.css') }}">
    <link rel="stylesheet" href="{{ asset('css/svg.css') }}">
</head>
<body style="height: calc(100% - 61px);">
    <main>
        <header> 
            <div class="ahh">
                <img src="../Imgs/DARA.png" alt="" class="ahh">
            </div>
        </header> 
         
        <div class="main" style="height: 100%;">
            <div class="left">
                <div class="profile">
                    <h2>{{ auth()->user()->first_name }}</h2>
                    
                </div>

                <nav class="nav-links">
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
                            class="feather feather-home"
                            >
                            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
                            <polyline points="9 22 9 12 15 12 15 22" />
                        </svg>

                        Dashboard
                    </a>
                    <a href="student/document-submission">
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
                    <a href="student/document-status">
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
                    <a href="student/edit" class="unq">Edit Account</a>

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

                <h1>Welcome, {{ auth()->user()->first_name }}! You have</h1>

                    <div class="cardco">
                        <div class="cards submit">
                            <div class="svg1">
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    width="100"
                                    height="100"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="2"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    class="feather feather-book"
                                    >
                                    <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20" />
                                    <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z" />
                                </svg>
                            </div>

                            <div class="count">
                                {{ $total_submit }}
                            </div>

                            <div class="text">
                                <p>SUBMITTED STUDIES</p>
                            </div>
                        </div>

                        <div class="cards published">
                            <div class="svg2">
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    width="100"
                                    height="100"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="2"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    class="feather feather-check-square"
                                    >
                                    <polyline points="9 11 12 14 22 4" />
                                    <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11" />
                                </svg>
                            </div>

                            <div class="count">
                                {{ $total_approved }}
                            </div>

                            <div class="text">
                                <p>APPROVED STUDIES</p>
                            </div>
                        </div>

                        <div class="cards pending">
                            <div class="svg3">
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    width="100"
                                    height="100"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="2"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    class="feather feather-loader"
                                    >
                                    <line x1="12" y1="2" x2="12" y2="6" />
                                    <line x1="12" y1="18" x2="12" y2="22" />
                                    <line x1="4.93" y1="4.93" x2="7.76" y2="7.76" />
                                    <line x1="16.24" y1="16.24" x2="19.07" y2="19.07" />
                                    <line x1="2" y1="12" x2="6" y2="12" />
                                    <line x1="18" y1="12" x2="22" y2="12" />
                                    <line x1="4.93" y1="19.07" x2="7.76" y2="16.24" />
                                    <line x1="16.24" y1="7.76" x2="19.07" y2="4.93" />
                                </svg>
                            </div>

                            <div class="count">
                                {{ $total_pending }}
                            </div>

                            <div class="text">
                                <p>PENDING STUDIES</p>
                            </div>
                        </div>

                        <div class="cards revisions">
                            <div class="svg4">
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    width="100"
                                    height="100"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="2"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    class="feather feather-info"
                                    >
                                    <circle cx="12" cy="12" r="10" />
                                    <line x1="12" y1="16" x2="12" y2="12" />
                                    <line x1="12" y1="8" x2="12.01" y2="8" />
                                </svg>
                            </div>

                            <div class="count">
                                {{ $total_revisions }}
                            </div>

                            <div class="text">
                                <p>REVISIONS TO DO</p>
                            </div>
                        </div>
                        
                        <div class="cards rejected">
                            <div class="svg5">
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    width="120"
                                    height="120"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="2"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    class="feather feather-x"
                                    >
                                    <line x1="18" y1="6" x2="6" y2="18" />
                                    <line x1="6" y1="6" x2="18" y2="18" />
                                </svg>
                            </div>

                            <div class="count">
                                {{ $total_rejected }}
                            </div>

                            <div class="text">
                                <p>REJECTED STUDIES</p>
                            </div>
                        </div>
                    </div>
            </div>
        </div>

        <footer>
        </footer>
    </main>
</body>
</html>
<script src="js/index.js"></script>
