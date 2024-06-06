<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.css" rel="stylesheet" />
    <title>Invoice</title>
</head>

<body>
    <div class="rounded-lg shadow-lg px-8 py-10 my-4 max-w-xl mx-auto">
        <div class="text-gray-700 mb-8">
            <div class="font-bold text-xl mb-2">INVOICE</div>
            <div class="text-sm">Date : {{ now()->format('d/m/Y') }}</div>
            <div class="text-sm">Invoice Id : {{ $data['id'] }}</div>
        </div>
        <div class="border-b-2 border-gray-300 pb-8 mb-8">
            <h2 class="text-2xl font-bold mb-4">Bill To:</h2>
            <div class="text-gray-700 mb-2">{{ $data['full_name'] }}</div>
            <div class="text-gray-700 mb-2">{{ $data['address'] }}</div>
            <div class="text-gray-700">{{ $data['email'] }}</div>
        </div>
        <table class="w-full mb-8">
            <thead>
                <tr>
                    <th class="text-gray-700 text-left font-bold py-2">Description</th>
                    <th class="text-gray-700 text-left font-bold py-2">Quantity</th>
                    <th class="text-gray-700 text-left font-bold py-2">Price</th>
                    <th class="text-gray-700 text-left font-bold py-2">Total</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="py-2 text-gray-700">{{ $repair->description }}</td>
                    <td class="py-2 text-gray-700">-</td>
                    <td class="py-2 text-gray-700">{{ $repair->price }} DH</td>
                    <td class="py-2 text-gray-700">{{ $repair->price }} DH</td>
                </tr>
                @foreach ($spareparts as $item)
                    <tr>
                        <td class="py-2 text-gray-700">{{ $item['name'] }}</td>
                        <td class="py-2 text-gray-700">{{ $item['quantity'] }}</td>
                        <td class="py-2 text-gray-700">{{ $item['price'] }} DH</td>
                        <td class="py-2 text-gray-700">{{ $item['price'] * $item['quantity'] }} DH</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="flex justify-end mb-8">
            <div class="text-gray-700 mr-2">Total:</div>
            <div class="text-gray-700 font-bold text-xl">{{ $data['total'] }} DH</div>
        </div>
    </div>
</body>

</html>
