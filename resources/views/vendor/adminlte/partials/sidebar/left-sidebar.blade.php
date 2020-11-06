
<aside class="main-sidebar {{config('adminlte.classes_sidebar', 'sidebar-dark-primary elevation-4')}} ">
    
    {{-- Sidebar brand logo --}}
    @if(config('adminlte.logo_img_xl'))
        @include('adminlte::partials.common.brand-logo-xl')
    @else
        @include('adminlte::partials.common.brand-logo-xs')
    @endif

    {{-- Sidebar menu --}}
    @php
        $rolUsuario = Auth::user()->id_tipo;
    
        $sidebar = $_SERVER["REQUEST_URI"];
    @endphp
    <div class="sidebar text-sm">
        <nav class="mt-2">
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                <img src="{{asset('/img/users/'.Auth::user()->url_image)}}" class="img-circle elevation-2" alt="User Image">
                </div>
                <div class="info">
                <a href="#" class="d-block">{{Auth::user()->name}}</a>

                </div>
            </div>
            <ul class="nav nav-pills nav-sidebar flex-column {{config('adminlte.classes_sidebar_nav', '')}} nav-flat nav-child-indent"
                data-widget="treeview" role="menu"
                @if(config('adminlte.sidebar_nav_animation_speed') != 300)
                    data-animation-speed="{{ config('adminlte.sidebar_nav_animation_speed') }}"
                @endif
                @if(!config('adminlte.sidebar_nav_accordion'))
                    data-accordion="false"
                @endif>
                {{-- Configured sidebar links --}}
                <li class="nav-item">
                            <a href="{{route('dashboard')}}" class="nav-link @if(strrpos($sidebar, 'dashboard')) active @endif">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>
                                Dashboard

                            </p>
                            </a>
                </li>
                @if($rolUsuario==1)
                <li class="nav-item ">
                    <a class="nav-link @if(strrpos($sidebar, '/user')) active @endif  " href="{{url('/user')}}">
                        <i class="nav-icon fas fa-fw fa-address-card "></i>
                       
                        <p>
                            Manejo de Usuarios

                        </p>
                    </a>
                </li>
                @endif
                
                <li class="nav-item ">
                    <a class="nav-link @if(strrpos($sidebar, '/profile')) active @endif " href="{{url('/profile')}}">
                        <i class="nav-icon fas fa-fw fa-user "></i>
                       
                        <p>
                            Perfil

                        </p>
                    </a>
                </li>
                @if($rolUsuario==1)
                <li  class="nav-item has-treeview @if(strrpos($sidebar, 'caja')) menu-open @elseif(strrpos($sidebar, 'cliente')) menu-open  @elseif(strrpos($sidebar, 'pregunta')) menu-open   @elseif(strrpos($sidebar, 'empleados')) menu-open  @elseif(strrpos($sidebar, '/tipo')) menu-open @endif"">
                        <a class="nav-link nav-item   href="#">
                            <i class="nav-icon fas fa-warehouse"></i>
                           
                            <p>
                                Mantenimientos

                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                       
                        <ul class="nav nav-treeview ">
                                <li  class="nav-item  ">
                                        <a class="nav-link @if(strrpos($sidebar, '/tipo')) active @endif" href="{{route('tipo_pregunta')}}">
                                            <i class="nav-icon fas fa-box"></i>
                                           
                                            <p>Tipo Pregunta</p>
                                        </a>
                                </li>
                        </ul>
                      
                        <ul class="nav nav-treeview">
                            <li class="nav-item ">
                                <a class="nav-link @if(strrpos($sidebar, '/pregunta')) active @endif " href="{{route('pregunta')}}">
                                    <i class="nav-icon fas fa-fw fa-user "></i>
                                
                                    <p>
                                        Preguntas

                                    </p>
                                </a>
                            </li>
                        </ul>
                        
                </li>
                @endif
                
               


                <li  class="nav-item has-treeview @if(strrpos($sidebar, 'test')) menu-open  @elseif(strrpos($sidebar, 'mytest')) menu-open   @endif"">
                        <a class="nav-link nav-item   href="#">
                            <i class="nav-icon fas fa-warehouse"></i>
                           
                            <p>
                                Test

                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                         <li  class="nav-item  ">
                            <a class="nav-link @if(strrpos($sidebar, '/test')) active @endif " href="{{route('test')}}">
                                <i class="nav-icon fas fa-fw fa-user "></i>
                            
                                <p>
                                    Realizar Test

                                </p>
                            </a>
                         </li>
                        </ul>
                        <ul class="nav nav-treeview">
                        <li  class="nav-item  ">
                            <a class="nav-link @if(strrpos($sidebar, '/mytest')) active @endif " href="{{route('my.test')}}">
                                <i class="nav-icon fas fa-fw fa-user "></i>
                            
                                <p>
                                    Mis Test

                                </p>
                            </a>
                            </li>
                        </ul>
                        
                        
                </li>
                @if($rolUsuario==1)
                <li class="nav-item ">
                    <a class="nav-link @if(strrpos($sidebar, '/xestadisticos')) active @endif " href="{{url('/xestadisticos')}}">
                    <i class="nav-icon fas fa-chart-pie"></i>
                       
                        <p>
                            Estadisticos

                        </p>
                    </a>
                </li>
                @endif
                <!--
                <li  class="nav-item has-treeview @if(strrpos($sidebar, '/asignar')) menu-open @elseif(strrpos($sidebar,'/resumen')) menu-open @elseif(strrpos($sidebar,'/flujo')) menu-open @endif">
                        <a class="nav-link nav-item " href="#">
                             <i class="nav-icon fas fa-boxes"></i>
                            
                            <p>
                                Caja

                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        @if($rolUsuario==1)
                        <ul class="nav nav-treeview">
                                <li  class="nav-item ">
                                    <a class="nav-link @if(strrpos($sidebar, '/asignar')) active @endif " href="{{route('caja.asignacion')}}">
                                        <i class="nav-icon fas fa-clipboard"></i>
                                    
                                        <p>
                                            Asignar Caja

                                        </p>
                                    </a>
                                </li>
                        </ul>

                        <ul class="nav nav-treeview">
                                <li  class="nav-item ">
                                        <a class="nav-link @if(strrpos($sidebar, '/resumen')) active @endif" href="{{route('caja.resumen')}}">
                                        <i class="nav-icon fas fa-file-invoice-dollar"></i>
                                       
                                            <p>Resumen</p>
                                        </a>
                                </li>
                        </ul>
                        @endif
                        <ul class="nav nav-treeview">
                                <li  class="nav-item ">
                                        <a class="nav-link @if(strrpos($sidebar, '/flujo')) active @endif" href="{{route('caja.midetallecaja')}}">
                                        <i class="nav-icon fas fa-file-invoice-dollar"></i>
                                       
                                            <p>Flujo</p>
                                        </a>
                                </li>
                        </ul>
                        
                </li>
                <li  class="nav-item has-treeview @if(strrpos($sidebar, '/producto')) menu-open @elseif(strrpos($sidebar,'/movimiento')) menu-open @elseif(strrpos($sidebar,'/insumos')) menu-open @endif">
                        <a class="nav-link nav-item " href="#">
                             <i class="nav-icon fas fa-dolly"></i>
                            
                            <p>
                                Almacén

                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                                <li  class="nav-item ">
                                        <a class="nav-link @if(strrpos($sidebar, '/producto')) active @endif" href="{{route('producto')}}">
                                        <i class="nav-icon fas fa-boxes"></i>
                                       
                                            <p>Producto</p>
                                        </a>
                                </li>
                        </ul>
                        <ul class="nav nav-treeview">
                                <li  class="nav-item ">
                                        <a class="nav-link @if(strrpos($sidebar, '/insumos')) active @endif" href="{{route('insumos')}}">
                                        <i class="nav-icon fas fa-boxes"></i>
                                       
                                            <p>Insumos</p>
                                        </a>
                                </li>
                        </ul>
                        @if($rolUsuario==1)
                        <ul class="nav nav-treeview">
                                <li  class="nav-item ">
                                        <a class="nav-link @if(strrpos($sidebar, '/movimiento')) active @endif" href="{{route('movimiento')}}">
                                           <i class="nav-icon fas fa-search"></i>
                                          
                                            <p>Kardex</p>
                                        </a>
                                </li>
                        </ul>
                        @endif
                </li>
                <li class="nav-item ">
                    <a class="nav-link @if(strrpos($sidebar, 'factura/ingreso')) active @endif " href="{{route('factura_ingreso')}}">
                        <i class="nav-icon fas fa-shopping-bag"></i>
                       
                        <p>
                            Pago Nómina

                        </p>
                    </a>
                </li>
                
                <li class="nav-item ">

                </li>
                <li class="nav-item ">
                                        <a class="nav-link @if(strrpos($sidebar, '/entrega')) active @endif" href="{{route('entrega')}}">
                                            <i class="nav-icon fas fa-truck"></i>
                                           
                                            <p>Entrega Insumo</p>
                                        </a>    
                </li>
                <li class="nav-item ">
                
                                        <a class="nav-link @if(strrpos($sidebar, '/ingresar')) active @endif" href="{{route('producto.ingreso')}}">
                                        <i class=" nav-icon fas fa-shipping-fast"></i>
                                            <p>  Recepción Producto </p>
                                        </a>
                               
                </li>

                <li  class="nav-item has-treeview @if(strrpos($sidebar, 'ventas')) menu-open @elseif(strrpos($sidebar,'ventas.create')) menu-open @endif">
                        <a class="nav-link nav-item " href="#">
                             <i class="nav-icon fas fa-dolly"></i>
                            
                            <p>
                                Ventas

                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item  ">
                                <a class="nav-link @if(strrpos($sidebar, '/ventas')) active @endif " href="{{route('ventas')}}">
                                    <i class="nav-icon fas fa-receipt"></i>
                                   
                                    <p>
                                        Facturas

                                    </p>
                                </a>
                            </li>
                            <li class="nav-item  ">
                                <a class="nav-link @if(strrpos($sidebar, 'fventas/crear')) active @endif " href="{{route('ventas.create')}}">
                                    <i class=" nav-icon fas fa-receipt"></i>
                                   
                                    <p>
                                        Nueva Factura

                                    </p>
                                </a>
                            </li>

                        </ul>

                </li>-->
        </nav>

    </div>

</aside>
