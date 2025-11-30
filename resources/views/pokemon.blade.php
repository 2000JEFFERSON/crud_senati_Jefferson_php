<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Pokémon</title>


<!-- Bootstrap -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" />
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>


<style>
body {
background: linear-gradient(135deg, #b3e5ff, #e3f5ff);
min-height: 100vh;
}
.card-container {
background: white;
border-radius: 20px;
padding: 30px;
box-shadow: 0 4px 20px rgba(0,0,0,0.1);
}
table img {
width: 80px;
height: 80px;
image-rendering: pixelated;
}
h1 {
font-weight: 700;
letter-spacing: 1px;
text-shadow: 1px 1px 3px rgba(0,0,0,0.2);
}
</style>
</head>
<body>
<div class="container mt-5">
<div class="card-container">
<h1 class="text-center mb-4">Lista de Pokémon</h1>


<table class="table table-striped table-bordered text-center align-middle">
<thead class="table-primary">
<tr>
<th>ID</th>
<th>Nombre</th>
<th>Forma Normal</th>
<th>Forma Shiny</th>
</tr>
</thead>
<tbody>
@foreach($LocalPokemon as $p)
<tr>
<td>{{ $p->id }}</td>
<td>{{ $p->name }}</td>
<td><img src="{{ $p->image }}" alt="{{ $p->name }}"></td>
<td><img src="{{ $p->imageS }}" alt="{{ $p->name }} Shiny"></td>
</tr>
@endforeach
</tbody>
</table>
</div>
</div>
</body>
</html>