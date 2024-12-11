<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movicasa - Venta de Terrenos</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: rgb(55, 95, 122);
            color: white;
        }
        nav {
            background: rgb(55, 95, 122);
            padding: 0.5rem 0;
            text-align: center;
        }
        nav a {
            color: white;
            margin: 0 1rem;
            text-decoration: none;
        }
        nav a:hover {
            text-decoration: underline;
        }
        section {
            padding: 2rem;
            background-color: white;
            color: rgb(55, 95, 122);
        }
        footer {
            background: rgb(38, 186, 165);
            color: white;
            text-align: center;
            padding: 1rem 0;
        }
        .hero {
            background: url('terreno.jpg') no-repeat center center/cover;
            height: 50vh;
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
        }
        .hero h1 {
            font-size: 3rem;
            margin: 0;
        }
        .card {
            border: 1px solid #ddd;
            padding: 1rem;
            margin: 1rem 0;
            border-radius: 8px;
            background-color: white;
            color: rgb(55, 95, 122);
        }
        .card img {
            width: 100%;
            height: auto;
            border-radius: 8px;
        }
        .btn-login {
            background-color: rgb(38, 186, 165);
            color: white;
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin: 0.5rem;
        }
        .btn-login:hover {
            background-color: white;
            color: rgb(38, 186, 165);
        }
        .whatsapp {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background: #25D366;
            color: white;
            border-radius: 50%;
            width: 60px;
            height: 60px;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 2rem;
            text-decoration: none;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
        }
        .whatsapp:hover {
            background: #20b358;
        }
        .login-section {
            text-align: center;
            margin-top: 2rem;
        }
    </style>
</head>
<body>

<nav>
    <a href="#disponibles">Terrenos Disponibles</a>
    <a href="#sobre-nosotros">Sobre Nosotros</a>
    <a href="#testimonios">Testimonios</a>
</nav>

<section class="hero">
    <h1>¡Haz realidad tu proyecto hoy!</h1>
</section>

<section id="disponibles">
    <h2>Terrenos Disponibles</h2>
        @forelse($houses as $house)
                <div class="col-md-4 mb-4">
                    <div class="card">
                        @if($house->photos->isNotEmpty())
                            <img src="{{ asset('storage/' . $house->photos->first()->path) }}" class="card-img-top" alt="Imagen de la casa">
                        @else
                            <img src="https://via.placeholder.com/400x300" class="card-img-top" alt="Imagen no disponible">
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">{{ $house->title }}</h5>
                            <p class="card-text">{{ $house->address }}</p>
                            <p><strong>Precio:</strong> Bs. {{ number_format($house->price, 2) }}</p>
                            <p><strong>Habitaciones:</strong> {{ $house->bedrooms }} | <strong>Baños:</strong> {{ $house->bathrooms }}</p>
                            <p><strong>Categoría:</strong> {{ $house->category->name ?? 'Sin categoría' }}</p>
                            <a href="#" class="btn btn-info">Ver detalles</a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <p class="text-center">No hay casas disponibles en esta categoría.</p>
                </div>
            @endforelse
</section>

<section id="sobre-nosotros">
    <h2>Sobre Nosotros</h2>
    <p>Somos una empresa con más de 10 años de experiencia en la venta de terrenos. Nuestro compromiso es ayudarte a encontrar el terreno perfecto para tu proyecto.</p>
</section>

<section id="testimonios">
    <h2>Testimonios</h2>
    <blockquote>
        "Gracias a esta empresa encontré el terreno perfecto para construir mi casa. Muy recomendados!" - Ana Pérez
    </blockquote>
    <blockquote>
        "Excelente atención y asesoramiento durante todo el proceso." - Carlos López
    </blockquote>
</section>

<section class="login-section">
    <h2>Login</h2>
    <button class="btn-login">Iniciar Sesión</button>
</section>

<section id="redes-sociales">
    <h2>Redes Sociales</h2>
    <p>Síguenos en nuestras redes sociales para más actualizaciones:</p>
    <ul>
        <li><a href="#">Facebook</a></li>
        <li><a href="#">Instagram</a></li>
        <li><a href="#">Twitter</a></li>
    </ul>
</section>

<footer>
    <p>&copy; 2024 Movicasa. Todos los derechos reservados.</p>
</footer>

<a href="https://wa.me/123456789" class="whatsapp" target="_blank">&#x1F4AC;</a>

</body>
</html>



{{-- <!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Casas en Venta</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Listado de Casas en Venta</h1>

        <!-- Filtro de Categorías -->
        <form method="GET" action="{{ route('home') }}" class="mb-4">
            <div class="input-group">
                <select name="category" class="form-select">
                    <option value="">Todas las Categorías</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" 
                                {{ request('category') == $category->id ? 'selected' : '' }}>
                            {{ $category->category }}
                        </option>
                    @endforeach
                </select>
                <button type="submit" class="btn btn-primary">Filtrar</button>
            </div>
        </form>

        <!-- Listado de Casas -->
        <div class="row">
            @forelse($houses as $house)
                <div class="col-md-4 mb-4">
                    <div class="card">
                        @if($house->photos->isNotEmpty())
                            <img src="{{ asset('storage/' . $house->photos->first()->path) }}" class="card-img-top" alt="Imagen de la casa">
                        @else
                            <img src="https://via.placeholder.com/400x300" class="card-img-top" alt="Imagen no disponible">
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">{{ $house->title }}</h5>
                            <p class="card-text">{{ $house->address }}</p>
                            <p><strong>Precio:</strong> Bs. {{ number_format($house->price, 2) }}</p>
                            <p><strong>Habitaciones:</strong> {{ $house->bedrooms }} | <strong>Baños:</strong> {{ $house->bathrooms }}</p>
                            <p><strong>Categoría:</strong> {{ $house->category->name ?? 'Sin categoría' }}</p>
                            <a href="#" class="btn btn-info">Ver detalles</a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <p class="text-center">No hay casas disponibles en esta categoría.</p>
                </div>
            @endforelse
        </div>
    </div>
</body>
</html> --}}