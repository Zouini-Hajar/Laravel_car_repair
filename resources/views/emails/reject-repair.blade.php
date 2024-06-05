<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Meeting Update</title>
    <style>
        * {
            color: black;
        }
    </style>
</head>

<body>
    <?php extract($data); ?>
    <h3>🚦 Meeting Rescheduled: Let's Find a New Date for Your Car's Check-up 🗓️</h3>
    <br>
    <p>Dear {{ $client->first_name . ' ' . $client->last_name }},</p>
    <p>We're sorry, but we're unable to confirm the meeting for your car's diagnosis at the time you requested. It
        seems like our garage is a bit too crowded at that time.</p>
    <p>But don't worry, we're committed to helping you out. Could you please suggest a few alternate dates and times
        that work for you? We'll do our best to accommodate your schedule.</p>
    <p>Thank you for your understanding,</p>
    <p>Hajar</p>
</body>

</html>
