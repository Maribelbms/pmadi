
(function () {
  "use strict";


  function toggleScrolled() {
    const selectBody = document.querySelector('body');
    const selectHeader = document.querySelector('#header');
    if (!selectHeader.classList.contains('scroll-up-sticky') && !selectHeader.classList.contains('sticky-top') && !selectHeader.classList.contains('fixed-top')) return;
    window.scrollY > 100 ? selectBody.classList.add('scrolled') : selectBody.classList.remove('scrolled');
  }

  document.addEventListener('scroll', toggleScrolled);
  window.addEventListener('load', toggleScrolled);

  /**
   * Mobile nav toggle
   */
  const mobileNavToggleBtn = document.querySelector('.mobile-nav-toggle');

  function mobileNavToogle() {
    document.querySelector('body').classList.toggle('mobile-nav-active');
    mobileNavToggleBtn.classList.toggle('bi-list');
    mobileNavToggleBtn.classList.toggle('bi-x');
  }
  mobileNavToggleBtn.addEventListener('click', mobileNavToogle);

  /**
   * Hide mobile nav on same-page/hash links
   */
  document.querySelectorAll('#navmenu a').forEach(navmenu => {
    navmenu.addEventListener('click', () => {
      if (document.querySelector('.mobile-nav-active')) {
        mobileNavToogle();
      }
    });

  });

  /**
   * Toggle mobile nav dropdowns
   */
  document.querySelectorAll('.navmenu .toggle-dropdown').forEach(navmenu => {
    navmenu.addEventListener('click', function (e) {
      e.preventDefault();
      this.parentNode.classList.toggle('active');
      this.parentNode.nextElementSibling.classList.toggle('dropdown-active');
      e.stopImmediatePropagation();
    });
  });

  /**
   * Preloader
   */
  const preloader = document.querySelector('#preloader');
  if (preloader) {
    window.addEventListener('load', () => {
      setTimeout(() => {
        preloader.remove();
        // preloader.style.display = 'none';
      }, 300);
    });
  }

  /**
   * Carousels
   */

  var myCarousel = document.querySelector('#aboutCarousel');
  var carousel = new bootstrap.Carousel(myCarousel, {
    interval: 3000, // Cambiar cada 3 segundos
    ride: 'carousel'
  });

  /** 
   * Verficiar Datos
   */
  /**
 * Verificación de Datos mediante consulta al servidor
 */
  document.getElementById('verification-form').addEventListener('submit', function (event) {
    event.preventDefault();

    const spinner = document.getElementById('loading-spinner');
    const resultDiv = document.getElementById('verification-result');
    const ci = document.getElementById('ci').value;

    spinner.style.display = 'inline-block'; // Mostrar spinner

    fetch('/verificar-datos', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
      },
      body: JSON.stringify({ ci })
    })
      .then(response => response.json())
      .then(data => {
        spinner.style.display = 'none'; // Ocultar spinner
        resultDiv.style.display = 'block';

        if (data.success) {
          resultDiv.innerHTML = `
                  <div class="alert alert-success">
                      <strong>Datos encontrados:</strong>
                      <strong>Datos del Tutor:</strong>
                      <ul>
                        <li>Nombre Completo: ${data.tutor.primer_nombre_tutor} ${data.tutor.segundo_nombre_tutor || ''} ${data.tutor.primer_apellido_tutor} ${data.tutor.segundo_apellido_tutor || ''} ${data.tutor.tercer_apellido_tutor || ''}</li>
                        <li>CI: ${data.tutor.ci_tutor}</li>
                        <li>Expedido: ${data.tutor.expedido_tutor}</li>
                      </ul>
                      
                      <strong>Estudiantes:</strong>
                      <ul>
                        ${data.tutor.estudiantes.map(est => `
                          <li>
                            <ul>
                              <li>${est.primer_nombre} ${est.segundo_nombre || ''} ${est.primer_apellido} ${est.segundo_apellido || ''}</li>
                              <li>CI: ${est.ci}</li>
                              <li>RUDE: ${est.rude}</li>
                              <li>Nivel: ${est.nivel}</li>
                              <li>Curso: ${est.curso}</li>
                              <li>Paralelo: ${est.paralelo}</li>
                              <li>Habilitado: ${est.habilitado}</li>
                            </ul>
                          </li>
                        `).join('')}
                      </ul>
                      <br>
                        <p style="color: gray; font-size: small; margin-top: 10px;">
                           Si algún dato es incorrecto, por favor acérquese al colegio correspondiente para solicitar la corrección.
                        </p>
                  </div>
              `;
        } else {
          resultDiv.innerHTML = `
                  <div class="alert alert-danger">
                      ${data.message}
                  </div>
              `;
        }
      })
      .catch(error => {
        spinner.style.display = 'none'; // Ocultar spinner
        resultDiv.style.display = 'block';
        resultDiv.innerHTML = `
              <div class="alert alert-danger">
                  Ocurrió un error. Por favor, inténtalo de nuevo.
              </div>
          `;
      });
  });

  /**
   * Scroll top button
   */
  let scrollTop = document.querySelector('.scroll-top');

  function toggleScrollTop() {
    if (scrollTop) {
      window.scrollY > 100 ? scrollTop.classList.add('active') : scrollTop.classList.remove('active');
    }
  }
  scrollTop.addEventListener('click', (e) => {
    e.preventDefault();
    window.scrollTo({
      top: 0,
      behavior: 'smooth'
    });
  });

  window.addEventListener('load', toggleScrollTop);
  document.addEventListener('scroll', toggleScrollTop);

  /**
   * Animation on scroll function and init
   */
  function aosInit() {
    AOS.init({
      duration: 600,
      easing: 'ease-in-out',
      once: true,
      mirror: false
    });
  }
  window.addEventListener('load', aosInit);

  /**
   * Init swiper sliders
   */
  function initSwiper() {
    document.querySelectorAll(".init-swiper").forEach(function (swiperElement) {
      let config = JSON.parse(
        swiperElement.querySelector(".swiper-config").innerHTML.trim()
      );

      if (swiperElement.classList.contains("swiper-tab")) {
        initSwiperWithCustomPagination(swiperElement, config);
      } else {
        new Swiper(swiperElement, config);
      }
    });
  }

  window.addEventListener("load", initSwiper);

  /**
   * Initiate glightbox
   */
  const glightbox = GLightbox({
    selector: '.glightbox'
  });

  /**
   * Init isotope layout and filters
   */
  document.querySelectorAll('.isotope-layout').forEach(function (isotopeItem) {
    let layout = isotopeItem.getAttribute('data-layout') ?? 'masonry';
    let filter = isotopeItem.getAttribute('data-default-filter') ?? '*';
    let sort = isotopeItem.getAttribute('data-sort') ?? 'original-order';

    let initIsotope;
    imagesLoaded(isotopeItem.querySelector('.isotope-container'), function () {
      initIsotope = new Isotope(isotopeItem.querySelector('.isotope-container'), {
        itemSelector: '.isotope-item',
        layoutMode: layout,
        filter: filter,
        sortBy: sort
      });
    });

    isotopeItem.querySelectorAll('.isotope-filters li').forEach(function (filters) {
      filters.addEventListener('click', function () {
        isotopeItem.querySelector('.isotope-filters .filter-active').classList.remove('filter-active');
        this.classList.add('filter-active');
        initIsotope.arrange({
          filter: this.getAttribute('data-filter')
        });
        if (typeof aosInit === 'function') {
          aosInit();
        }
      }, false);
    });

  });

  /**
   * Frequently Asked Questions Toggle
   */
  document.querySelectorAll('.faq-item h3, .faq-item .faq-toggle').forEach((faqItem) => {
    faqItem.addEventListener('click', () => {
      faqItem.parentNode.classList.toggle('faq-active');
    });
  });

  /**
   * Correct scrolling position upon page load for URLs containing hash links.
   */
  window.addEventListener('load', function (e) {
    if (window.location.hash) {
      if (document.querySelector(window.location.hash)) {
        setTimeout(() => {
          let section = document.querySelector(window.location.hash);
          let scrollMarginTop = getComputedStyle(section).scrollMarginTop;
          window.scrollTo({
            top: section.offsetTop - parseInt(scrollMarginTop),
            behavior: 'smooth'
          });
        }, 100);
      }
    }
  });

  /**
   * Navmenu Scrollspy
   */
  let navmenulinks = document.querySelectorAll('.navmenu a');

  function navmenuScrollspy() {
    navmenulinks.forEach(navmenulink => {
      if (!navmenulink.hash) return;
      let section = document.querySelector(navmenulink.hash);
      if (!section) return;
      let position = window.scrollY + 200;
      if (position >= section.offsetTop && position <= (section.offsetTop + section.offsetHeight)) {
        document.querySelectorAll('.navmenu a.active').forEach(link => link.classList.remove('active'));
        navmenulink.classList.add('active');
      } else {
        navmenulink.classList.remove('active');
      }
    })
  }
  window.addEventListener('load', navmenuScrollspy);
  document.addEventListener('scroll', navmenuScrollspy);

})();