<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Redirecting...</title>
    <script>
        window.location.replace("{{ $url }}");
    </script>
</head>
<body>
    Redirecting to {{ $url }}...
    <br>
    <a href="{{ $url }}">Click here if you are not redirected automatically.</a>
</body>
</html>
