<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Library\Services\ExchangeRate;


class ExchangeController extends Controller
{
    public function getCurrentСourse(ExchangeRate $ExchangeRate)
    {
    	$usd = $ExchangeRate->getCurrentUsdСourse();

        return $usd;
    }
}
