<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
</head>
<body class="bg-gray-100 h-screen antialiased leading-none font-sans">
<div id="app" class="flex flex-col min-h-screen ">
    <header class="bg-blue-900 py-6">
        <div class="container mx-auto flex flex-col md:flex-row justify-between items-center px-6">
            <div>
                <a href="{{ route('home') }}" class="text-lg font-semibold text-gray-100 no-underline">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <a href="{{ route('show-posts') }}" class="text-lg ml-5 font-semibold text-gray-100 no-underline">
                    Posts
                </a>
            </div>
            <nav class="space-x-4 text-gray-300 text-sm sm:text-base mt-3 md:mt-0">
                @guest
                    <a class="no-underline hover:underline" href="{{ route('login') }}">{{ __('Login') }}</a>
                    @if (Route::has('register'))
                        <a class="no-underline hover:underline" href="{{ route('register') }}">{{ __('Register') }}</a>
                    @endif
                @else
                    <img class="profile-image" src="{{\Illuminate\Support\Facades\Auth::user()->present()->photourl}}"
                         alt="">
                    <span>{{ Auth::user()->name }}</span>

                    <a href="{{ route('logout') }}"
                       class="no-underline hover:underline"
                       onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">{{ __('Logout') }}</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                        {{ csrf_field() }}
                    </form>
                @endguest
            </nav>
        </div>
    </header>

    <div class="flex-grow">
        @yield('content')
    </div>

    <header class="bg-blue-900 py-6 mt-7">
        <div class="text-center px-6 text-white">
            <p>Tasks List &copy; {{date('Y')}}</p>
        </div>
    </header>
</div>
<script type="text/javascript"  src="{{asset('/js/jquery-3.6.0.min.js')}}"></script>
<script type="text/javascript"  src="{{asset('/js/sweetalert.min.js')}}"></script>
<script type="text/javascript"  src="{{ asset('/js/app.js') }}" defer></script>
<script type="text/javascript">

    $(document).ready(function () {
        $('.delete-confirm').on('click', function (event) {
            event.preventDefault();
            const url = $(this).attr('href');
            swal({
                title: 'Are you sure?',
                text: 'This record and it`s details will be permanently deleted!',
                icon: 'warning',
                buttons: ["Cancel", "Yes!"],
            }).then(function (value) {
                if (value) {
                    window.location.href = url;
                }
            });
        });

    });


</script>
</body>
</html>
