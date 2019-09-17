<?php
if (!function_exists('admin_auth')) {
    function admin_auth()
    {
        return Auth::guard('admin')->user();
    }
}

if (!function_exists('route_uri')) {
    function route_uri($name)
    {
        return config('app.url').'/'.Route::getRoutes()->getByName($name)->uri();
    }
}

if (!function_exists('decode_json_data')) {
    function decode_json_data($data)
    {
        $temp = array();
        if (empty($data)) return $temp;
        $data = json_decode($data, true);
        if (empty($data)) return $temp;
        foreach ($data as $key => $value) {
            $temp[$key] = object_to_array($value);
        }
        return $temp;
    }
}

if (!function_exists('object_to_array')) {
    function object_to_array($data)
    {
        if (is_object($data)) $data = (array)$data;
        if (is_array($data)) {
            foreach ($data as $key => $value) {
                $data[$key] = object_to_array($value);
            }
        }
        return $data;
    }
}