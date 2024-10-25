<?php

namespace App\Accessors;

class GetProductsFromApi
{
    public static function getProducts()
    {
        $curl = curl_init();
        $url = 'https://670fb936a85f4164ef2ba7ad.mockapi.io/api/v5';
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url ,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                "accept: application/json",
                "content-type: application/json"
            ),
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        if($err) {
            return false;
        }
        return $response;
    }
}
