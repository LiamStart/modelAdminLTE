<nav class="main-header navbar
    {{ config('adminlte.classes_topnav_nav', 'navbar-expand-md') }}
    {{ config('adminlte.classes_topnav', 'navbar-white navbar-light') }}">
    {{-- Navbar left links --}}
    @php
      $sessiondata = Session::get('caja');
    @endphp
    <ul class="navbar-nav">
        {{-- Left sidebar toggler link --}}
        @include('adminlte::partials.navbar.left-sidebar-link')

        {{-- Aqui puede ir cualquier cosa arriba--}}
        {{ csrf_field() }}
       
        <!-- Voy a  hacer un isset value de la variable y se la paso por todo eltemplate-->
        {{-- Custom left links --}}
        @yield('content_top_nav_left')
    </ul>
     
    {{-- Navbar right links --}}
    <ul class="navbar-nav ml-auto">
        {{-- Custom right links --}}
        @yield('content_top_nav_right')

        {{-- Configured right links --}}
        @each('adminlte::partials.menuitems.menu-item-top-nav-right', $adminlte->menu(), 'item')

        {{-- User menu link --}}
        @if(Auth::user())
            @if(config('adminlte.usermenu_enabled'))
                @include('adminlte::partials.navbar.dropdown-user-menu')
            @else
                @include('adminlte::partials.navbar.logout-link')
            @endif
        @endif

        {{-- Right sidebar toggler link --}}
        @if(config('adminlte.right_sidebar'))
            @include('adminlte::partials.navbar.right-sidebar-link')
        @endif
    </ul>

</nav>
<script>
 function abrircaja(variable){
    var fecha= new Date();
    var hora= fecha.getHours();
    var minutos= fecha.getMinutes();
    var dia= fecha.getDate();
    var mm=new Date();
    var m2 = mm.getMonth() + 1;
    var mesok = (m2 < 10) ? '0' + m2 : m2;
    var mesok=new Array(12);
    console.log(variable);
    mesok[0]="Enero";
    mesok[1]="Febrero";
    mesok[2]="Marzo";
    mesok[3]="Abril";
    mesok[4]="Mayo";
    mesok[5]="Junio";
    mesok[6]="Julio";
    mesok[7]="Agosto";
    mesok[8]="Septiembre";
    mesok[9]="Octubre";
    mesok[10]="Noviembre";
    mesok[11]="Diciembre";
    var uno = document.getElementById('botoncaja');
    if((variable)==''|| (variable)==0 || isNaN(variable)){
        const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: 'btn btn-success separator',
            cancelButton: 'btn btn-danger separator'
        },
        buttonsStyling: false
        })

        swalWithBootstrapButtons.fire({
            title: '¿Deseas abrir caja?',
            text: "No puedes cerrar al instante!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: ' Si, abrir! ',
            cancelButtonText: ' No, cancel! ',
            reverseButtons: true
            }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: "{{route('caja.abrir')}}",
                    type:'GET',
                    datatype: 'html',
                    data: $('#formulario').serialize(),
                    success: function(datahtml, data){
                            console.log(data);
                            Swal.fire({
                                title: "¡Correcto!", 
                                html: datahtml,  
                                confirmButtonText: "Aceptar", 
                            });
                            uno.innerHTML='';
                            uno.innerHTML='<i class="fas fa-toggle-on"></i>';
                            window.setTimeout(function () {
                                location.reload(); 
                            }, 1000);
                            
                    },
                    error: function() {
                       console.log("error");
                        uno.innerHTML='';
                        uno.innerHTML='<i class="fas fa-times"></i>';
                    }
                });

            } else if (
                /* Read more about handling dismissals below */
                result.dismiss === Swal.DismissReason.cancel
            ) {
                swalWithBootstrapButtons.fire(
                'Cancelado',
                '',
                'error'
                )
            }
        })

    }else if(variable==1){
        const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: 'btn btn-success btn-xs separator',
            cancelButton: 'btn btn-danger btn-xs separator'
        },
        buttonsStyling: false
        })

        swalWithBootstrapButtons.fire({
            title: '¿Deseas cerrar caja?',
            text: "Si cierras caja, aceptas que estás conforme al cierre con el valor facturado",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: ' Si, cerrar caja! ',
            cancelButtonText: ' No, cancelar! ',
            reverseButtons: true
            }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: "{{route('caja.cierre')}}",
                    type:'GET',
                    datatype: 'html',
                    data: $('#formulario').serialize(),
                    success: function(datahtml, data){

                            Swal.fire({
                                title: "¡Correcto!", 
                                html: datahtml,  
                                confirmButtonText: "Aceptar", 
                            });
                            uno.innerHTML='';
                            uno.innerHTML='<i class="fas fa-toggle-off"></i>';
                            window.setTimeout(function () {
                                location.reload(); 
                            }, 1000);
                           
                            

                    },
                    error: function() {
                        Swal.fire('Correcto!','Se cerró caja '+' '+dia+' del Mes de '+mesok[mm.getMonth()]+' a las '+hora+':'+minutos,'success');
                        uno.innerHTML='';
                        uno.innerHTML='<i class="fas fa-money-check"></i>';
                    }
                });

            } else if (
                /* Read more about handling dismissals below */
                result.dismiss === Swal.DismissReason.cancel
            ) {
                swalWithBootstrapButtons.fire(
                'Cancelado',
                '',
                'error'
                )
            }
        })
    }

 }
</script>
