@if (Auth::check())
    <script>window.location.href = "{{ url('/') }}";</script>
    <?php exit(); ?>
@endif

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>DARA - Login</title>
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <link rel="stylesheet" href="{{ asset('css/mainpage.css') }}">
</head>
<body> 
    <main>
        <div class="lain"> 
            <div class="ahh">
                @include('../layouts/search_material/search_bar')
            </div>
        </div>
        <div class="contents">
            <h1>D A R A</h1>

            <form method="POST" action="/go/login">
                @csrf
                <div class="inputs">
                    <div class="user">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                            <circle cx="12" cy="7" r="4"></circle>
                        </svg>
                        <input type="text" name="usn_login" value="{{ old('usn') }}" required placeholder="Username">
                        
                    </div>

                    <div class="pass">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-key">
                            <path d="M21 2l-2 2m-7.61 7.61a5.5 5.5 0 1 1-7.778 7.778 5.5 5.5 0 0 1 7.777-7.777zm0 0L15.5 7.5m0 0l3 3L22 7l-3-3m-3.5 3.5L19 4"></path>
                        </svg>
                        <input type="password" name="password_hash_login" required placeholder="Password">
                        
                    </div>    
                </div>

                <div class="ubos">
                    <button name="submitlogin" type="submit">L O G I N</button>

                    @if (session('error'))
                        
                    @endif
                    @if ($errors->error)
                        <div style="color: red; margin-top: 10px;">
                            @foreach ($errors->all() as $error)
                                {{ $error }}
                            @endforeach
                        </div>
                    @endif

                    <a href="/go/recovery">Forgot Password?</a>
                </div>
            </form>
        </div>
    </main>

    
</div>

</body>
</html>
