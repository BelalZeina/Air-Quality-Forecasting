<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\City;
use App\Models\Crop;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;


class HomeController extends Controller
{

    public function dashboard(Request $request)
    {
        // Fetch filters
        $stateId = $request->get('state_id');
        $city = $request->get('city');

        $start_date = $request->input('start_date', '2023-01-01');  // Default start date if not provided
        $end_date = $request->input('end_date', '2023-1-31');    // Default end date if not provided
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

        return view('dashboard.dashboard2', [
            'cityStatistics' => $filteredData,
            'city' => $city,
            'state_id' => $stateId,
            'start_date' => $start_date,
            'end_date' => $end_date,
            'group_by' => $groupBy,
            'filteredData' => $filteredData,
        ]);
    }


    // public function dashboard(Request $request)
    // {
    //     // Get the date range from the request or use default values
    //     $start_date = $request->input('start_date', '2023-01-01');  // Default start date if not provided
    //     $end_date = $request->input('end_date', '2023-12-31');    // Default end date if not provided

    //     // Ensure that the date range is in the correct format
    //     $start_date = Carbon::parse($start_date);
    //     $end_date = Carbon::parse($end_date);

    //     $csvPath = public_path('data/PM2.5.csv');
    //     $data = [];

    //     if ($csvPath) {
    //         $file = $csvPath;

    //         // Open the file for reading
    //         if (($handle = fopen($file, 'r')) !== FALSE) {

    //             // Read each row from the CSV file
    //             while (($row = fgetcsv($handle)) !== FALSE) {
    //                 // Assuming the first column is Date and the second is PM2.5 value
    //                 try {
    //                     $row_date = Carbon::parse($row[0]);  // Convert to Carbon instance
    //                 } catch (\Exception $e) {
    //                     // Handle invalid date format for end_date
    //                     $row_date = Carbon::parse('2023-12-31');  // Default fallback date
    //                 }
    //                 // $row_date = Carbon::parse($row[0]);  // Convert the date to a Carbon instance
    //                 // Only include data within the date range
    //                 if ($row_date->between($start_date, $end_date)) {
    //                     $data[] = [
    //                         'date' => $row[0],
    //                         'pm25' => $row[1],
    //                     ];
    //                 }
    //             }

    //             fclose($handle);
    //         }
    //     }

    //     // Convert to a collection
    //     $data = collect($data);

    //     // Prepare the data to pass to the view
    //     $dates = $data->pluck('date')->toArray();
    //     $pm25 = $data->pluck('pm25')->toArray();

    //     return view('dashboard.index', compact('dates', 'pm25', 'start_date', 'end_date'));
    // }



    // public function assam(Request $request)
    // {
    //     // Get the date range from the request or use default values
    //     $start_date = $request->input('start_date', '2023-01-01');  // Default start date if not provided
    //     $end_date = $request->input('end_date', '2023-12-31');    // Default end date if not provided

    //     // Ensure that the date range is in the correct format
    //     $start_date = Carbon::parse($start_date);
    //     $end_date = Carbon::parse($end_date);


    //     ////////////////////////////////////////////////////////////////////////////////////////////////

    //     $csvPath = public_path('data/Assam_data.csv'); // Replace with the correct CSV path
    //     $data = [];
    //     $cities = [];

    //     if (($handle = fopen($csvPath, 'r')) !== FALSE) {
    //         $header = fgetcsv($handle); // Read header row

    //         while (($row = fgetcsv($handle)) !== FALSE) {
    //             try {
    //                 $row_date = Carbon::parse($row[0]);  // Convert to Carbon instance
    //             } catch (\Exception $e) {
    //                 // Handle invalid date format for end_date
    //                 $row_date = Carbon::parse('2023-12-31');  // Default fallback date
    //             }

    //             if ($row_date->between($start_date, $end_date)) {
    //                 $data[] = [
    //                     'from_date' => $row[0], // Index for 'From Date'
    //                     'to_date' => $row[1],   // Index for 'To Date'
    //                     'pm25' => $row[2],      // Index for 'PM2.5'
    //                     'pm10' => $row[3],      // Index for 'PM10'
    //                     'NO' => $row[4],      // Index for 'no'
    //                     'NO2' => $row[5],      // Index for 'no2'
    //                     'city' => $city
    //                 ];
    //             }
    //             $city = $row[23]; // Assuming the city column index is 24
    //             $cities[] = $city;
    //         }
    //         fclose($handle);
    //     }

    //     $cities = array_unique($cities); // Get unique cities for the dropdown

    //     // Filter data by city if selected
    //     $selectedCity = $request->input('city');
    //     $filteredData = array_filter($data, function ($entry) use ($selectedCity) {
    //         return $selectedCity ? $entry['city'] === $selectedCity : true;
    //     });
    //     // Pass the data to the view
    //     return view('dashboard.assam', compact('start_date', 'end_date', "filteredData", "cities"));
    // }

    public function arunachal_pradesh(Request $request)
    {
        // Get the date range from the request or use default values
        $start_date = $request->input('start_date', '2023-01-01');  // Default start date if not provided
        $end_date = $request->input('end_date', '2023-12-31');    // Default end date if not provided

        // Ensure that the date range is in the correct format
        $start_date = Carbon::parse($start_date);
        $end_date = Carbon::parse($end_date);


        ////////////////////////////////////////////////////////////////////////////////////////////////

        $csvPath = public_path('data/Arunachal_Pradesh_data.csv'); // Replace with the correct CSV path
        $data = [];
        $cities = [];

        if (($handle = fopen($csvPath, 'r')) !== FALSE) {
            $header = fgetcsv($handle); // Read header row

            while (($row = fgetcsv($handle)) !== FALSE) {
                try {
                    $row_date = Carbon::parse($row[0]);  // Convert to Carbon instance
                } catch (\Exception $e) {
                    // Handle invalid date format for end_date
                    $row_date = Carbon::parse('2023-12-31');  // Default fallback date
                }

                if ($row_date->between($start_date, $end_date)) {
                    $data[] = [
                        'from_date' => $row[0], // Index for 'From Date'
                        'to_date' => $row[1],   // Index for 'To Date'
                        'pm25' => $row[2],      // Index for 'PM2.5'
                        'pm10' => $row[3],      // Index for 'PM10'
                        'NO' => $row[4],      // Index for 'no'
                        'NO2' => $row[5],      // Index for 'no2'
                        'city' => $city
                    ];
                }
                $city = $row[25]; // Assuming the city column index is 24
                $cities[] = $city;
            }
            fclose($handle);
        }

        $cities = array_unique($cities); // Get unique cities for the dropdown

        // Filter data by city if selected
        $selectedCity = $request->input('city');
        $filteredData = array_filter($data, function ($entry) use ($selectedCity) {
            return $selectedCity ? $entry['city'] === $selectedCity : true;
        });
        // Pass the data to the view
        return view('dashboard.arunachal_pradesh', compact('start_date', 'end_date', "filteredData", "cities"));
    }

}
