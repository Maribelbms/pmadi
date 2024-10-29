@extends('layouts.app')
@section('title', 'Inicio')

@section('content')
     <!-- Seccion Inicio -->
     <section id="inicio" class="hero section dark-background">

        <img src="img/JACHA-UTA-GAMEA.jpg" alt="" data-aos="fade-in">

        <div class="container text-center" data-aos="fade-up" data-aos-delay="100">
          <div class="row justify-content-center">
            <div class="col-lg-8">
              <h2>Bienvenid@ a PMADI</h2>
                <p>Programa Municipal de Apoyo al Desarrollo Infantil, bono que ayuda a fortalecer sus educación.</p>
                <a href="#verify" class="btn-get-started">Verificar Datos</a>
            </div>
          </div>
        </div>
  
      </section><!-- /Seccion Inicio -->

      <!-- Seccion Acerca De -->
      <section id="acerca" class="about section">

        <!-- Section Title -->
        <div class="container section-title" data-aos="fade-up">
          <h2>Acerca del Programa</h2>
          <p>El Programa Municipal de Apoyo al Desarrollo Infantil (PMADI) tiene como objetivo ayudar a las familias con bonos que aseguren la educación continua de los niños.</p>
        </div><!-- End Section Title -->
      
        <div class="container">
      
          <div class="row gy-3">
            <div class="col-lg-6" data-aos="fade-up" data-aos-delay="100">
              <!-- Carousel Implementado -->
              <div id="aboutCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="3000">
                <div class="carousel-inner">
                  <div class="carousel-item active">
                    <img src="img/JACHA-UTA-GAMEA.jpg" class="d-block w-100" alt="Primera imagen PMADI">
                  </div>
                  <div class="carousel-item">
                    <img src="img/pmadifondo.jpg" class="d-block w-100" alt="Segunda imagen PMADI">
                  </div>
                  <div class="carousel-item">
                    <img src="img/fondopmadi.jpg" class="d-block w-100" alt="Tercera imagen PMADI">
                  </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#aboutCarousel" data-bs-slide="prev">
                  <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                  <span class="visually-hidden">Anterior</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#aboutCarousel" data-bs-slide="next">
                  <span class="carousel-control-next-icon" aria-hidden="true"></span>
                  <span class="visually-hidden">Siguiente</span>
                </button>
              </div>
              <!-- End Carousel -->
            </div>
      
            <div class="col-lg-6 d-flex flex-column justify-content-center" data-aos="fade-up" data-aos-delay="200">
              <div class="about-content ps-0 ps-lg-3">
                <h3>Un bono para fortalecer la educación infantil</h3>
                <p class="fst-italic">
                  Este bono está diseñado para evitar la deserción escolar y apoyar a los niños en su desarrollo educativo.
                </p>
                <ul>
                  <li>
                    <i class="bi bi-emoji-smile"></i>
                    <div>
                      <h4>Bono para todos los niños en edad escolar</h4>
                      <p>El bono se otorga a niños entre 1 y 4 años para apoyar su crecimiento y desarrollo.</p>
                    </div>
                  </li>
                  <li>
                    <i class="bi bi-people"></i>
                    <div>
                      <h4>Facilidad de acceso para las familias</h4>
                      <p>Las familias pueden verificar y actualizar los datos de sus hijos a través del portal web.</p>
                    </div>
                  </li>
                </ul>
                <p>
                  Este programa está enfocado en garantizar que los niños reciban el apoyo necesario para completar su educación inicial, ofreciendo asistencia económica a sus familias.
                </p>
              </div>
            </div>
          </div>
      
        </div>
      
      </section><!-- /Seccion Acerca de -->

      <!-- Seccion Verificar Datos -->
      <section id="verify" class="verify section light-background">

        <div class="container section-title text-center" data-aos="fade-up">
            <img src="img/barra_slider.png" alt="Verificación de Datos PMADI" class="img-fluid">  <br><br>
          <h2 style="color: white!important; font-weight: bold!important;">Verificar Datos</h2>
          <p>Por favor, ingrese el CI del tutor para verificar los datos en el sistema PMADI.</p>
        </div>
      
        <div class="container">
      
          <!-- Formulario para Ingresar el CI -->
          <div class="row justify-content-center" data-aos="fade-up" data-aos-delay="100">
            <div class="col-lg-6 col-md-8">
              <form id="verification-form" class="verification-form p-4">
                <div class="mb-4">
                  <label for="ci" class="form-label">Ingrese CI del tutor</label>
                  <input type="text" class="form-control form-control-lg text-center" id="ci" placeholder="Ingrese el CI del tutor" required>
                </div>
                <div class="d-grid gap-2">
                  <button type="submit" class="btn-get-started">Consultar</button>
                </div>
              </form>
            </div>
          </div>
      
          <!-- Resultado de la Verificación -->
          <div class="row justify-content-center mt-5" data-aos="fade-up" data-aos-delay="200">
            <div class="col-lg-8" id="verification-result" style="display: none;">
              <div class="alert alert-info text-center">
                <strong>Resultado:</strong> Los datos han sido verificados correctamente.
              </div>
            </div>
          </div>
      
        </div>
      
      </section>
      
  
    <!-- /Seccion Verificar Datos -->
    <!-- Comunicados Section -->
    <section id="comunicados" class="comunicados section">

        <!-- Section Title -->
        <div class="container section-title" data-aos="fade-up">
          <h2>Comunicados</h2>
          <p>Consulta los últimos comunicados del Programa Municipal de Apoyo al Desarrollo Infantil</p>
        </div><!-- End Section Title -->
  
        <div class="container" data-aos="fade-up" data-aos-delay="100">
  
          <div class="swiper init-swiper" data-speed="600" data-delay="5000" data-breakpoints="{ &quot;320&quot;: { &quot;slidesPerView&quot;: 1, &quot;spaceBetween&quot;: 40 }, &quot;1200&quot;: { &quot;slidesPerView&quot;: 3, &quot;spaceBetween&quot;: 40 } }">
            <script type="application/json" class="swiper-config">
               {
                  "loop": true,
                  "speed": 600,
                  "autoplay": {
                    "delay": 5000
                  },
                  "slidesPerView": "3",
                  "centeredSlides": false,
                  "spaceBetween": 20,
                  "pagination": {
                    "el": ".swiper-pagination",
                    "type": "bullets",
                    "clickable": true
                  },
                  "breakpoints": {
                    "320": {
                      "slidesPerView": 1,
                      "spaceBetween": 40
                    },
                    "768": {
                        "slidesPerView": 2,  
                        "spaceBetween": 20
                      },
                    "1200": {
                      "slidesPerView": 3,
                      "spaceBetween": 20
                    }
                  }
                }
              </script>
  
            <div class="swiper-wrapper">
  
              <!-- Comunicado item -->
              <div class="swiper-slide">
            <div class="comunicado-item">
              <p>
                <i class="bi bi-megaphone quote-icon-left"></i>
                <span>Reunion Informativa</span>
                <i class="bi bi-megaphone quote-icon-right"></i>
              </p>
              <img src="img/comunicados/acerca_de.jpeg" class="comunicado-img" alt="">
              <p class="mensaje-comunicado">El próximo lunes 25 de octubre se llevará a cabo una reunión informativa para los padres de familia a las 10:00 a.m. en el auditorio municipal.</p>
              <h4>25 de octubre, 2024</h4>
            </div>
              </div><!-- End comunicado item -->
  
              <div class="swiper-slide">
                <div class="comunicado-item">
                  <p>
                    <i class="bi bi-megaphone quote-icon-left"></i>
                    <span>Entrega de Documentos</span>
                    <i class="bi bi-megaphone quote-icon-right"></i>
                  </p>
                  <img src="img/comunicados/comunicado2.jpg" class="comunicado-img" alt="">
                  <p class="mensaje-comunicado">Se recuerda que el plazo para la entrega de documentos de inscripción al programa vence el 30 de octubre de 2024.</p>
                  <h4>30 de octubre, 2024</h4>
                </div>
              </div><!-- End comunicado item -->
  
              <div class="swiper-slide">
                <div class="comunicado-item">
                  <p>
                    <i class="bi bi-megaphone quote-icon-left"></i>
                    <span>Verificación de Datos</span>
                    <i class="bi bi-megaphone quote-icon-right"></i>
                  </p>
                  <img src="img/comunicados/comunicado3.jpg" class="comunicado-img" alt="">
                  <p class="mensaje-comunicado">Se ha habilitado el portal para que los tutores puedan verificar los datos de los estudiantes registrados en el programa PMADI.</p>
                  <h4>En línea</h4>
                </div>
              </div><!-- End comunicado item -->
  
            </div>
            <div class="swiper-pagination"></div>
          </div>
  
        </div>
  
    </section>
    <!-- /Comunicados Section -->
    <!-- Contact Section -->
    <section id="contacto" class="contact section">

        <!-- Section Title -->
        <div class="container section-title" data-aos="fade-up">
          <h2 style="color: white!important; font-weight: bold!important;">Contacto</h2>
          <p>Para más información sobre el Programa Municipal de Apoyo al Desarrollo Infantil, contáctanos a través de los siguientes medios:</p>
        </div><!-- End Section Title -->
  
        <div class="container" data-aos="fade-up" data-aos-delay="100">
  
          <div class="row gy-4 justify-content-center">
  
            <div class="col-lg-8">
  
              <div class="info-wrap">
                <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="200">
                  <i class="bi bi-geo-alt flex-shrink-0"></i>
                  <div>
                    <h3>Dirección</h3>
                    <p>A108 Calle Principal, Ciudad El Alto, Bolivia</p>
                  </div>
                </div><!-- End Info Item -->
  
                <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="300">
                  <i class="bi bi-telephone flex-shrink-0"></i>
                  <div>
                    <h3>Teléfono</h3>
                    <p>+591 123 45678</p>
                  </div>
                </div><!-- End Info Item -->
  
                <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="400">
                  <i class="bi bi-envelope flex-shrink-0"></i>
                  <div>
                    <h3>Correo Electrónico</h3>
                    <p>info@pmadi-elalto.com</p>
                  </div>
                </div><!-- End Info Item -->
  
                <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d48389.78314118045!2d-74.006138!3d40.710059!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c25a22a3bda30d%3A0xb89d1fe6bc499443!2sDowntown%20Conference%20Center!5e0!3m2!1ses!2sus!4v1676961268712!5m2!1ses!2sus" frameborder="0" style="border:0; width: 100%; height: 270px;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
              </div>
            </div>
  
          </div>
  
        </div>
  
    </section>
    <!-- /Contact Section -->
  
  
  
  

  @endsection