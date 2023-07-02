@extends('templates.base')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Combined Line Chart for All Sensors</div>
                    <div class="card-body">
                        <canvas id="combinedLineChart" style="width: 100%; height: 300px;"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            @foreach($dataArray as $sensorIndex => $sensorData)
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">Line Chart for Sensor {{$sensorIndex + 1}}</div>
                        <div class="card-body">
                            <canvas id="lineChart{{$sensorIndex}}" style="width: 100%; height: 300px;"></canvas>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
    <script>
        var combinedLabels = [];
        var combinedColors = [];

        @foreach($dataArray as $sensorIndex => $sensorData)
            var labels{{$sensorIndex}} = {!! json_encode(array_keys($sensorData)) !!};
            var data{{$sensorIndex}} = {!! json_encode(array_column($sensorData, 'data')) !!};

            combinedLabels = labels{{$sensorIndex}}; // Use the labels from the first sensor as the common labels for all sensors

            // Generate a random color for each sensor
            var randomColor = getRandomColor();
            combinedColors.push(randomColor);

            var ctx{{$sensorIndex}} = document.getElementById('lineChart{{$sensorIndex}}').getContext('2d');
            var lineChart{{$sensorIndex}} = new Chart(ctx{{$sensorIndex}}, {
                type: 'line',
                data: {
                    labels: labels{{$sensorIndex}},
                    datasets: [{
                        label: 'Sensor {{$sensorIndex + 1}}',
                        data: data{{$sensorIndex}},
                        borderColor: randomColor,
                        backgroundColor: 'rgba(0, 0, 0, 0)', // Set a transparent background color
                        fill: false,
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        datalabels: {
                            display: true,
                            anchor: 'end',
                            align: 'top',
                            font: {
                                weight: 'bold'
                            }
                        }
                    },
                    scales: {
                        x: {
                            display: true,
                            title: {
                                display: true,
                                text: 'Date'
                            }
                        },
                        y: { 
                            display: true,
                            title: {
                                display: true,
                                text: 'Value'
                            }
                        }
                    }
                }
            });
        @endforeach

        var ctx = document.getElementById('combinedLineChart').getContext('2d');
        var combinedLineChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: combinedLabels,
                datasets: [
                    @foreach($dataArray as $sensorIndex => $sensorData)
                    {
                        label: 'Sensor {{$sensorIndex + 1}}',
                        data: data{{$sensorIndex}},
                        borderColor: getRandomColor(),
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        fill: false,
                    },
                    @endforeach
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    datalabels: {
                        display: true,
                        anchor: 'end',
                        align: 'top',
                        font: {
                            weight: 'bold'
                        }
                    }
                },
                scales: {
                    x: {
                        display: true,
                        title: {
                            display: true,
                            text: 'Date'
                        }
                    },
                    y: {
                        display: true,
                        title: {
                            display: true,
                            text: 'Value'
                        }
                    }
                }
            }
        });

        // Function to generate a random color
        function getRandomColor() {
            var letters = '0123456789ABCDEF';
            var color = '#';
            for (var i = 0; i < 6; i++) {
                color += letters[Math.floor(Math.random() * 16)];
            }
            return color;
        }
    </script>
@endsection
