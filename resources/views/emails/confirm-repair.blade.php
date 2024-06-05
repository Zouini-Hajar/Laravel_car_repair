<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Meeting Confirmation</title>
    <style>
        * {
            color: black;
        }
    </style>
</head>

<body>
    <?php extract($data); ?>
    <h3>🚗 Meeting Confirmed! Your Car's Check-up is Scheduled 🛠️</h3>
    <br>
    <p>Dear {{ $client->first_name . ' ' . $client->last_name }},</p>
    <p>Great news! Your appointment for your car's diagnosis at our garage has been confirmed. Here are the details:</p>
    <p><strong>📅 Date:</strong> {{ $date }}</p>
    <p><strong>🕛 Time:</strong> {{ $time }}</p>
    <p>We're looking forward to giving your car the care it deserves. Please remember to bring any documents or
        information that could help us understand your car's condition better.</p>
    <p>Drive safe and see you soon,</p>
    <p>Hajar</p>
</body>

</html>
