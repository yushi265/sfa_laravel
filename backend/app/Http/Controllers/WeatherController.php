<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class WeatherController extends Controller
{
    public function index()
    {
        $max_hour = 5;
        $max_day = 7;
        $api_key = '842ed581296f71edd791febe2793a59f';
        // 千葉県の緯度経度
        $lat = '35.6051';
        $lon = '140.1233';

        $url = "https://api.openweathermap.org/data/2.5/onecall?lat=" . $lat . "&lon=" . $lon . "&units=metric&lang=ja&appid=" . $api_key;
        $method = "GET";

        //接続
        $client = new Client();

        $response = $client->request($method, $url);

        $weathers = $response->getBody();
        $weathers = json_decode($weathers, true);

        $timezone_offset = $weathers['timezone_offset'];

        $hourly_weathers = [];
        for ($i=0; $i < $max_hour ; $i++) {
            $hourly_weathers[] = $weathers["hourly"][$i];
        }

        $daily_weathers = $weathers["daily"];

        // ddd($hourly_weathers, $daily_weathers);
        // ddd($weathers);
        // ddd($daily_weathers);

        return view('weathers.index')->with([
            'hourly_weathers' => $hourly_weathers,
            'daily_weathers' => $daily_weathers,
            ]);
    }
}
