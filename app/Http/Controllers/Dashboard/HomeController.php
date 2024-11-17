<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Crop;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;


class HomeController extends Controller
{

    public function dashboard(Request $request)
    {
        // Get the date range from the request or use default values
        $start_date = $request->input('start_date', '2023-01-01');  // Default start date if not provided
        $end_date = $request->input('end_date', '2023-12-31');    // Default end date if not provided

        // Ensure that the date range is in the correct format
        $start_date = Carbon::parse($start_date);
        $end_date = Carbon::parse($end_date);

        $csvPath = public_path('data/PM2.5.csv');
        $data = [];

        if ($csvPath) {
            $file = $csvPath;

            // Open the file for reading
            if (($handle = fopen($file, 'r')) !== FALSE) {

                // Read each row from the CSV file
                while (($row = fgetcsv($handle)) !== FALSE) {
                    // Assuming the first column is Date and the second is PM2.5 value
                    try {
                        $row_date = Carbon::parse($row[0]);  // Convert to Carbon instance
                    } catch (\Exception $e) {
                        // Handle invalid date format for end_date
                        $row_date = Carbon::parse('2023-12-31');  // Default fallback date
                    }
                    // $row_date = Carbon::parse($row[0]);  // Convert the date to a Carbon instance
                    // Only include data within the date range
                    if ($row_date->between($start_date, $end_date)) {
                        $data[] = [
                            'date' => $row[0],
                            'pm25' => $row[1],
                        ];
                    }
                }

                fclose($handle);
            }
        }

        // Convert to a collection
        $data = collect($data);

        // Prepare the data to pass to the view
        $dates = $data->pluck('date')->toArray();
        $pm25 = $data->pluck('pm25')->toArray();

        return view('dashboard.index', compact('dates', 'pm25', 'start_date', 'end_date'));
    }



    public function assam(Request $request)
    {
        // Get the date range from the request or use default values
        $start_date = $request->input('start_date', '2023-01-01');  // Default start date if not provided
        $end_date = $request->input('end_date', '2023-12-31');    // Default end date if not provided

        // Ensure that the date range is in the correct format
        $start_date = Carbon::parse($start_date);
        $end_date = Carbon::parse($end_date);


////////////////////////////////////////////////////////////////////////////////////////////////

        $csvPath = public_path('data/Assam_data.csv'); // Replace with the correct CSV path
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
                $city = $row[23]; // Assuming the city column index is 24
                $cities[] = $city;
            }
            fclose($handle);
        }

            $cities = array_unique($cities); // Get unique cities for the dropdown

            // Filter data by city if selected
            $selectedCity = $request->input('city');
            $filteredData = array_filter($data, function($entry) use ($selectedCity) {
                return $selectedCity ? $entry['city'] === $selectedCity : true;
            });
            // Pass the data to the view
        return view('dashboard.assam', compact('start_date', 'end_date',"filteredData","cities"));
    }

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
            $filteredData = array_filter($data, function($entry) use ($selectedCity) {
                return $selectedCity ? $entry['city'] === $selectedCity : true;
            });
            // Pass the data to the view
        return view('dashboard.arunachal_pradesh', compact('start_date', 'end_date',"filteredData","cities"));
    }

}
