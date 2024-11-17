<?php
use App\Models\Address;
use App\Models\Club;
use App\Models\Order;
use App\Models\OrderItems;
use App\Models\PaymentLog;
use App\Models\Product;


if (!function_exists("sendResponse")) {

    function sendResponse($code = 201, $msg = null, $data = null)
    {
        $response = [
            'status' => $code,
            'msg' => $msg,
            'data' => $data,
        ];
        return response()->json($response, $code);
    }

}
if (!function_exists("notFoundResponse")) {

    function notFoundResponse($code = 404, $msg = "not found", $data = null)
    {
        $response = [
            'status' => $code,
            'msg' => $msg,
            'data' => $data,
        ];
        return response()->json($response, $code);
    }

}
if (!function_exists("UploadImage")) {

    function UploadImage($request, $folderName)
    {
        if (!empty($request)) {
            $image = uniqid() . '_' . $request->getClientOriginalName();
            $path = $request->storeAs($folderName, $image, 'public');
            return $path;
        }
    }
}

if (!function_exists("UploadMultiImage")) {

    function UploadMultiImage($request, $folderName)
    {
        $paths = [];

        // Check if any files were uploaded
        if ($request) {
            // Get the uploaded files from the request
            $Files = $request;

            // Loop through the uploaded files
            foreach ($Files as $File) {
                // Generate a unique filename for each file
                $filename = uniqid() . '_' . $File->getClientOriginalName();

                // Store the file in the specified folder
                $File->storeAs($folderName, $filename, 'public');

                // Create an array with the path and filename for each file
                $paths[] = [
                    'path' => $folderName . '/' . $filename,
                    // 'filename' => $filename,
                ];
            }
        }
        // Convert the $paths array to JSON format
        $pathFile = json_encode($paths);
        return $pathFile;
    }
}

if (!function_exists("image_url")) {
    function image_url($img, $size = '', $type = '')
    {
        if (str_contains($img, 'http') or str_contains($img, 'https')) {
            return $img;
        }
        if (empty($img) || $img == null) {
            return url('asset/img/avatars/Rectangle.png');
        } else {
            return url('storage/' . $img);
        }

        if (!empty($type)) {
            return (!empty($size)) ? url('/image/' . $size . '/' . $img) . '?type=' . $type : url('/image/' . $img) . '?type=' . $type;
        }

    }
}

if (!function_exists("isActiveRoute")) {
    function isActiveRoute($routeNames, $activeClass = 'active')
    {
        if (!is_array($routeNames)) {
            $routeNames = [$routeNames];
        }

        foreach ($routeNames as $routeName) {
            if (Route::currentRouteName() === $routeName) {
                return $activeClass;
            }
        }

        return null;
    }
}
    if (!function_exists('active')) {
        function active($routeName, $parameters = [])
        {
            return request()->routeIs($routeName) && request()->route()->parameters() == $parameters;
        }
    }


    if (!function_exists('response_web')) {
        function response_web($status, $message, $items = null, $statusCode = 200)
        {
            $response = ['status' => $status, 'message' => $message];
            if ($status && isset($items)) {
                $response['item'] = $items;
            } else {
                $response['errors_object'] = $items;
            }
            return response($response, $statusCode);
        }
    }



    if (!function_exists('sendOtp')) {
        function sendOtp($user)
        {
            // $appkey=env("TEK_APP_KEY");
            // $authkey=env("TEK_AUTH_KEY");
            //     if ($user && $user->mobile) {
            //         $message = "رقم التحقق هو   ".$user->code_verified;
            //         $response = Http::asForm()->post('https://cloud.tek-part-ns.cloud/api/create-message', [
            //             'appkey' => $appkey,
            //             'authkey' => $authkey,
            //             'to' => "2{$user->mobile}", // Assuming mobile format starts with '2'
            //             'message' =>  $message,
            //             'sandbox' => 'false',
            //         ]);
            //         // Log the response in case of failure
            //         if ($response->failed()) {
            //             \Log::error("Failed to send message for report ID: {$user->id}, response: {$response->body()}");
            //             // \Log::error("Failed to send message for report ID: {$this->id}");
            //         }
            //     }
        }
    }










