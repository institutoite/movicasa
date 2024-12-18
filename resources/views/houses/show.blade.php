<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $house->title }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    
    <div class="container mt-5">
        <h1 class="text-center text-primary">{{ $house->title }}</h1>
        <p class="text-center text-secondary"><strong>Categoría:</strong> {{ $house->category->category ?? 'Sin categoría' }}</p>

        <!-- Carrusel de imágenes -->
        @if ($house->photos->isNotEmpty())
        <div id="houseCarousel" class="carousel slide mb-4" data-bs-ride="carousel">
            <div class="carousel-inner">
                @foreach ($house->photos as $index => $photo)
                <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                    <img src="{{ asset('storage/' . $photo->path) }}" class="d-block w-100" alt="Imagen de {{ $house->title }}">
                </div>
                @endforeach
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#houseCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Anterior</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#houseCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Siguiente</span>
            </button>
        </div>
        @else
            <p class="text-center text-muted">No hay imágenes disponibles para esta propiedad.</p>
        @endif

        <!-- Información detallada -->
        <div class="card shadow mb-4">
            <div class="card-body">
                <h5 class="card-title">Descripción</h5>
                <p class="card-text">{!! $house->description !!}</p>
                <hr>
                <ul class="list-group">
                    <li class="list-group-item"><strong>Precio:</strong> ${{ number_format($house->price, 2) }}</li>
                    <li class="list-group-item"><strong>Dirección:</strong> {{ $house->address }}</li>
                    <li class="list-group-item"><strong>Habitaciones:</strong> {{ $house->bedrooms }}</li>
                    <li class="list-group-item"><strong>Baños:</strong> {{ $house->bathrooms }}</li>
                    <li class="list-group-item"><strong>Garaje:</strong> {{ $house->garage }} espacios</li>
                    <li class="list-group-item"><strong>Área:</strong> {{ $house->area }} m²</li>
                    @if ($house->latitud && $house->longitud)
                    <li class="list-group-item"><strong>Coordenadas:</strong> Latitud {{ $house->latitud }}, Longitud {{ $house->longitud }}</li>
                    @endif

                </ul>
            </div>
        </div>
        <div class="text-center">
            <a href="{{ route('home') }}" class="btn btn-danger">Volver atrás</a>
            <a href="https://wa.me/59172655998" class="btn btn-success" target="_blank">Reservar</a>
        </div>
        <!-- Botón de regreso -->
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>