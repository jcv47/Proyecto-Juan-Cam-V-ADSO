@extends('layouts.front')

@section('title', 'Sondar')

@section('content')
  <section class="portada">
    <h1>Sondar: Innovación a tu Alcance</h1>
    <p>
      Transformamos tus ideas en realidad digital con soluciones tecnológicas
      de vanguardia, diseñadas para impulsar el crecimiento y la eficiencia de tu negocio.
    </p>

    <div class="buttons">
      <a class="btn primary" href="{{ route('ui.servicios') }}">Nuestros Servicios</a>

      @auth
        <a class="btn secondary" href="{{ route('ui.contacto') }}">Contáctanos</a>
      @endauth

      @guest
        <a class="btn secondary" href="{{ route('login') }}">Contáctanos</a>
      @endguest
    </div>
  </section>

  <section class="features">
    <h2>¿Por Qué Elegir Sondar?</h2>
    <div class="cards">
      <div class="card">
        <div class="icon"></div>
        <h3>Experiencia Comprobada</h3>
        <p>Años de experiencia entregando proyectos exitosos a clientes satisfechos.</p>
      </div>
      <div class="card">
        <div class="icon"></div>
        <h3>Soluciones Innovadoras</h3>
        <p>Nos mantenemos a la vanguardia de la tecnología para ofrecerte lo último en innovación.</p>
      </div>
      <div class="card">
        <div class="icon"></div>
        <h3>Equipo Dedicado</h3>
        <p>Un equipo de profesionales apasionados y comprometidos con tu éxito.</p>
      </div>
    </div>
  </section>

  <section class="Futurodigital">
    <div class="contenido">
      <div class="texto">
        <h2>Impulsando el Futuro Digital</h2>
        <p>
          En TecnoSoluciones, estamos dedicados a construir el futuro digital. Nuestra pasión
          por la tecnología y el compromiso con nuestros clientes nos convierten en el socio
          ideal para tus proyectos más ambiciosos. Descubre cómo podemos ayudarte a alcanzar
          tus objetivos.
        </p>
        <a class="btn primary" href="{{ route('ui.productos') }}">Conoce Nuestros Productos</a>
      </div>

      <div class="imagen">
        <img src="{{ asset('img/Futurodigital.png') }}" alt="Futuro digital">
      </div>
    </div>
  </section>
@endsection