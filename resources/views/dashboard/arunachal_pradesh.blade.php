@extends('layouts.dashboard.app')
@section('header__title', __('home.Dashboard'))
@section('header__icon', 'fa-solid fa-house')

@section('main')
<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">

        <div class="row">
            <!-- Date Range and City Filter Form -->
            <form action="{{ route('arunachal_pradesh') }}" method="GET" class="card my-4 pt-2">
                <div class="mb-3">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="start_date" class="form-label">Start Date:</label>
                            <input type="date" id="start_date" name="start_date" class="form-control"
                                value="{{ $start_date->toDateString() }}">
                        </div>
                        <div class="col-md-4">
                            <label for="end_date" class="form-label">End Date:</label>
                            <input type="date" id="end_date" name="end_date" class="form-control"
                                value="{{ $end_date->toDateString() }}">
                        </div>
                        <div class="col-md-4">
                            <label for="city" class="form-label">City:</label>
                            <select id="city" name="city" class="form-control" onchange="this.form.submit()">
                                <option value="">Select City</option>
                                @foreach($cities as $city)
                                <option value="{{ $city }}" {{ request('city') == $city ? 'selected' : '' }}>
                                    {{ $city }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mt-2">
                            <button type="submit" class="btn btn-primary">Filter</button>
                        </div>
                    </div>
                </div>
            </form>


            <!-- Chart Card -->
            <div class="card mb-3  col-9">
                <div class="card-body">
                    <h5 class="card-title">{{ __('Air Quality Data') }}</h5>
                    <canvas id="airQualityChart"></canvas>
                </div>
            </div>
            <!-- Chart Card -->
            <div class="card mb-3 col-3">
                <div class="card-body">
                    <iframe class="rounded-top w-100"
                    style="height: 500px; margin-bottom: -6px;"
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3702174.436633267!2d91.3582308!3d28.2179981!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x377028f0c1f4a4ab%3A0x9fa91e598423cfa7!2sArunachal%20Pradesh!5e0!3m2!1sen!2sin!4v1694259649153!5m2!1sen!2sin"
                    loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>
        </div>

    </div>
    <!-- Footer -->
    <footer class="content-footer footer bg-footer-theme">
        <div class="container-xxl d-flex flex-wrap justify-content-between py-2 flex-md-row flex-column">
            <div class="mb-2 mb-md-0">
                ©
                <script>
                    document.write(new Date().getFullYear());
                </script>
                , made with ❤️ by
                <a href="https://themeselection.com" target="_blank" class="footer-link fw-bolder">Belal Zeina</a>
            </div>
        </div>
    </footer>
    <div class="content-backdrop fade"></div>
</div>
@endsection

@section('scripts-dashboard')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Get the data passed from the controller
    const labels = @json(array_column($filteredData, 'from_date'));  // X-axis labels
    const datasets = [
        {
            label: 'PM2.5 (ug/m3)',
            data: @json(array_column($filteredData, 'pm25')),
            borderColor: 'rgb(75, 192, 192)',
            fill: false,
            tension: 0.1
        },
        {
            label: 'PM10 (ug/m3)',
            data: @json(array_column($filteredData, 'pm10')),
            borderColor: 'rgb(255, 99, 132)',
            fill: false,
            tension: 0.1
        },
        {
            label: 'NO (ug/m3)',
            data: @json(array_column($filteredData, 'NO')),
            borderColor: 'rgb(54, 162, 235)',
            fill: false,
            tension: 0.1
        },
        {
            label: 'NO2 (ug/m3)',
            data: @json(array_column($filteredData, 'NO2')),
            borderColor: 'rgb(255, 206, 86)',
            fill: false,
            tension: 0.1
        }
    ];

    // Create the chart
    const ctx = document.getElementById('airQualityChart').getContext('2d');
    const airQualityChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: datasets
        },
        options: {
            responsive: true,
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
</script>
@endsection
