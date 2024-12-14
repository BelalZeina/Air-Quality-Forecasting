<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\City;
use App\Models\Crop;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Validator;


class HomeController extends Controller
{

    public function dashboard(Request $request)
    {
        // Fetch filters
        $stateId = $request->get('state_id');
        $city = $request->get('city');

        $start_date = $request->input('start_date', '2023-01-01');  // Default start date if not provided
        $end_date = $request->input('end_date', '2023-1-10');    // Default end date if not provided
        $start_date = Carbon::parse($start_date);
        $end_date = Carbon::parse($end_date);
        // Initialize the query
        $query = City::query();

        // Apply filters
        if ($stateId) {
            $query->where('state_id', $stateId);
        }
        if ($city) {
            $query->where('name', $city);
        }

        // Fetch the grouped data with averages
        $cityStatistics = $query->groupBy('state_id')
            ->selectRaw('
                state_id,
                AVG(pm25) as avg_pm25,
                AVG(pm10) as avg_pm10,
                AVG(No) as avg_no,
                AVG(No2) as avg_no2,
                AVG(NOx) as avg_nox,
                AVG(NH3) as avg_nh3,
                AVG(SO2) as avg_so2,
                AVG(CO) as avg_co,
                AVG(AT) as avg_at,
                AVG(Temp) as avg_temp,
                AVG(CO2) as avg_co2,
                AVG(CH4) as avg_ch4
            ')
            ->with('state')
            ->get();
        $data = City::whereBetween("from_date", [$start_date, $end_date]);
        if($city){
            $data=$data->where("name", $city);
        }
        $data=$data->get();
        return view('dashboard.index', [
            'cityStatistics' => $cityStatistics,
            'city' => $city,
            'state_id' => $stateId,
            'start_date' => $start_date,
            'end_date' => $end_date,
            'data' => $data,
        ]);

    }

    public function forcasting(Request $request)
    {
        $validator =Validator::make( $request->all(),[
            'feature' => 'nullable|string',
        ]);
        if($validator->fails()) {
            return response()->json(["error" =>$validator->errors(),"status"=>422 ],422);
        }
        $validated=$request->all();
        $validated['feature']=$validated['feature']??"pm25";
        // Call the Python API
        $city = City::where([
            "name" => "Naharlagun",
            "state_id" => "2"
        ])
        ->where($validated['feature'], '!=', null)
        ->latest("from_date") // Sort by 'from_date' in descending order
        ->take(30) // Get the last 30 records
        ->pluck($validated['feature'], 'from_date') // Fetch the feature values along with the 'from_date'
        ->toArray();

        // Transform data to ascending order of 'from_date'
        $data = collect($city)
            ->sortKeys() // Sort by keys (which are 'from_date' in this case)
            ->values() // Get only the feature values
            ->toArray();
            // return $data;
        $response = \Http::post('http://127.0.0.1:5000/predict', [
            'feature' => $validated['feature']??"pm25",
            'data' =>$data, // Provide time-series input data
        ]);
        $nulls=[];
        for ($i=0; $i <30 ; $i++) {
            $nulls[]=null;
        }
        $dates =collect($city)
        ->sortKeys() // Sort by keys (which are 'from_date' in this case)
        ->keys() // Get only the feature values
        ->toArray(); // Existing dates
        $lastDate = end($dates); // Get the last date from the keys
        if ($lastDate) {
            $lastTimestamp = strtotime($lastDate);
            for ($i = 1; $i <= 24; $i++) {
                $nextTimestamp = $lastTimestamp + ($i * 3600); // Add 1 hour per iteration
                $dates[] = date('Y-m-d H:i:s', $nextTimestamp); // Append new date in Y-m-d H:i:s format
            }
        }
        $predictions=$response->object()->predictions ?? [];
        $result = array_merge($nulls, $predictions);
        return view('dashboard.forcasting',[
            "dates" => $dates,
            "actual" => $data,
            "predictions" => $result ?? []
        ]);
    }

    public function dashboard2(Request $request)
    {
        // Fetch filters
        $stateId = $request->get('state_id');
        $city = $request->get('city');
        $groupBy = $request->input('group_by', 'years'); // Default to group by years
        $start_date = $request->input('start_date', '2016-01-01'); // Default start date if not provided
        $end_date = $request->input('end_date', '2023-12-31');     // Default end date if not provided

        $start_date = Carbon::parse($start_date);
        $end_date = Carbon::parse($end_date);

        // Initialize the query
        $query = City::query();

        // Apply filters
        if ($stateId) {
            $query->where('state_id', $stateId);
        }
        if ($city) {
            $query->where('name', $city);
        }

        // Determine the format for grouping
        $dateFormat = match ($groupBy) {
            'months' => '%Y-%m', // Group by months
            'years' => '%Y',     // Group by years
            default => '%Y-%m-%d' // Group by days
        };

        // Fetch the grouped data
        $filteredData = $query
            ->whereBetween('from_date', [$start_date, $end_date])
            ->selectRaw("
            DATE_FORMAT(from_date, '{$dateFormat}') as group_date,
                AVG(pm25) as avg_pm25,
                AVG(pm10) as avg_pm10,
                AVG(No) as avg_no,
                AVG(No2) as avg_no2,
                AVG(NOx) as avg_nox,
                AVG(NH3) as avg_nh3,
                AVG(SO2) as avg_so2,
                AVG(CO) as avg_co,
                AVG(AT) as avg_at,
                AVG(Temp) as avg_temp,
                AVG(CO2) as avg_co2,
                AVG(CH4) as avg_ch4
        ")
            ->groupBy('group_date')
            ->orderBy('group_date')
            ->get();
            // Compute correlation matrix
            $correlationData = $filteredData->map(fn ($item) => [
                'pm25' => $item->avg_pm25,
                'pm10' => $item->avg_pm10,
                'no' => $item->avg_no,
                'no2' => $item->avg_no2,
                'nox' => $item->avg_nox,
                'nh3' => $item->avg_nh3,
                'so2' => $item->avg_so2,
                'co' => $item->avg_co,
                'at' => $item->avg_at,
                'temp' => $item->avg_temp,
                'co2' => $item->avg_co2,
                'ch4' => $item->avg_ch4,
            ]);

            if($correlationData->count()>0){
                $correlationMatrix = $this->computeCorrelationMatrix($correlationData);
            }else{
                $correlationMatrix=[];
            }
        return view('dashboard.dashboard2', [
            'cityStatistics' => $filteredData,
            'correlationMatrix' => $correlationMatrix, // Pass correlation matrix to frontend
            'city' => $city,
            'state_id' => $stateId,
            'start_date' => $start_date,
            'end_date' => $end_date,
            'group_by' => $groupBy,
            'filteredData' => $filteredData,
        ]);
    }

    private function computeCorrelationMatrix($data)
    {
        $matrix = [];
        $columns = array_keys($data->first());

        foreach ($columns as $col1) {
            $matrix[$col1] = [];
            foreach ($columns as $col2) {
                $values1 = $data->pluck($col1)->toArray();
                $values2 = $data->pluck($col2)->toArray();
                $matrix[$col1][$col2] = $this->correlation($values1, $values2);
            }
        }

        return $matrix;
    }

    private function correlation($x, $y)
    {
        $n = count($x);
        $meanX = array_sum($x) / $n;
        $meanY = array_sum($y) / $n;

        $numerator = array_sum(array_map(fn ($xi, $yi) => ($xi - $meanX) * ($yi - $meanY), $x, $y));
        $denominator = sqrt(
            array_sum(array_map(fn ($xi) => ($xi - $meanX) ** 2, $x)) *
            array_sum(array_map(fn ($yi) => ($yi - $meanY) ** 2, $y))
        );

        return $denominator == 0 ? 0 : $numerator / $denominator;
    }



    public function predict(Request $request)
    {
        $validator =Validator::make( $request->all(),[
            // 'feature' => 'required|string',
        ]);
        if($validator->fails()) {
            return response()->json(["error" =>$validator->errors(),"status"=>422 ],422);
        }
        $validated=$request->all();
        $validated['feature']="pm25";
        // Call the Python API
        $city = City::where([
            "name" => "Naharlagun",
            "state_id" => "2"
        ])
        ->where($validated['feature'], '!=', null)
        ->latest("from_date") // Sort by 'from_date' in descending order
        ->take(30) // Get the last 30 records
        ->pluck($validated['feature'], 'from_date') // Fetch the feature values along with the 'from_date'
        ->toArray();

        // Transform data to ascending order of 'from_date'
        $data = collect($city)
            ->sortKeys() // Sort by keys (which are 'from_date' in this case)
            ->values() // Get only the feature values
            ->toArray();
            // return $data;
        $response = \Http::post('http://127.0.0.1:5000/predict', [
            'feature' => $validated['feature']??"pm25",
            'data' =>$data, // Provide time-series input data
        ]);
        if ($response->successful()) {
            return response()->json([
                "actual" => $data,
                "predictions" => $response->object()->predictions ?? []
            ], 200);
        } else {
            return response()->json([
                "actual" => $data,
                "predictions" => []
            ], 200); // Ensure the front end can still render with the actual data
        }

    }


}
