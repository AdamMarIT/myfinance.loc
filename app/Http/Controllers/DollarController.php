<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp;

class DollarController extends Controller
{
    public function currentСourse()
    {

    	$client = new GuzzleHttp\Client();
        $response = $client->request('GET', "https://api.privatbank.ua/p24api/pubinfo?json&exchange&coursid=5");
        $body = $response->getBody(); //получаем объект
        $content = $body->getContents(); //получаем строку в json
        $rates=json_decode($content); 
        $usd_now = $rates[0]->sale;
        $usd = number_format($usd_now, 2, '.', '');

        return $usd;
    }
}
