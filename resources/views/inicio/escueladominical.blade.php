<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="Anuncios, clases y actividades de Escuela Dominical.">
	<title>Escuela Dominical | Sistema SIAD</title>
	<link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="{{ asset('css/inicio.css') }}">
</head>
<body>
	<header class="site-header youth-header">
		@include('inicio.partials.nav')
		<div class="hero youth-hero">
			<div>
				<span class="eyebrow youth-kicker">Escuela Dominical de El Salvador</span>
				<h1>Escuela Biblica Domincal</h1>
				<p class="hero-copy">Un espacio para crecer en la Palabra, compartir en familia y descubrir cada domingo algo nuevo.</p>
			</div>
			<p class="hero-note">“Instruye al niño en su camino, y aun cuando fuere viejo no se apartará de él.”</p>
		</div>
	</header>

	<main class="content-wrap youth-content">
		<section aria-labelledby="school-featured-title">
			<div class="section-heading">
				<div><span class="eyebrow youth-kicker">Cada domingo</span><h2 id="school-featured-title">Noticias de la escuela</h2></div>
				<p>Conoce nuestras clases, actividades y momentos para aprender juntos como iglesia.</p>
			</div>
			<div class="youth-featured">
				<div class="carousel" aria-label="Anuncios destacados de Escuela Dominical">
					<div class="carousel-track">
						@forelse($anuncios->take(3) as $index => $anuncio)
							@php
								$image = $anuncio->imagen;
								$imageUrl = $image && (str_starts_with($image, 'http://') || str_starts_with($image, 'https://') || str_starts_with($image, '/')) ? $image : ($image ? route('anuncios.image', $anuncio) : asset('img/photo' . (($index % 3) + 1) . '.jpg'));
							@endphp
							<article class="carousel-slide" style="background-image:linear-gradient(rgba(22,33,28,.34),rgba(22,33,28,.64)),url('{{ $imageUrl }}')"><span class="slide-number">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }} / {{ str_pad(min($anuncios->count(), 3), 2, '0', STR_PAD_LEFT) }}</span><h3>{{ $anuncio->titulo }}</h3><p>{{ $anuncio->descripcion }}</p></article>
						@empty
							<article class="carousel-slide" style="background-image:linear-gradient(rgba(22,33,28,.4),rgba(22,33,28,.65)),url('/img/photo2.jpg')"><span class="slide-number">01 / 01</span><h3>Un domingo para crecer juntos.</h3><p>Pronto compartiremos nuevos anuncios y actividades de nuestra Escuela Dominical.</p></article>
						@endforelse
					</div>
					@if($anuncios->count() > 1)
						<div class="carousel-dots" aria-label="Seleccionar anuncio destacado">@foreach($anuncios->take(3) as $index => $anuncio)<button class="carousel-dot{{ $index === 0 ? ' active' : '' }}" type="button" aria-label="Ir al anuncio {{ $index + 1 }}"></button>@endforeach</div>
						<div class="carousel-controls"><button class="carousel-button" type="button" data-direction="-1" aria-label="Anuncio anterior">←</button><button class="carousel-button" type="button" data-direction="1" aria-label="Siguiente anuncio">→</button></div>
					@endif
				</div>
				<aside class="youth-aside" aria-labelledby="school-aside-title"><span class="eyebrow youth-kicker">Un lugar para aprender</span><h2 id="school-aside-title">Crecer juntos.</h2><p>La fe se comparte mejor cuando aprendemos, preguntamos y caminamos en comunidad.</p><ul class="youth-aside-list"><li><strong>Palabra</strong>Lecciones para cada etapa de la vida.</li><li><strong>Familia</strong>Momentos para aprender y compartir.</li></ul></aside>
			</div>
		</section>

		<section class="youth-posts" aria-labelledby="school-posts-title"><div class="section-heading"><div><span class="eyebrow youth-kicker">Memorias y avisos</span><h2 id="school-posts-title">Actividades recientes</h2></div></div><div class="posts-grid">
			@forelse($anuncios as $anuncio)
				@php $image = $anuncio->imagen; $imageUrl = $image && (str_starts_with($image, 'http://') || str_starts_with($image, 'https://') || str_starts_with($image, '/')) ? $image : ($image ? route('anuncios.image', $anuncio) : null); @endphp
				<article class="post-card youth-post-card"><div class="post-media">@if($imageUrl)<img class="post-media-image" src="{{ $imageUrl }}" alt="Imagen del anuncio: {{ $anuncio->titulo }}" loading="lazy">@else<div class="blank-media" aria-label="Este anuncio no tiene fotografía">Escuela</div>@endif</div><div class="post-body"><span class="post-date">{{ $anuncio->created_at ? $anuncio->created_at->format('d.m.Y') : 'Hoy' }}</span><h3>{{ $anuncio->titulo }}</h3><p>{{ $anuncio->descripcion }}</p></div></article>
			@empty
				<div class="youth-empty"><span class="youth-empty-mark">+</span><div><strong>Estamos preparando nuevas actividades.</strong><p>Muy pronto encontrarás aquí las próximas clases, reuniones y fotografías de Escuela Dominical.</p></div></div>
			@endforelse
		</div></section>
	</main>
	<footer class="site-footer"><strong>SISTEMA DE LAS ASAMBLEAS DE DIOS DE EL SALVADOR</strong><span>Palabra · Familia · Comunidad</span></footer>
	<script>
		(() => { const track = document.querySelector('.carousel-track'); const slides = document.querySelectorAll('.carousel-slide'); const dots = document.querySelectorAll('.carousel-dot'); if (!track || slides.length < 2) return; let currentSlide = 0; const showSlide = (slide) => { currentSlide = (slide + slides.length) % slides.length; track.style.transform = `translateX(-${currentSlide * 100}%)`; dots.forEach((dot, index) => dot.classList.toggle('active', index === currentSlide)); }; document.querySelectorAll('.carousel-button').forEach((button) => button.addEventListener('click', () => showSlide(currentSlide + Number(button.dataset.direction)))); dots.forEach((dot, index) => dot.addEventListener('click', () => showSlide(index))); })();
	</script>
</body>
</html>
