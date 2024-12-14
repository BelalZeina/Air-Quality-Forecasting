<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Symfony\Component\Process\Process;


class HomeController extends Controller
{


    public function predict(Request $request)
    {
        $inputData = $request->input('data'); // Example: [1.0, 2.0, 3.0]
        $dataString = implode(' ', $inputData);

        $process = new Process(['python3', public_path('data/predict.py'), $dataString]);
        $process->run();

        if (!$process->isSuccessful()) {
            return response()->json(['error' => $process->getErrorOutput()], 500);
        }

        $output = json_decode($process->getOutput(), true);
        return response()->json(['predictions' => $output]);
    }


}
