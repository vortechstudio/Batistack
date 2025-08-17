@extends('components.layouts.auth')

@section('content')
    <div class="container">
        <div class="alert alert-danger">
            <h1>Erreur 500</h1>
            <p>{{ \$message ?? 'Une erreur est survenue lors de la connexion à l\'API' }}</p>
        </div>
    </div>
@endsection
