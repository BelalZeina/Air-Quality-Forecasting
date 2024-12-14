<?php

namespace App\Livewire;

use App\Models\City;
use Http;
use Livewire\Component;
use Validator;

class Forcast extends Component
{
    public $feature = 'pm25';  // Default feature
    public $dates = [];
    public $actual = [];
    public $predictions = [];

    // This method is called to generate the forecast when the feature is selected
    public function mount()
    {
        $validated = Validator::make(['feature' => $this->feature], [
            'feature' => 'nullable|string',
        ])->validated();

        $city = City::where([
            'name' => 'Naharlagun',
            'state_id' => '2'
        ])
        ->where($validated['feature'], '!=', null)
        ->latest('from_date')
        ->take(30)
        ->pluck($validated['feature'], 'from_date')
        ->toArray();

        // Transform data to ascending order of 'from_date'
        $data = collect($city)
            ->sortKeys()
            ->values()
            ->toArray();

        // Send data to prediction API
        $response = Http::post('http://127.0.0.1:5000/predict', [
            'feature' => $validated['feature'] ?? 'pm25',
            'data' => $data,
        ]);

        $nulls = array_fill(0, 30, null);
        $dates = collect($city)
            ->sortKeys()
            ->keys()
            ->toArray();

        $lastDate = end($dates);
        if ($lastDate) {
            $lastTimestamp = strtotime($lastDate);
            for ($i = 1; $i <= 24; $i++) {
                $nextTimestamp = $lastTimestamp + ($i * 3600);
                $dates[] = date('Y-m-d H:i:s', $nextTimestamp);
            }
        }

        $predictions = $response->object()->predictions ?? [];
        $this->dates = $dates;
        $this->actual = $data;
        $this->predictions = array_merge($nulls, $predictions);
        $this->dispatch('forecastUpdated');
    }
    public function getForecast()
    {
        $validated = Validator::make(['feature' => $this->feature], [
            'feature' => 'nullable|string',
        ])->validated();

        $city = City::where([
            'name' => 'Naharlagun',
            'state_id' => '2'
        ])
        ->where($validated['feature'], '!=', null)
        ->latest('from_date')
        ->take(30)
        ->pluck($validated['feature'], 'from_date')
        ->toArray();

        // Transform data to ascending order of 'from_date'
        $data = collect($city)
            ->sortKeys()
            ->values()
            ->toArray();

        // Send data to prediction API
        $response = Http::post('http://127.0.0.1:5000/predict', [
            'feature' => $validated['feature'] ?? 'pm25',
            'data' => $data,
        ]);

        $nulls = array_fill(0, 30, null);
        $dates = collect($city)
            ->sortKeys()
            ->keys()
            ->toArray();

        $lastDate = end($dates);
        if ($lastDate) {
            $lastTimestamp = strtotime($lastDate);
            for ($i = 1; $i <= 24; $i++) {
                $nextTimestamp = $lastTimestamp + ($i * 3600);
                $dates[] = date('Y-m-d H:i:s', $nextTimestamp);
            }
        }

        $predictions = $response->object()->predictions ?? [];
        $this->dates = $dates;
        $this->actual = $data;
        $this->predictions = array_merge($nulls, $predictions);
        $this->dispatch('forecastUpdated');
    }
    public function render()
    {
        return view('livewire.forcast');
    }
}
