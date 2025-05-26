<?php

declare(strict_types=1);

namespace app\custom\helpers\http;

class HttpHelper
{
    public function sendPost($url, array $fields, array $headers = [])
    {
        $curl = curl_init();

        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($fields));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $result = curl_exec($curl);

        curl_close($curl);

        return json_decode($result, true) ? json_decode($result, true) : $result;
    }
}
