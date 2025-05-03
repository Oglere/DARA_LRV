<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Admin - Storage</title>
        <link rel="stylesheet" href="{{asset ('css/std.css')}}">
        <link rel="stylesheet" href="{{asset ('css/mainpage.css')}}">
        <link rel="stylesheet" href="{{asset ('css/std_control.css')}}">
        <link rel="stylesheet" href="{{asset ('css/usercontrol.css')}}">
        <link rel="stylesheet" href="{{asset ('css/yey.css')}}">
    </head>
    <body style="height: calc(100% - 61px);">
        <main>
            <header> 
                <div class="ahh">
                    <img src="../../Imgs/DARA.png" alt="DARA Logo" class="ahh">
                </div>
            </header>

            <div class="main" style="height: 100%;">
                <div class="left">
                    <div class="profile">
                        <h2>{{ auth()->user()->first_name }}</h2>
                    </div>

                    <nav class="nav-links">
                        <a href="/admin"> 
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
                        <a href="user-control">
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
                                class="feather feather-users"
                                >
                                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                                <circle cx="9" cy="7" r="4" />
                                <path d="M23 21v-2a4 4 0 0 0-3-3.87" />
                                <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                            </svg>
                            Manage Users
                        </a>

                        <a href="" style="color: #04128e; font-weight: normal;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-database">
                                <ellipse cx="12" cy="5" rx="9" ry="3"/>
                                <path d="M21 12c0 1.66-4 3-9 3s-9-1.34-9-3"/>
                                <path d="M3 5v14c0 1.66 4 3 9 3s9-1.34 9-3V5"/>
                            </svg>

                            Storage
                        </a>

                        <div class="asd2" style=" width: 100%; margin-top: 10px; display: flex; justify-content: center;">
                            <div class="asd3" style="border-bottom: 1px solid rgb(0, 0, 0, 0.2); width: 150px;"></div>
                        </div>

                        <a href="../../" class="unq">Search Studies</a>
                        <a href="edit" class="unq">Edit Account</a>
                        <a href="recovery" class="unq">Recovery</a>

                        <div class="asd2" style=" width: 100%; 10px; display: flex; justify-content: center;">
                            <div class="asd3" style="border-bottom: 1px solid rgb(0, 0, 0, 0.2); width: 150px;"></div>
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

                <div class="right" style="overflow: auto; padding: 20px; display: flex; width: 100%;">
                    <div class="actions asd25">
                        <form method="GET" action="" class="filter-group" style="display: flex; align-items: center;">
                            <input style="margin: 0; padding: 0; padding-left: 10px; height: calc(38px - 1.33px); border-top-right-radius: 0; border-bottom-right-radius: 0;" type="text" name="search" id="search-bar" placeholder="Search users by name or email..." value="{{ request('search') }}">
                            
                            <select name="status" onchange="this.form.submit()">
                                <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>All</option>
                                <option value="Approved" {{ request('status') == 'Approved' ? 'selected' : '' }}>Published</option>
                                <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                                <option value="Needs Revision" {{ request('status') == 'Needs Revision' ? 'selected' : '' }}>Needs Revision</option>
                                <option value="Rejected" {{ request('status') == 'Rejected' ? 'selected' : '' }}>Rejected</option>
                                <option value="LostDoc" {{ request('status') == 'LostDoc' ? 'selected' : '' }}>Deleted</option>
                            </select>

                            <button class="atayaaa" type="submit">
                                <svg
                                    class="esbiji"
                                    xmlns="http://www.w3.org/2000/svg"
                                    width="24"
                                    height="24"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="2"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    class="feather feather-search"
                                >
                                    <circle cx="11" cy="11" r="8" />
                                    <line x1="21" y1="21" x2="16.65" y2="16.65" />
                                </svg>
                            </button>
                        </form>

                    </div>
                    <table>
                        <thead>
                            <tr>
                                <th style="display: none;">ID</th>
                                <th>Title</th>
                                <th>Status</th>
                                <th>File Size</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($docu as $document)
                                <tr 
                                    style="color: 
                                    {{ $document->status === 'Approved' ? 'green' : ($document->status === 'Pending' ? '#04128e' : ($document->status === 'Rejected' ? '#8e0404' : ($document->status === 'Needs Revision' ? 'Orange' : 'black'))) }};" 
                                    data-id="{{ $document->document_id }}"
                                >
                                    <td style="display: none;">{{ $document->document_id }}</td>
                                    <td><a href="/admin/storage/read/{{ $document->document_id }}">{{ $document->title }}</a></td>
                                    <td>{{ $document->status }}</td>
                                    <td>{{ $document->formatted_size }}</td>
                                    <td>
                                        @if ($document->status === 'LostDoc')
                                            <button style="aspect-ratio: 1 / 1; background-color: black;" class="delete-btn permdelt" data-id="{{ $document->document_id }}">
                                                <svg style="margin: 0;" xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                                            </button>
                                            <button class="delete-btn recover" style="background-color: orange; aspect-ratio: 1 / 1;" data-id="{{ $document->document_id }}">
                                                <svg style="margin: 0;" xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-refresh-ccw"><polyline points="1 4 1 10 7 10"/><polyline points="23 20 23 14 17 14"/><path d="M20.49 9A9 9 0 0 0 5.64 5.64L1 10m22 4l-4.64 4.36A9 9 0 0 1 3.51 15"/></svg>
                                            </button>
                                        @else 
                                            <button style="aspect-ratio: 1 / 1;" class="delete-btn delete" data-id="{{ $document->document_id }}">
                                                <svg style="margin: 0;" xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="paginationlinks">
                        <div class="pagination-wrapper">
                            {{ $docu->links('pagination::bootstrap-5') }}  {{-- Optional: Bootstrap style --}}
                        </div>

                        <form class="pz" method="GET" action="{{ url()->current() }}">
                            <label for="page">Jump to:</label>
                            <input type="number" name="page" min="1" max="{{ $docu->lastPage() }}">
                            <button type="submit">Go</button>
                        </form>
                    </div>

                    <div class="phn" style="opacity: 0;">.</div>

                    <DIV class="overlay hidden"></DIV>

                    <div id="delete-modal" class="modal hidden">
                        <div class="modal-content">
                            <form id="delete-user-form" method="POST" action="">
                                @csrf
                                <h2>Confirm Deletion</h2>
                                <p>Are you sure you want to delete this document?</p>
                                
                                <input type="hidden" id="delete-user-id" name="user_id">

                                <div class="botoning">
                                    <button type="submit" id="confirm-delete" class="sab">Delete</button>
                                    <button type="button" id="cancel-delete" class="nac">Cancel</button>
                                </div>
                            </form>
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

<script src="{{ asset('js/docu.js') }}"> </script>
<script>
    function confirmAction(form) {
        if (confirm('Are you sure you want to mark this request as Done?')) {
            form.submit();
        } else {
            return false;
        }
    }
</script>