<?php

namespace App\Http\Controllers;

use App\Models\Income;
use Illuminate\Http\Request;

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

        $income = Income::where('user_id', $user->id)->get();


        return response()->json($income);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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

        if ($request->currency == 'usd') {
            $income->currency = $request->currency;
            $income->amount_usd = $request->amount;
            $income->amount = $request->amount * $request->rate;
        } else {
            $income->currency = 'ua';
            $income->amount_usd = 0;
            $income->amount = $request->amount;
        }

        $income->comment = $request->comment;
        $income->date = $request->date;
        $income->save();

        return response()->json(['status' => 'success'], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Income  $income
     * @return \Illuminate\Http\Response
     */
    public function show(Income $income)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Income  $income
     * @return \Illuminate\Http\Response
     */
    public function edit(Income $income)
    {
        return response()->json($income);
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
        if ($request->currency == 'usd') {
            $income->currency = $request->currency;
            $income->amount_usd = $request->amount;
            $income->amount = $request->amount * $request->rate;
        } else {
            $income->currency = 'ua';
            $income->amount_usd = 0;
            $income->amount = $request->amount;
        }

        $income->comment = $request->comment;
        $income->date = $request->date;
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

    public function getAmountOfIncome() 
    {
        $user = auth('api')->user();

        $amount = Income::where('user_id', $user->id)->sum('amount');

        return response()->json($amount);
    }
    
}
