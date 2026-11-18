@php($editando = $inscripcion !== null)
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{ $editando ? 'Editar inscripción' : 'Inscripción al campamento' }}</title>
  <link rel="icon" href="{{ asset('img/login.ico') }}" type="image/x-icon">
  <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <style>
    :root { --ink:#17251f; --muted:#66736d; --green:#1f5c48; --cream:#f7f5ef; --line:#dfe5df; }
    * { box-sizing:border-box; } body { margin:0; color:var(--ink); background:var(--cream); font-family:Manrope, sans-serif; }
    .wrap { max-width:900px; margin:0 auto; padding:32px 18px 56px; }
    .hero { border-radius:22px; color:white; background:linear-gradient(135deg,#1f5c48,#16382e); padding:34px; margin-bottom:22px; }
    .hero a { color:#d5eadf; } h1 { margin:8px 0 10px; font-size:clamp(2rem,5vw,3.3rem); } .eyebrow { letter-spacing:.12em; text-transform:uppercase; font-size:.75rem; font-weight:800; color:#b9e2d0; }
    .card { background:#fff; border:1px solid var(--line); border-radius:18px; padding:28px; margin-bottom:18px; box-shadow:0 10px 30px rgba(30,50,40,.05); }
    h2 { margin:0 0 5px; font-size:1.25rem; } .section-help { color:var(--muted); margin:0 0 20px; font-size:.9rem; }
    .grid { display:grid; grid-template-columns:repeat(2,minmax(0,1fr)); gap:16px; } .full { grid-column:1/-1; }
    label { display:block; font-size:.88rem; font-weight:700; margin-bottom:7px; } label span { color:#b13c35; }
    input, select, textarea { width:100%; border:1px solid var(--line); border-radius:10px; padding:12px 13px; font:inherit; color:var(--ink); background:#fff; } textarea { min-height:90px; resize:vertical; }
    input:focus, select:focus, textarea:focus { outline:3px solid #d5eadf; border-color:var(--green); }
    .choice { display:flex; flex-wrap:wrap; gap:15px; padding-top:5px; } .choice label { font-weight:500; margin:0; display:flex; align-items:center; gap:7px; } .choice input { width:auto; }
    .error { color:#b13c35; font-size:.8rem; margin-top:5px; } .alert { padding:14px 16px; border-radius:10px; margin-bottom:18px; background:#e2f4e9; color:#18583d; }
    .success-screen { position:fixed; inset:0; z-index:10; display:flex; align-items:center; justify-content:center; padding:24px; background:var(--cream); text-align:center; }
    .success-card { width:min(680px,100%); padding:48px 32px; border:1px solid var(--line); border-radius:24px; background:#fff; box-shadow:0 20px 60px rgba(30,50,40,.12); }
    .success-card h1 { color:var(--green); margin:0 0 14px; font-size:clamp(2rem,5vw,3.2rem); }
    .success-card p { color:var(--muted); font-size:1.1rem; margin:0 0 28px; }
    .success-card a { display:inline-block; border-radius:10px; padding:13px 22px; background:var(--green); color:#fff; font-weight:800; text-decoration:none; }
    .actions { display:flex; justify-content:space-between; align-items:center; gap:16px; } .required { color:var(--muted); font-size:.82rem; }
    button { border:0; border-radius:10px; padding:13px 22px; background:var(--green); color:#fff; font:inherit; font-weight:800; cursor:pointer; }
    @media (max-width:640px) { .grid { grid-template-columns:1fr; } .full { grid-column:auto; } .hero,.card { padding:22px; } .actions { align-items:flex-start; flex-direction:column; } button { width:100%; } }
  </style>
</head>
<body>
  <main class="wrap">
    @if(session('success'))
      <section class="success-screen" aria-labelledby="success-title">
        <div class="success-card">
          <h1 id="success-title">¡Felicidades te esperamos en nuestro campamento!</h1>
          <p>{{ session('success') }}</p>
          <a href="{{ route('campamento.formulario') }}">Volver a ficha de inscripción</a>
        </div>
      </section>
    @else
    <div class="hero">
      <a href="{{ route('inicio.index') }}">← Volver al inicio</a>
      <div class="eyebrow" style="margin-top:24px">Registro de participantes</div>
      <h1>{{ $editando ? 'Editar inscripción' : 'Inscripción al campamento' }}</h1>
      <p>Completa tus datos y los de tu contacto de emergencia. Los campos marcados con * son obligatorios.</p>
    </div>

    @if($errors->any())
      <div class="alert" style="background:#fff0ee;color:#8f2f28" role="alert">
        <strong>No se pudo guardar la inscripción.</strong><br>
        Revisa los campos marcados e inténtalo nuevamente.
        <ul class="mb-0 mt-2">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
      </div>
    @endif

    <form method="POST" action="{{ $editando ? route('campamento.update', $inscripcion) : route('campamento.inscribir') }}">
      @csrf
      @if($editando) @method('PUT') @endif
      <section class="card">
        <h2>Datos del participante</h2><p class="section-help">Información de la persona que participará en el campamento.</p>
        <div class="grid">
          <div class="full"><label for="nombre_completo">Nombre completo <span>*</span></label><input id="nombre_completo" name="nombre_completo" value="{{ old('nombre_completo', $inscripcion?->nombre_completo) }}" required>@error('nombre_completo')<div class="error">{{ $message }}</div>@enderror</div>
          <div><label for="fecha_nacimiento">Fecha de nacimiento <span>*</span></label><input id="fecha_nacimiento" type="date" name="fecha_nacimiento" value="{{ old('fecha_nacimiento', $inscripcion?->fecha_nacimiento?->format('Y-m-d')) }}" max="{{ now()->format('Y-m-d') }}" required>@error('fecha_nacimiento')<div class="error">{{ $message }}</div>@enderror</div>
          <div><label for="edad">Edad <span>*</span></label><input id="edad" type="number" name="edad" value="{{ old('edad', $inscripcion?->edad) }}" min="0" max="120" required><div id="edad-client-error" class="client-error error"></div>@error('edad')<div class="error">{{ $message }}</div>@enderror</div>
          <div><label for="sexo">Sexo <span>*</span></label><select id="sexo" name="sexo" required><option value="">Selecciona una opción</option><option value="Femenino" {{ old('sexo', $inscripcion?->sexo) === 'Femenino' ? 'selected' : '' }}>Femenino</option><option value="Masculino" {{ old('sexo', $inscripcion?->sexo) === 'Masculino' ? 'selected' : '' }}>Masculino</option></select>@error('sexo')<div class="error">{{ $message }}</div>@enderror</div>
          <div><label for="telefono">Teléfono o WhatsApp <span>*</span></label><input id="telefono" name="telefono" value="{{ old('telefono', $inscripcion?->telefono) }}" required>@error('telefono')<div class="error">{{ $message }}</div>@enderror</div>
          <div><label for="departamento_id">Departamento de residencia <span>*</span></label><select id="departamento_id" name="departamento_id" required><option value="">Selecciona un departamento</option></select>@error('departamento_id')<div class="error">{{ $message }}</div>@enderror</div>
          <div><label for="distrito_id">Distrito de residencia <span>*</span></label><select id="distrito_id" name="distrito_id" required disabled><option value="">Selecciona primero un departamento</option></select>@error('distrito_id')<div class="error">{{ $message }}</div>@enderror</div>
          <div class="full"><label>¿Perteneces a una iglesia? <span>*</span></label><div class="choice"><label><input type="radio" name="pertenece_iglesia" value="1" {{ old('pertenece_iglesia', $inscripcion ? ($inscripcion->pertenece_iglesia ? '1' : '0') : '1') === '1' ? 'checked' : '' }} required> Sí</label><label><input type="radio" name="pertenece_iglesia" value="0" {{ old('pertenece_iglesia', $inscripcion ? ($inscripcion->pertenece_iglesia ? '1' : '0') : '1') === '0' ? 'checked' : '' }}> No</label></div><div class="client-error error" data-for="pertenece_iglesia"></div>@error('pertenece_iglesia')<div class="error">{{ $message }}</div>@enderror</div>
          <div id="iglesia-fields" class="full" hidden>
            <div class="grid">
              <div><label for="iglesia">Nombre de la iglesia <span>*</span></label><input id="iglesia" name="iglesia" value="{{ old('iglesia', $inscripcion?->iglesia) }}">@error('iglesia')<div class="error">{{ $message }}</div>@enderror</div>
              <div><label for="departamento_catalogo_id">¿A qué ministerio perteneces? <span>*</span></label><select id="departamento_catalogo_id" name="departamento_catalogo_id"><option value="">Selecciona una opción</option>@foreach($departamentosCatalogo as $departamento)<option value="{{ $departamento->id }}" {{ (string) old('departamento_catalogo_id', $inscripcion?->departamento_catalogo_id) === (string) $departamento->id ? 'selected' : '' }}>{{ $departamento->nombre }}</option>@endforeach</select>@error('departamento_catalogo_id')<div class="error">{{ $message }}</div>@enderror</div>
            </div>
          </div>
          <div class="full"><label>¿Es la primera vez que participa en un campamento? <span>*</span></label><div class="choice"><label><input type="radio" name="primera_vez" value="1" {{ old('primera_vez') === '1' ? 'checked' : '' }} required> Sí</label><label><input type="radio" name="primera_vez" value="0" {{ old('primera_vez') === '0' ? 'checked' : '' }}> No</label></div><div class="client-error error" data-for="primera_vez"></div>@error('primera_vez')<div class="error">{{ $message }}</div>@enderror</div>
        </div>
      </section>
      <section class="card">
        <h2>Contacto de emergencia</h2><p class="section-help">Especialmente importante para participantes menores de edad.</p>
        <div class="grid">
          <div><label for="encargado_nombre">Nombre de padre, madre o encargado <span>*</span></label><input id="encargado_nombre" name="encargado_nombre" value="{{ old('encargado_nombre', $inscripcion?->encargado_nombre) }}" required>@error('encargado_nombre')<div class="error">{{ $message }}</div>@enderror</div>
          <div><label for="encargado_telefono">Número de teléfono del encargado <span>*</span></label><input id="encargado_telefono" name="encargado_telefono" value="{{ old('encargado_telefono', $inscripcion?->encargado_telefono) }}" required>@error('encargado_telefono')<div class="error">{{ $message }}</div>@enderror</div>
        </div>
      </section>
      <section class="card">
        <h2>Salud</h2><p class="section-help">Indica cualquier alergia para que el equipo pueda tomar las precauciones necesarias.</p>
        <div class="grid">
          <div class="full"><label>¿Tiene alguna alergia? <span>*</span></label><div class="choice"><label><input type="radio" name="tiene_alergias" value="1" {{ old('tiene_alergias', $inscripcion ? ($inscripcion->tiene_alergias ? '1' : '0') : null) === '1' ? 'checked' : '' }} required> Sí</label><label><input type="radio" name="tiene_alergias" value="0" {{ old('tiene_alergias', $inscripcion ? ($inscripcion->tiene_alergias ? '1' : '0') : null) === '0' ? 'checked' : '' }}> No</label></div><div class="client-error error" data-for="tiene_alergias"></div>@error('tiene_alergias')<div class="error">{{ $message }}</div>@enderror</div>
          <div id="alergias-fields" class="full"><label for="alergias">Si respondiste sí, ¿cuál?</label><textarea id="alergias" name="alergias" placeholder="Describe la alergia y cualquier indicación importante">{{ old('alergias', $inscripcion?->alergias) }}</textarea>@error('alergias')<div class="error">{{ $message }}</div>@enderror</div>
        </div>
      </section>
      <div class="actions"><span class="required">* Campos obligatorios</span><button type="submit">{{ $editando ? 'Guardar cambios' : 'Enviar inscripción' }}</button></div>
    </form>
    @endif
  </main>
  <script>
    (() => {
      const departamentosTerritoriales = @json($departamentosTerritoriales);
      const departamentoSelect = document.getElementById('departamento_id');
      const distritoSelect = document.getElementById('distrito_id');
      const departamentoInicial = @json(old('departamento_id', $inscripcion?->distrito?->municipio?->id_departamento));
      const distritoInicial = @json(old('distrito_id', $inscripcion?->distrito_id));

      const llenarSelect = (select, items, placeholder, idKey, nameKey, selected = '') => {
        select.innerHTML = `<option value="">${placeholder}</option>`;
        items.forEach(item => {
          const option = new Option(item[nameKey], item[idKey], false, String(item[idKey]) === String(selected));
          select.add(option);
        });
        select.disabled = items.length === 0;
      };

      const actualizarDistritos = (selected = '') => {
        const departamento = departamentosTerritoriales.find(item => String(item.id_departamento) === String(departamentoSelect.value));
        const distritos = (departamento?.municipios ?? []).flatMap(municipio => municipio.distritos ?? []);

        llenarSelect(distritoSelect, distritos, 'Selecciona un distrito', 'id_distrito', 'nombre', selected);
      };

      llenarSelect(departamentoSelect, departamentosTerritoriales, 'Selecciona un departamento', 'id_departamento', 'nombre', departamentoInicial);
      departamentoSelect.addEventListener('change', () => actualizarDistritos());
      actualizarDistritos(distritoInicial);

      const toggleFields = (name, containerId, requiredFields) => {
        const fields = document.getElementById(containerId);
        const inputs = document.querySelectorAll(`input[name="${name}"]`);
        const update = () => {
          const visible = [...inputs].some(input => input.checked && input.value === '1');
          fields.hidden = !visible;
          fields.setAttribute('aria-hidden', String(!visible));
          requiredFields.forEach(id => document.getElementById(id).required = visible);
        };
        inputs.forEach(input => input.addEventListener('change', update));
        update();
      };

      toggleFields('pertenece_iglesia', 'iglesia-fields', ['iglesia', 'departamento_catalogo_id']);
      toggleFields('tiene_alergias', 'alergias-fields', ['alergias']);

      const fechaNacimiento = document.getElementById('fecha_nacimiento');
      const edad = document.getElementById('edad');
      const edadClientError = document.getElementById('edad-client-error');

      const calcularEdad = (fecha) => {
        const [year, month, day] = fecha.split('-').map(Number);
        const hoy = new Date();
        let resultado = hoy.getFullYear() - year;
        const aunNoCumple = hoy.getMonth() + 1 < month
          || (hoy.getMonth() + 1 === month && hoy.getDate() < day);

        if (aunNoCumple) resultado--;
        return resultado;
      };

      const validarEdad = () => {
        edadClientError.textContent = '';
        edad.setCustomValidity('');

        if (!fechaNacimiento.value || edad.value === '') return true;

        const edadCalculada = calcularEdad(fechaNacimiento.value);
        if (Number(edad.value) !== edadCalculada) {
          const mensaje = `La edad no coincide con la fecha de nacimiento. La edad correcta es ${edadCalculada} años.`;
          edadClientError.textContent = mensaje;
          edad.setCustomValidity(mensaje);
          return false;
        }

        return true;
      };

      fechaNacimiento.addEventListener('change', validarEdad);
      edad.addEventListener('input', validarEdad);

      const form = document.querySelector('form');
      form.addEventListener('submit', (event) => {
        form.querySelectorAll('.client-error').forEach(error => error.textContent = '');
        let valid = true;

        if (!validarEdad()) valid = false;

        form.querySelectorAll('input[required], select[required], textarea[required]').forEach(field => {
          if (field.type === 'radio') return;
          if (!field.value.trim()) {
            valid = false;
            const error = document.createElement('div');
            error.className = 'client-error error';
            error.textContent = 'Este campo es obligatorio. Por favor, complétalo.';
            field.insertAdjacentElement('afterend', error);
          }
        });

        ['pertenece_iglesia', 'primera_vez', 'tiene_alergias'].forEach(name => {
          if (!form.querySelector(`input[name="${name}"]:checked`)) {
            valid = false;
            const error = form.querySelector(`[data-for="${name}"]`);
            if (error) error.textContent = 'Debes seleccionar una opción.';
          }
        });

        if (!valid) {
          event.preventDefault();
          const firstError = form.querySelector('.client-error:not(:empty)');
          firstError?.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
      });
    })();
  </script>
</body>
</html>
