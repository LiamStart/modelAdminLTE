@auth()
    @include('home')
@endauth()
@guest()
    @extends('vendor.adminlte.login')
@endguest
