<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if ( ! function_exists('setRequest')) {
    function setRequest()
    {
        $url = 'http://localhost:8080/Second-Screen-API-v3/';
        $headers = array('Content-Type' => 'application/json', 'Authorization' => 'Basic RGV2ZWxvcGVyOjEyMzQ=');
        return array($url, $headers);
    }
}

if ( ! function_exists('sendGetRequest')) {
    function sendGetRequest($apiLink)
    {
        $request_attributes = setRequest();
        $url = $request_attributes[0].$apiLink;
        $headers = $request_attributes[1];
        $response = (Requests::get($url, $headers));
        $result = json_decode($response->body);
        return $result;
    }
}

if ( ! function_exists('sendPostRequest')) {
    function sendPostRequest($apiLink, $data)
    {
        $request_attributes = setRequest();
        $url = $request_attributes[0].$apiLink;
        $headers = $request_attributes[1];

        $response = (Requests::post($url, $headers, json_encode($data)));
        $result = json_decode($response->body);
        return $result;
    }
}