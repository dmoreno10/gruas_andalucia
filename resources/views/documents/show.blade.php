<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $document->title }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        .document-info {
            margin-bottom: 20px;
        }
        .document-info p {
            margin: 5px 0;
        }
        .document-view {
            text-align: center;
        }
        .document-view img {
            max-width: 100%;
            height: auto;
        }
        .document-view a {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background: #3498db;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        .document-view a:hover {
            background: #2980b9;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>{{ $document->title }}</h1>
    <div class="document-info">
        <p><strong>Descripción:</strong> {{ $document->description }}</p>
        <p><strong>Tamaño:</strong> {{ $document->file_size }} bytes</p>
        <p><strong>Tipo MIME:</strong> {{ $document->mime_type }}</p>
    </div>

    <div class="document-view">
        @if (in_array($document->mime_type, ['image/jpeg', 'image/png', 'image/jpg']))
            <img src="{{ asset('storage/' . $document->file_path) }}" alt="{{ $document->title }}">
        @elseif ($document->mime_type === 'application/pdf')
            <iframe src="{{ asset('storage/' . $document->file_path) }}" style="width:100%; height:600px;" frameborder="0"></iframe>
        @else
            <p>No se puede mostrar el archivo. <a href="{{ asset('storage/' . $document->file_path) }}" download>Descargar</a></p>
        @endif

        <a href="{{ asset('storage/' . $document->file_path) }}" download>Descargar Documento</a>
    </div>
</div>

</body>
</html>
