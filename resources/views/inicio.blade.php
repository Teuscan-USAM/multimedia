<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Noticias, anuncios y momentos de nuestra iglesia.">
  <title>Comunidad TEO | Anuncios</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <style>
    :root { --ink:#16211c; --muted:#68746d; --paper:#f4f7f4; --white:#ffffff; --line:#dce5df; --sage:#86a895; --sage-dark:#456b57; --gold:#d0a35c; --coral:#d77d67; }
    * { box-sizing:border-box; }
    html { scroll-behavior:smooth; }
    body { margin:0; color:var(--ink); background:var(--paper); font-family:'Manrope',sans-serif; }
    a { color:inherit; text-decoration:none; }
    .site-header { position:relative; overflow:hidden; color:var(--white); background:var(--ink); }
    .site-header::after { position:absolute; right:-6rem; bottom:-8rem; width:22rem; height:22rem; border:1px solid rgba(208,163,92,.25); border-radius:50%; content:''; }
    .nav-wrap,.hero,.content-wrap,.site-footer { width:min(1160px,calc(100% - 3rem)); margin:0 auto; }
    .nav-wrap { position:relative; z-index:1; display:flex; align-items:center; justify-content:space-between; min-height:5rem; border-bottom:1px solid rgba(255,255,255,.15); }
    .brand { display:inline-flex; align-items:center; gap:.75rem; font-size:.8rem; font-weight:700; letter-spacing:.16em; }
    .brand-mark { display:grid; width:2.35rem; height:2.35rem; place-items:center; border:1px solid var(--gold); color:var(--gold); font-size:1rem; font-weight:800; }
    .login-link { padding:.7rem 1rem; border:1px solid rgba(255,255,255,.35); border-radius:.35rem; font-size:.76rem; font-weight:700; letter-spacing:.08em; text-transform:uppercase; transition:background .2s ease,color .2s ease; }
    .login-link:hover { color:var(--ink); background:var(--white); }
    .hero { position:relative; z-index:1; display:grid; grid-template-columns:1.15fr .85fr; align-items:end; gap:4rem; padding:7rem 0 6rem; }
    .eyebrow { display:inline-flex; align-items:center; gap:.6rem; margin-bottom:1.2rem; color:var(--gold); font-size:.72rem; font-weight:700; letter-spacing:.18em; text-transform:uppercase; }
    .eyebrow::before { width:2.3rem; height:1px; background:currentColor; content:''; }
    h1,h2,h3 { margin-top:0; font-family:'Manrope',sans-serif; font-weight:800; letter-spacing:-.035em; }
    h1 { max-width:700px; margin-bottom:1.4rem; color:var(--white); font-size:clamp(2.8rem,6vw,5.8rem); line-height:1; letter-spacing:-.055em; }
    .hero-copy { max-width:480px; margin-bottom:0; color:#bec8bf; font-size:1.05rem; line-height:1.75; }
    .hero-note { align-self:center; padding:1.7rem; border-left:2px solid var(--gold); color:#dbe1d8; font-size:clamp(1.1rem,2vw,1.45rem); font-weight:600; line-height:1.55; }
    .content-wrap { padding:4.8rem 0 6rem; }
    .section-heading { display:flex; align-items:end; justify-content:space-between; gap:2rem; margin-bottom:2rem; }
    .section-heading h2 { margin-bottom:0; font-size:clamp(2rem,4vw,3.2rem); line-height:1; }
    .section-heading p { max-width:390px; margin-bottom:.2rem; color:var(--muted); font-size:.9rem; line-height:1.6; text-align:right; }
    .carousel { position:relative; overflow:hidden; color:var(--white); background:var(--sage-dark); }
    .carousel-track { display:flex; transition:transform .55s cubic-bezier(.22,.61,.36,1); }
    .carousel-slide { position:relative; flex:0 0 100%; min-height:390px; padding:clamp(2rem,6vw,5rem); background:#5d806b; }
    .carousel-slide:nth-child(2) { background:#806e5b; }
    .carousel-slide:nth-child(3) { background:#52747a; }
    .carousel-slide::before { position:absolute; inset:1.4rem; border:1px solid rgba(255,255,255,.3); content:''; }
    .slide-number { position:relative; display:block; margin-bottom:4rem; color:rgba(255,255,255,.75); font-size:.75rem; font-weight:700; letter-spacing:.15em; }
    .carousel-slide h3 { position:relative; max-width:620px; margin-bottom:.8rem; font-size:clamp(2rem,4.5vw,4rem); line-height:1.02; }
    .carousel-slide p { position:relative; max-width:490px; margin-bottom:0; color:rgba(255,255,255,.85); line-height:1.6; }
    .carousel-controls { position:absolute; right:2rem; bottom:1.7rem; z-index:2; display:flex; gap:.55rem; }
    .carousel-button,.carousel-dot { border:1px solid rgba(255,255,255,.62); color:var(--white); background:transparent; cursor:pointer; }
    .carousel-button { width:2.5rem; height:2.5rem; font-size:1.1rem; }
    .carousel-button:hover { background:rgba(255,255,255,.16); }
    .carousel-dots { position:absolute; bottom:2.6rem; left:2rem; z-index:2; display:flex; gap:.45rem; }
    .carousel-dot { width:.55rem; height:.55rem; padding:0; border-radius:50%; }
    .carousel-dot.active { background:var(--white); }
    .below-grid { display:grid; grid-template-columns:minmax(0,1.45fr) minmax(280px,.55fr); gap:4rem; margin-top:6rem; }
    .posts-grid { display:grid; gap:1.2rem; }
    .post-card { display:grid; grid-template-columns:190px 1fr; min-height:190px; border:1px solid var(--line); border-radius:.55rem; overflow:hidden; background:var(--white); transition:transform .2s ease,box-shadow .2s ease; }
    .post-card:hover { transform:translateY(-3px); box-shadow:0 14px 28px rgba(28,36,33,.08); }
    .blank-media { display:grid; min-height:190px; place-items:center; border-right:1px solid var(--line); background-color:#e8efea; background-image:linear-gradient(135deg,transparent 48%,rgba(120,145,127,.1) 49%,transparent 51%); background-size:18px 18px; color:#899c90; font-size:.65rem; font-weight:700; letter-spacing:.16em; text-transform:uppercase; }
    .post-body { display:flex; flex-direction:column; padding:1.5rem 1.7rem; }
    .post-date { margin-bottom:.7rem; color:var(--coral); font-size:.7rem; font-weight:700; letter-spacing:.12em; text-transform:uppercase; }
    .post-body h3 { margin-bottom:.55rem; font-size:1.55rem; line-height:1.12; }
    .post-body p { display:-webkit-box; overflow:hidden; margin-bottom:0; color:var(--muted); line-height:1.55; -webkit-box-orient:vertical; -webkit-line-clamp:3; }
    .empty-state { padding:3rem; border:1px dashed var(--line); color:var(--muted); text-align:center; }
    .promo { position:relative; padding:2.3rem; overflow:hidden; border-radius:.55rem; color:var(--white); background:var(--coral); }
    .promo::after { position:absolute; right:-4rem; bottom:-5rem; width:13rem; height:13rem; border:1px solid rgba(255,255,255,.45); border-radius:50%; content:''; }
    .promo .eyebrow,.promo h2,.promo p,.promo-rule,.promo small { position:relative; z-index:1; }
    .promo .eyebrow { color:var(--white); }
    .promo h2 { margin-bottom:1rem; font-size:2.45rem; line-height:1; }
    .promo p { max-width:290px; color:rgba(255,255,255,.88); line-height:1.6; }
    .promo-rule { width:100%; height:1px; margin:2.3rem 0 1.2rem; background:rgba(255,255,255,.5); }
    .promo small { color:rgba(255,255,255,.8); letter-spacing:.08em; text-transform:uppercase; }
    .site-footer { display:flex; justify-content:space-between; gap:2rem; padding:1.8rem 0 2.5rem; border-top:1px solid var(--line); color:var(--muted); font-size:.78rem; }
    @media (max-width:760px) {
      .nav-wrap,.hero,.content-wrap,.site-footer { width:min(100% - 2rem,600px); }
      .hero { display:block; padding:5rem 0 4.5rem; }
      h1 { font-size:clamp(3.3rem,16vw,5.5rem); }
      .hero-note { margin-top:2.8rem; }
      .content-wrap { padding-top:3.5rem; }
      .section-heading { display:block; }
      .section-heading p { margin-top:1rem; text-align:left; }
      .carousel-slide { min-height:420px; padding:2.5rem 2rem; }
      .carousel-slide::before { inset:1rem; }
      .carousel-controls { right:1.4rem; bottom:1.4rem; }
      .carousel-dots { bottom:2.4rem; left:1.5rem; }
      .below-grid { display:block; margin-top:4rem; }
      .promo { margin-top:3.5rem; }
      .post-card { grid-template-columns:1fr; }
      .blank-media { min-height:150px; border-right:0; border-bottom:1px solid var(--line); }
      .site-footer { display:block; }
      .site-footer span { display:block; margin-top:.5rem; }
    }
  </style>
</head>
<body>
  <header class="site-header">
    <nav class="nav-wrap" aria-label="Navegación principal">
      <a class="brand" href="{{ route('inicio') }}"><span class="brand-mark">T</span><span>COMUNIDAD TEO</span></a>
      <a class="login-link" href="{{ route('login') }}">Iniciar sesión</a>
    </nav>
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
  <footer class="site-footer"><strong>COMUNIDAD TEO</strong><span>Un espacio para mantenernos cerca.</span></footer>
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