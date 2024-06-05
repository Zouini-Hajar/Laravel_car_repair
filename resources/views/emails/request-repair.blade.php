<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Meeting Request</title>
    <style>
        * {
            color: black;
        }

        h1 {
            margin-bottom: 10px;
        }

        p {
            margin-bottom: 6px;
        }

        .links {
            display: flex;
            margin-top: 15px;
        }

        .container a {
            text-decoration: none;
            background-color: #7927CA;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            font-weight: bold;
            cursor: pointer;
            margin-right: 10px
        }

        .container a:hover {
            background-color: #6A1B9A;
        }

        .container a.red {
            background-color: #E33E1E;
        }

        .container a.red:hover {
            background-color: #C23016;
        }
    </style>
</head>

<body>
    <?php extract($data); ?>
    <div class="container">
        <h1>Meeting Request from {{ $client->first_name . ' ' . $client->last_name }}</h1>
        <p>A new car repair request has been submitted from {{ $client->first_name . ' ' . $client->last_name }}. Here
            are the details:</p>
        <p><strong>🚗 Car Details:</strong> {{ $vehicle->make . ' ' . $vehicle->model . ' ' . $vehicle->year }}</p>
        <p><strong>🗓️ Meeting Date and Time:</strong> {{ $date . ' at ' . $time }}</p>
        <p><strong>⚠️ Description of the Issue:</strong> {{ $description }}</p>
        <div class="links">
            <a href="{{ url('/confirm-repair?client_id=' . $client->id . '&vehicle_id=' . $vehicle->id . '&date=' . $date . '&time=' . $time) }}"
                class="confirm">Confirm</a>
            <a href="{{ url('/reject-repair?client_id=' . $client->id) }}" class="red">Reject</a>
        </div>
    </div>
    </div>

</body>

</html>
