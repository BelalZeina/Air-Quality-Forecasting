<div class="container">
    <h1 class="my-4 text-center">Feature Forecast Dashboard</h1>
    <div class="card mt-2 p-2" style="border-radius: 10px;">
        <div class="row">
            <div class="col-lg-3 col-md-12">
                <!-- Input Form -->
                <form wire:submit.prevent="getForecast">
                    <div class="mb-3">
                        <label for="feature" class="form-label">Feature</label>
                        <select id="feature" wire:model="feature" class="form-select" required>
                            <option value="pm25">PM2.5</option>
                            <option value="pm10">PM10</option>
                            <option value="no2">NO2</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Get Forecast</button>
                </form>
            </div>
            <div class="col-lg-9 col-md-12">
                <!-- Chart -->
                <div class="card-body"
                    style="background: #ffffff; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
                    <h5 class="card-title text-primary" style="font-weight: bold;">Air Quality Forecasting Data</h5>
                    <div id="forecastChart"></div>
                </div>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
        <script>
            document.addEventListener("livewire:load", function () {
                const ctx = document.getElementById('forecastChart').getContext('2d');

                const dates = @json($this->dates);
                const actualData = @json($this->actual);
                const predictedData = @json($this->predictions);

                console.log("Dates:", dates, "Actual Data:", actualData, "Predictions:", predictedData);

                const airQualityChart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: dates,
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
    </div>
</div>
