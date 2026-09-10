<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Noticias, anuncios y momentos de nuestra iglesia.">
  <title>Sistema SIAD | Anuncios</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/inicio.css') }}">
</head>
<body>
  <header class="site-header">
    @include('inicio.partials.nav')
    <div class="hero">
      <div>
        <span class="eyebrow">Nuestra iglesia · Nuestro hogar</span>
        <h1>Un lugar para compartir la vida.</h1>
        <p class="hero-copy">Noticias, encuentros y momentos que construyen comunidad. Todo lo que está pasando, en un solo lugar.</p>
      </div>
      <p class="hero-note">“Donde dos o tres se reúnen en mi nombre, allí estoy yo.”</p>
    </div>
  </header>
  <main class="content-wrap">
    <section aria-labelledby="momentos-title">
      <div class="section-heading">
        <div><span class="eyebrow">En imágenes</span><h2 id="momentos-title">Momentos de la comunidad</h2></div>
        <p>Un espacio preparado para compartir fotografías de nuestros encuentros, celebraciones y actividades.</p>
      </div>
      <div class="carousel" aria-label="Carrusel de momentos de la comunidad">
        <div class="carousel-track">
          <article class="carousel-slide"><span class="slide-number">01 / 03</span><h3>Celebramos juntos.</h3><p>Este espacio queda listo para la próxima fotografía de nuestra iglesia.</p></article>
          <article class="carousel-slide"><span class="slide-number">02 / 03</span><h3>La fe también se encuentra.</h3><p>Un marco limpio para guardar los recuerdos que compartimos como comunidad.</p></article>
          <article class="carousel-slide"><span class="slide-number">03 / 03</span><h3>Hay lugar para todos.</h3><p>Próximamente aquí vivirá una nueva historia de nuestra congregación.</p></article>
        </div>
        <div class="carousel-dots" aria-label="Seleccionar diapositiva"><button class="carousel-dot active" type="button" aria-label="Ir a la diapositiva 1"></button><button class="carousel-dot" type="button" aria-label="Ir a la diapositiva 2"></button><button class="carousel-dot" type="button" aria-label="Ir a la diapositiva 3"></button></div>
        <div class="carousel-controls"><button class="carousel-button" type="button" data-direction="-1" aria-label="Diapositiva anterior">←</button><button class="carousel-button" type="button" data-direction="1" aria-label="Siguiente diapositiva">→</button></div>
      </div>
    </section>
    <div class="below-grid">
      <section aria-labelledby="anuncios-title">
        <div class="section-heading"><div><span class="eyebrow">Desde la iglesia</span><h2 id="anuncios-title">Anuncios recientes</h2></div></div>
        <div class="posts-grid">
          @forelse($anuncios as $anuncio)
            <article class="post-card">
              <div class="blank-media" aria-label="Espacio reservado para fotografía">Foto</div>
              <div class="post-body"><span class="post-date">{{ $anuncio->created_at ? $anuncio->created_at->format('d.m.Y') : 'Hoy' }}</span><h3>{{ $anuncio->titulo }}</h3><p>{{ $anuncio->descripcion }}</p></div>
            </article>
          @empty
            <div class="empty-state">Pronto compartiremos nuevos anuncios con la comunidad.</div>
          @endforelse
        </div>
      </section>
      <aside class="promo" aria-labelledby="promo-title"><span class="eyebrow">Invitación abierta</span><h2 id="promo-title">Tu historia también forma parte.</h2><p>Un rincón para anunciar actividades, invitar a nuevos encuentros y celebrar lo que vivimos juntos.</p><div class="promo-rule"></div><small>Comunidad · Fe · Esperanza</small></aside>
    </div>
  </main>
  <footer class="site-footer"><strong>SISTEMA DE LAS ASAMBLEAS DE DIOS DE EL SALVADOR</strong><span>Un espacio para mantenernos cerca.</span></footer>
  <script>
    (() => {
      const track = document.querySelector('.carousel-track');
      const slides = document.querySelectorAll('.carousel-slide');
      const dots = document.querySelectorAll('.carousel-dot');
      let currentSlide = 0;
      const showSlide = (slide) => {
        currentSlide = (slide + slides.length) % slides.length;
        track.style.transform = `translateX(-${currentSlide * 100}%)`;
        dots.forEach((dot, index) => dot.classList.toggle('active', index === currentSlide));
      };
      document.querySelectorAll('.carousel-button').forEach((button) => button.addEventListener('click', () => showSlide(currentSlide + Number(button.dataset.direction))));
      dots.forEach((dot, index) => dot.addEventListener('click', () => showSlide(index)));
    })();
  </script>
</body>
</html>
