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
    <h3>🔧 New Appointment Scheduled for Car Diagnosis 🛠️</h3>
    <br>
    <p>Dear {{ $mechanic->first_name . ' ' . $mechanic->last_name }},</p>
    <p>We have a new appointment scheduled for a car diagnosis. Here are the details:</p>
    <p><strong>🧑🏼‍🦰 Client's Name:</strong> {{ $client->first_name . ' ' . $client->last_name }}</p>
    <p><strong>🚗 Car Details:</strong> {{ $vehicle->make . ' ' . $vehicle->model . ' ' . $vehicle->year }}</p>
    <p><strong>📅 Date:</strong> {{ $date }}</p>
    <p><strong>🕛 Time:</strong> {{ $time }}</p>
    <p>The client will be bringing their car in for a check-up. Please prepare the necessary tools and equipment for the
        diagnosis.</p>
    <p>If there are any issues or if you need additional information, please let me know.</p>
    <p>Best regards,</p>
    <p>Hajar</p>
</body>

</html>
