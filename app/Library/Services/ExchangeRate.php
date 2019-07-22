<?php
namespace App\Library\Services;

use GuzzleHttp\Client;
  
class ExchangeRate
{
    public function getCurrentUsdСourse()
    {
    	$client = new Client();
        
        $response = $client->request('GET', "https://api.privatbank.ua/p24api/pubinfo?json&exchange&coursid=5");
        $body = $response->getBody(); //get object
        $content = $body->getContents(); //string in json
        $rates = json_decode($content); 
        $usdNow = $rates[0]->buy;
        $usd = number_format($usdNow, 2, '.', '');

        return $usd;
    }
}