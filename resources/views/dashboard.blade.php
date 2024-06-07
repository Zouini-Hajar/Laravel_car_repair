@extends('layout')

@section('content')
    <div class="flex justify-between items-center my-5">
        <h3 class="text-3xl font-bold text-gray-900 dark:text-white">
            Dashboard
        </h3>
    </div>
    <div>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div
                class="stat-card bg-gradient-to-r from-purple-500 to-purple-700 text-white p-6 rounded-lg shadow-lg hover:shadow-xl transition duration-300">
                <i class="fas fa-users text-4xl mb-4"></i>
                <h2 class="text-lg mb-2">Clients</h2>
                <p class="font-bold text-3xl">{{ $clients }}</p>
            </div>
            <div
                class="stat-card bg-gradient-to-r from-sky-500 to-sky-700 text-white p-6 rounded-lg shadow-lg hover:shadow-xl transition duration-300">
                <i class="fas fa-toolbox text-4xl mb-4"></i>
                <h2 class="text-lg mb-2">Mechanics</h2>
                <p class="font-bold text-3xl">{{ $mechanics }}</p>
            </div>
            <div
                class="stat-card bg-gradient-to-r from-purple-500 to-purple-700 text-white p-6 rounded-lg shadow-lg hover:shadow-xl transition duration-300">
                <i class="fas fa-car text-4xl mb-4"></i>
                <h2 class="text-lg mb-2">Vehicles</h2>
                <p class="font-bold text-3xl">{{ $vehicles }}</p>
            </div>
            <div
                class="stat-card bg-gradient-to-r from-sky-500 to-sky-700 text-white p-6 rounded-lg shadow-lg hover:shadow-xl transition duration-300">
                <i class="fas fa-screwdriver-wrench text-4xl mb-4"></i>
                <h2 class="text-lg mb-2">Repairs</h2>
                <p class="font-bold text-3xl">{{ $repairs }}</p>
            </div>
        </div>
        <div class="grid grid-cols-2 gap-8 mt-8">
            <div class='p-6 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700'>
                <div class="flex justify-between items-center">
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white">
                        Repairs per mechanic
                    </h3>
                </div>
                <hr class="my-4">
                <canvas id="repairsPerMechanic"></canvas>
            </div>
            <div class='p-6 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700'>
                <div class="flex justify-between items-center">
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white">
                        Vehicle Types
                    </h3>
                </div>
                <hr class="my-4">
                <canvas class="mx-auto" id="vehicleTypes"></canvas>
            </div>
        </div>
    </div>
    <script>
        var ctx1 = document.getElementById('repairsPerMechanic').getContext('2d');
        var repairsPerMechanicChart = new Chart(ctx1, {
            type: 'bar',
            data: {
                labels: ['Mechanic 1', 'Mechanic 2', 'Mechanic 3', 'Mechanic 4', 'Mechanic 5'],
                datasets: [{
                    label: '# of Repairs',
                    data: [12, 19, 3, 5, 2],
                    backgroundColor: [
                        '#7e22ce',
                        '#9333ea',
                        '#a855f7',
                        '#c084fc',
                        '#d8b4fe'
                    ]
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        var ctx2 = document.getElementById('vehicleTypes').getContext('2d');
        var vehicleTypesChart = new Chart(ctx2, {
            type: 'pie',
            data: {
                labels: ['Car', 'Truck', 'Motorcycle'],
                datasets: [{
                    label: 'Vehicle Types',
                    data: [25, 15, 10],
                    backgroundColor: [
                        '#7e22ce',
                        '#0ea5e9',
                        '#a855f7',
                    ]
                }]
            },
            options: {
                responsive: false
            }
        });
    </script>
@endsection
