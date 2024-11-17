@extends('layouts.dashboard.app')
@section('header__title', __('home.Dashboard'))
@section('header__icon', 'fa-solid fa-house')

@section('main')
<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">

        <div class="row">
            <!-- Date Range Filter Form -->
            <form action="{{ route('dashboard') }}" method="GET" class="card my-4 pt-2 ">
                <div class="mb-3">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="start_date" class="form-label">Start Date:</label>
                            <input type="date" id="start_date" name="start_date" class="form-control"
                                value="{{ $start_date->toDateString() }}">
                        </div>
                        <div class="col-md-6">
                            <label for="end_date" class="form-label">End Date:</label>
                            <input type="date" id="end_date" name="end_date" class="form-control"
                                value="{{ $end_date->toDateString() }}">
                        </div>
                        <div class="mt-2">
                            <button type="submit" class="btn btn-primary">Filter</button>
                        </div>
                    </div>
                </div>

            </form>


            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">{{ __('show data of pm25') }}</h5>
                    <canvas id="pm25Chart"></canvas>
                </div>
            </div>
        </div>

    </div>
    <!-- / Content -->

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
            <div>

            </div>
        </div>
    </footer>
    <!-- / Footer -->

    <div class="content-backdrop fade"></div>
</div>
@endsection

@section('scripts-dashboard')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Get the data passed from the controller
    const labels = @json($dates);  // Dates from the controller
    const pm25Data = @json($pm25);  // PM2.5 values from the controller

    // Create the chart
    const ctx = document.getElementById('pm25Chart').getContext('2d');
    const pm25Chart = new Chart(ctx, {
        type: 'line', // Line chart
        data: {
            labels: labels, // X-axis labels
            datasets: [{
                label: 'PM2.5 (ug/m3)',  // Label for the dataset
                data: pm25Data,  // Y-axis data
                borderColor: 'rgb(75, 192, 192)',  // Line color
                fill: false,  // Don't fill the area under the line
                tension: 0.1  // Smoothness of the line
            }]
        },
        options: {
            responsive: true,
            scales: {
                x: {
                    title: {
                        display: true,
                        text: 'Date'  // X-axis title
                    }
                },
                y: {
                    title: {
                        display: true,
                        text: 'PM2.5 (ug/m3)'  // Y-axis title
                    },
                    beginAtZero: true
                }
            }
        }
    });
</script>

@endsection
