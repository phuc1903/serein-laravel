<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('css/mail.css') }}">
    <title>Document</title>
</head>
<body>

    <div class="email-container">
        <div class="header">
            <h1> {{ config('app.name') }}</h1>
        </div>
        <div class="content">
            {{ $slot }}
        </div>
        <div class="footer">
            <p>&copy; 2024 Serin Jewelry. All rights reserved.</p>
        </div>
    </div>

</body>
</html>