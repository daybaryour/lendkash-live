@include('layouts._head')
    <body >
    @include('layouts._header')
    @include('layouts._sidebar')
    @include('message')
    @yield('content')

    @include('layouts._footer')


    </body>
</html>
