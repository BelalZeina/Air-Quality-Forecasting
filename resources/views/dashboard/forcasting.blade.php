@extends('layouts.dashboard.app')
@section('header__title', __('home.Dashboard'))
@section('header__icon', 'fa-solid fa-house')

@section('main')
<div class="container">
    <h1 class="my-4 text-center">Feature Forecast Dashboard</h1>
    <div class="card mt-2 p-2" style="border-radius: 10px;">
        <div class="row">
            <div class="col-lg-3 col-md-12">
                <!-- Input Form -->
                <form id="forecastForm" action="{{route("forcasting")}}">
                    <div class="mb-3">
                        <label for="feature" class="form-label">Feature</label>
                        <select id="feature" name="feature" class="form-select" onchange="this.form.submit()" required>
                            <option value="pm25" {{request("feature")=="pm25" ?"selected":""}} >PM2.5</option>
                            <option value="pm10" {{request("feature")=="pm10" ?"selected":""}} >PM10</option>
                            <option value="No2" {{request("feature")=="No2" ?"selected":""}}>NO2</option>
                        </select>
                    </div>
                    {{-- <button id="submit" type="submit" class="btn btn-primary w-100">Get Forecast</button> --}}
                </form>
            </div>
            <div class="col-lg-9 col-md-12">
                <!-- Chart -->
                <div class="card-body" style="background: #ffffff; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
                    <h5 class="card-title text-primary" style="font-weight: bold;">{{ __('Air Quality Forecasting Data') }}</h5>
                    <canvas id="forecastChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts-dashboard')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<!-- Add Axios for API calls -->
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const ctx = document.getElementById('forecastChart').getContext('2d');

        // Fetch data from the server-side variables
        const dates = @json($dates); // JSON-encoded array
        const actualData = @json($actual); // JSON-encoded array
        const predictedData = @json($predictions); // JSON-encoded array

        // Initialize the chart
        const airQualityChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: dates, // X-axis labels
                datasets: [
                    {
                        label: 'Actual',
                        data: actualData,
                        borderColor: 'rgb(75, 192, 192)',
                        fill: false,
                        tension: 0.1
                    },
                    {
                        label: 'Predictions',
                        data: predictedData,
                        borderColor: 'rgb(255, 99, 132)',
                        borderDash: [5, 5],
                        fill: false,
                        tension: 0.1
                    }
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: 'Air Quality Predictions'
                    }
                },
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Date'
                        }
                    },
                    y: {
                        title: {
                            display: true,
                            text: 'Concentration (ug/m3)'
                        },
                        beginAtZero: true
                    }
                }
            }
        });
    });
</script>
@endsection
