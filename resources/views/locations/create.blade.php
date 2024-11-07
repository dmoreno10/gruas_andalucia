<!-- resources/views/locations/create.blade.php -->
@extends('layouts.app')

@section('content')
    <h1>Create Location</h1>

    <form action="{{ route('locations.store') }}" method="POST">
        @csrf
        <label for="name">Location Name:</label>
        <input type="text" name="name" id="name" required>

        <label for="latitude">Latitude:</label>
        <input type="text" name="latitude" id="latitude" required readonly>

        <label for="longitude">Longitude:</label>
        <input type="text" name="longitude" id="longitude" required readonly>

        <div id="map" style="height: 400px; width: 100%;"></div>

        <button type="submit">Save Location</button>
    </form>

    <script>
        function initMap() {
            const map = new google.maps.Map(document.getElementById('map'), {
                zoom: 8,
                center: { lat: -34.397, lng: 150.644 },  // Configura una ubicación predeterminada
            });

            const marker = new google.maps.Marker({
                position: { lat: -34.397, lng: 150.644 },
                map: map,
                draggable: true
            });

            // Actualiza los campos de latitud y longitud cuando el marcador se mueva
            google.maps.event.addListener(marker, 'dragend', function (event) {
                document.getElementById('latitude').value = event.latLng.lat();
                document.getElementById('longitude').value = event.latLng.lng();
            });
        }
    </script>
    <script async defer
        src="https://maps.googleapis.com/maps/api/js?key=YOUR_GOOGLE_MAPS_API_KEY&callback=initMap">
    </script>
@endsection
