<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>DARA - Review Studies</title>
    <link rel="stylesheet" href="{{ asset ('css/std.css') }}">
    <link rel="stylesheet" href="{{ asset ('css/mainpage.css') }}">
    <link rel="stylesheet" href="{{ asset ('css/std_control.css') }}">
    <link rel="stylesheet" href="{{ asset ('css/tch.pdf.css') }}">
    <link rel="stylesheet" href="{{ asset ('css/notif.css')}}">
    <link rel="stylesheet" href="{{ asset ('css/usercontrol.css')}}">
</head>
<body>
    <main>
        <header> 
            <div class="ahh">
                <img src="../../Imgs/DARA.png" alt="" class="ahh">
            </div>
        </header>
         
        <div class="main" style="height: 100%;">
            <div class="left">
                <div class="profile">
                    <h2> {{ auth()->user()->first_name }} </h2> <!-- Display student's username -->
                    
                </div>

                <nav class="nav-links">
                    <a href="/teacher"> 
                        <svg
                            style="margin-right: 10px;"
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
                    <a href="" style="color: #04128e; font-weight: normal;">
                        <svg
                            style="margin-right: 10px;"
                            xmlns="http://www.w3.org/2000/svg"
                            width="24"
                            height="24"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            class="feather feather-book-open"
                            >
                            <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z" />
                            <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z" />
                        </svg>

                        Review Studies
                    </a>

                    <div class="asd2" style=" width: 100%; margin-top: 10px; display: flex; justify-content: center;">
                        <div class="asd3" style="border-bottom: 1px solid grey; width: 150px;"></div>
                    </div>

                    <a href="/" class="unq">Search Studies</a>
                    <a href="/teacher/edit" class="unq">Edit Account</a>

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
                            &nbsp;
                            Logout
                        </button>
                    </form>
                </nav>
            </div>
 
            <div class="right">
                <div class="clol">
                    <div class="nh">
                        <input type="text" id="search-bar" placeholder="Search studies by name or title.." oninput="filterUsers()">
                        <div class="aridiri">
                            <button class="btn-primary filter-btn" data-role="all">All</button>
                            <button class="btn-secondary filter-btn" data-role="Approved">Others</button>
                        </div>
                    </div>

                    @if($documents->count() > 0)
                    @foreach($documents as $doc)
                        @php
                            $authors = $doc->authors; // no need to json_decode
                            $study_types = is_string($doc->study_type) ? json_decode($doc->study_type, true) : $doc->study_type;
                        @endphp

                        <div class="nb">
                            <div class="ch">
                                <div class="chp">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="40px" height="40px" viewBox="0 0 24 24" fill="none">
                                        <path d="M12.12 12.78C12.05 12.77 11.96 12.77 11.88 12.78C10.12 12.72 8.71997 11.28 8.71997 9.50998C8.71997 7.69998 10.18 6.22998 12 6.22998C13.81 6.22998 15.28 7.69998 15.28 9.50998C15.27 11.28 13.88 12.72 12.12 12.78Z" stroke="#292D32" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M18.74 19.3801C16.96 21.0101 14.6 22.0001 12 22.0001C9.40001 22.0001 7.04001 21.0101 5.26001 19.3801C5.36001 18.4401 5.96001 17.5201 7.03001 16.8001C9.77001 14.9801 14.25 14.9801 16.97 16.8001C18.04 17.5201 18.64 18.4401 18.74 19.3801Z" stroke="#292D32" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z" stroke="#292D32" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </div>
                                <div class="chn">
                                    {{ $doc->student->first_name ?? '' }} {{ $doc->student->last_name ?? '' }}
                                </div>
                                <div class="cht">
                                    {{ \Carbon\Carbon::parse($doc->date_submitted)->format('n/j/y \a\t g:iA') }}
                                </div>
                                <div class="chd">
                                    <button>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                            class="feather feather-more-horizontal">
                                            <circle cx="12" cy="12" r="1" />
                                            <circle cx="19" cy="12" r="1" />
                                            <circle cx="5" cy="12" r="1" />
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            <div class="cb">
                                <a href="{{ url('studies/' . $doc->document_id) }}">
                                    {{ $doc->title }}
                                </a>
                            </div>

                            <div class="cf">
                                <div class="studytype">
                                    @if(is_array($study_types))
                                        @foreach($study_types as $type)
                                            <div class="sc">{{ $type }}</div>
                                        @endforeach
                                    @else
                                        <div class="sc">{{ $doc->study_type }}</div>
                                    @endif
                                </div>
                                <div class="status">Pending</div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <p class="no-studies">No pending studies found.</p>
                @endif
                </div>
            </div>
        </div>

        <footer>
        </footer>
    </main>
</body>
</html>

<script src="{{ asset('js/notif.js') }}"> </script>