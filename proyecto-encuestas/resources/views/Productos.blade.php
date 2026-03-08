@extends('layouts.front')

@section('title', 'Sondar - Productos')

@section('content')
  <section class="features">
    <h2>Nuestros Productos</h2>
    <div class="cards">
      <div class="card">
        <div class="icon">💻</div>
        <h3>Software Empresarial</h3>
        <p>Aplicaciones diseñadas para optimizar los procesos internos de tu compañía.</p>
      </div>
      <div class="card">
        <div class="icon">📱</div>
        <h3>Web en móvil</h3>
        <p>Soluciones móviles intuitivas que conectan tu negocio con tus clientes en cualquier lugar.</p>
      </div>
      <div class="card">
        <div class="icon">☁️</div>
        <h3>Soluciones en la Nube</h3>
        <p>Infraestructura confiable y escalable para garantizar el crecimiento sostenible de tu empresa.</p>
      </div>
    </div>
  </section>
@endsection