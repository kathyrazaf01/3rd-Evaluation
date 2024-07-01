<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails du Bien</title>
</head>
<body>
    @foreach ($results as $result)
        <h2>{{ $result->nombien }}</h2>
        <p>Région : {{ $result->region }}</p>
        <p>Loyer : {{ $result->loyer }} AR</p>
        <div>
            <h3>Photos :</h3>
            @foreach ($photos as $photo)
                <img src="{{ asset('assets/darkpan/img/' . $photo->photo) }}" alt="{{ $result->nombien }}" style="width: 200px; height: auto;">
            @endforeach
        </div>
        <hr>
    @endforeach
</body>
</html>

