<?php

namespace App\Http\Controllers;

use App\Models\Income;
use Illuminate\Http\Request;
use Carbon\Carbon;

class IncomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth('api')->user();
        $income = Income::where('user_id', $user->id)
                        ->where('date', '>=', Carbon::now()->startOfMonth())
                        ->orderBy('date')
                        ->get();

        return response()->json($income);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = auth('api')->user();

        $income = new Income;

        $income->user_id = $user->id;
        $income->created_by = $user->id;
        $income->rate = $request->rate;
        $income->currency = $request->currency;
        $income->amount_usd = $request->amount;
        $income->amount = $request->amount;
        $income->comment = $request->comment;
        $income->date = $this->isThisMonth($request->date);
        $income->save();

        return response()->json(['status' => 'success'], 200);  
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Income  $income
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Income $income)
    {
        $income->rate = $request->rate;
        $income->currency = $request->currency;
        $income->amount_usd = $request->amount;
        $income->amount = $request->amount;
        $income->comment = $request->comment;
        $income->date = $this->isThisMonth($request->date);
        $income->update();

        return response()->json(['status' => 'success'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Income  $income
     * @return \Illuminate\Http\Response
     */
    public function destroy(Income $income)
    {
        $income->delete();

        return response()->json(['status' => 'success'], 200);
    }

    public function getIncomeAmount() 
    {
        $user = auth('api')->user();
        $amount = Income::where('user_id', $user->id)
                        ->where('created_at', '>=', Carbon::now()->startOfMonth())
                        ->sum('amount');

        return response()->json($amount);
    }

    protected function isThisMonth($date)
    {
        return ($date >= Carbon::now()->startOfMonth()) ? $date :  Carbon::now()->startOfMonth();
    }
    
}
