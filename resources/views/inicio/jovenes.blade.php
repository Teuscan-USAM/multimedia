<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="Anuncios, actividades y encuentros del departamento de jóvenes.">
	<title>Jóvenes | Sistema SIAD</title>
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
				<span class="eyebrow youth-kicker">Departamento de jóvenes de El Salvador</span>
				<h1>Embajadores de Cristo</h1>
				<p class="hero-copy">Encuentra aquí nuestros anuncios, actividades y momentos. Un espacio para conectar, servir y crecer juntos.</p>
			</div>
			<p class="hero-note">“Nadie tenga en poco tu juventud; sé ejemplo de los creyentes.”</p>
		</div>
	</header>

	<main class="content-wrap youth-content">
		<section aria-labelledby="youth-featured-title">
			<div class="section-heading">
				<div><span class="eyebrow youth-kicker">Lo que está pasando</span><h2 id="youth-featured-title">Anuncios de jóvenes</h2></div>
				<p>Actividades, reuniones y noticias para mantenernos cerca durante la semana.</p>
			</div>
			<div class="youth-featured">
				<div class="carousel" aria-label="Anuncios destacados de jóvenes">
					<div class="carousel-track">
						@forelse($anuncios->take(3) as $index => $anuncio)
							@php
								$image = $anuncio->imagen;
								$imageUrl = $image && (str_starts_with($image, 'http://') || str_starts_with($image, 'https://') || str_starts_with($image, '/')) ? $image : ($image ? route('anuncios.image', $anuncio) : asset('img/photo' . (($index % 3) + 1) . '.jpg'));
							@endphp
							<article class="carousel-slide" style="background-image:linear-gradient(rgba(22,33,28,.38),rgba(22,33,28,.62)),url('{{ $imageUrl }}')">
								<span class="slide-number">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }} / {{ str_pad(min($anuncios->count(), 3), 2, '0', STR_PAD_LEFT) }}</span>
								<h3>{{ $anuncio->titulo }}</h3><p>{{ $anuncio->descripcion }}</p>
							</article>
						@empty
							<article class="carousel-slide" style="background-image:linear-gradient(rgba(22,33,28,.4),rgba(22,33,28,.65)),url('/img/photo1.jpg')"><span class="slide-number">01 / 01</span><h3>Tu próximo encuentro empieza aquí.</h3><p>Pronto compartiremos nuevos anuncios y actividades para nuestra generación.</p></article>
						@endforelse
					</div>
					@if($anuncios->count() > 1)
						<div class="carousel-dots" aria-label="Seleccionar anuncio destacado">@foreach($anuncios->take(3) as $index => $anuncio)<button class="carousel-dot{{ $index === 0 ? ' active' : '' }}" type="button" aria-label="Ir al anuncio {{ $index + 1 }}"></button>@endforeach</div>
						<div class="carousel-controls"><button class="carousel-button" type="button" data-direction="-1" aria-label="Anuncio anterior">←</button><button class="carousel-button" type="button" data-direction="1" aria-label="Siguiente anuncio">→</button></div>
					@endif
				</div>
				<aside class="youth-aside" aria-labelledby="youth-aside-title"><span class="eyebrow youth-kicker">Agenda abierta</span><h2 id="youth-aside-title">Ven como eres.</h2><p>Hay un lugar para ti en cada reunión, proyecto y conversación.</p><ul class="youth-aside-list"><li><strong>Encuentros</strong>Tiempo para compartir y escuchar.</li><li><strong>Servicio</strong>Manos dispuestas para nuestra comunidad.</li></ul></aside>
			</div>
		</section>

		<section class="youth-posts" aria-labelledby="youth-posts-title"><div class="section-heading"><div><span class="eyebrow youth-kicker">Archivo vivo</span><h2 id="youth-posts-title">Noticias y recuerdos</h2></div></div><div class="posts-grid">
			@forelse($anuncios as $anuncio)
				@php $image = $anuncio->imagen; $imageUrl = $image && (str_starts_with($image, 'http://') || str_starts_with($image, 'https://') || str_starts_with($image, '/')) ? $image : ($image ? route('anuncios.image', $anuncio) : null); @endphp
				<article class="post-card youth-post-card"><div class="post-media">@if($imageUrl)<img class="post-media-image" src="{{ $imageUrl }}" alt="Imagen del anuncio: {{ $anuncio->titulo }}" loading="lazy">@else<div class="blank-media" aria-label="Este anuncio no tiene fotografía">Jóvenes</div>@endif</div><div class="post-body"><span class="post-date">{{ $anuncio->created_at ? $anuncio->created_at->format('d.m.Y') : 'Hoy' }}</span><h3>{{ $anuncio->titulo }}</h3><p>{{ $anuncio->descripcion }}</p></div></article>
			@empty
				<div class="youth-empty"><span class="youth-empty-mark">+</span><div><strong>Estamos preparando nuevos anuncios.</strong><p>Muy pronto encontrarás aquí las próximas actividades y fotografías de Jóvenes.</p></div></div>
			@endforelse
		</div></section>
	</main>
	<footer class="site-footer"><strong>SISTEMA DE LAS ASAMBLEAS DE DIOS DE EL SALVADOR</strong><span>Jóvenes · Fe · Propósito</span></footer>
	<script>
		(() => { const track = document.querySelector('.carousel-track'); const slides = document.querySelectorAll('.carousel-slide'); const dots = document.querySelectorAll('.carousel-dot'); if (!track || slides.length < 2) return; let currentSlide = 0; const showSlide = (slide) => { currentSlide = (slide + slides.length) % slides.length; track.style.transform = `translateX(-${currentSlide * 100}%)`; dots.forEach((dot, index) => dot.classList.toggle('active', index === currentSlide)); }; document.querySelectorAll('.carousel-button').forEach((button) => button.addEventListener('click', () => showSlide(currentSlide + Number(button.dataset.direction)))); dots.forEach((dot, index) => dot.addEventListener('click', () => showSlide(index))); })();
	</script>
</body>
</html>
