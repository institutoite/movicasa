<!DOCTYPE html>
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
</html>