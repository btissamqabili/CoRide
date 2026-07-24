
 <!DOCTYPE html>
<html>
<head>
    <title>Compatibilité</title>
</head>
<body>

<h2>Résultat IA</h2>

<p><strong>Score :</strong> {{ $reservation->compatibility['score'] }}</p>

<p><strong>Justification :</strong></p>

<p>{{ $reservation->compatibility['justification'] }}</p>

<p><strong>Horaire suggéré :</strong> {{ $reservation->compatibility['horaire_suggere'] }}</p>

</body>
</html>