<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Nuovo messaggio ricevuto dal form contatti di Boolpress.</h1>

    <ul>
        <li>
            <strong>Nome Utente:</strong> {{ $contactInfo->name }}
        </li>
        <li>
            <strong>Email:</strong> {{ $contactInfo->email }}
        </li>
    </ul>
    <p>
        {{ $contactInfo->message }}
    </p>
</body>
</html>