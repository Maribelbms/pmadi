<header id="header" class="header d-flex align-items-center fixed-top">
   
  <div class="container-fluid container-xl position-relative d-flex align-items-center justify-content-between">

      <a href="index.html" class="logo d-flex align-items-center">
        <!-- Uncomment the line below if you also wish to use an image logo -->
        <img src="img/logo_elalto.png" alt=""> 
        {{-- <h1 class="sitename">Maxim</h1> --}}
      </a>

      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="#inicio" class="active">Inicio</a></li>
          <li><a href="#acerca">Acerca de</a></li>
          <li><a href="#verify">Verificar Datos</a></li>
          <li><a href="#comunicados">Comunicados</a></li>
          <li><a href="#contacto">Contacto</a></li>
          <li class="nav-link-login">
            <a href="{{ route('login') }}" class="nav-link">Iniciar Sesión
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-login-2" width="44" height="44" viewBox="0 0 24 24" stroke-width="1.5" stroke="#fff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <path d="M9 8v-2a2 2 0 0 1 2 -2h7a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-7a2 2 0 0 1 -2 -2v-2" />
                    <path d="M3 12h13l-3 -3" />
                    <path d="M13 15l3 -3" />
                </svg>
            </a>
           </li>        
    </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>

    </div>
    @livewireStyles
  </header>