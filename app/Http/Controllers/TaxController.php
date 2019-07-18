<?php

namespace App\Http\Controllers;

use App\Models\Tax;
use Illuminate\Http\Request;  
use Carbon\Carbon; 
use App\Models\Income;

class TaxController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth('api')->user();
        $tax = Tax::where('user_id', $user->id)->get();

        return response()->json($tax);
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
        if ($request->isMethod('post')) {
            $user = auth('api')->user();

            $tax = new Tax;
            $tax->user_id = $user->id;
            $tax->created_by = $user->id;
            $tax->name = $request->name;
            $tax->amount = $request->amount;
            $tax->type = $request->type;
            $tax->periodicity = $request->periodicity;

            if ($request->periodicity == 'month' || $request->periodicity == 'quarter'  || $request->periodicity == 'year' ) {
                $tax->active = 1;
            }
            $tax->save();

            return response()->json(['status' => 'success'], 200);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Tax  $tax
     * @return \Illuminate\Http\Response
     */
    public function show(Tax $tax)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Tax  $tax
     * @return \Illuminate\Http\Response
     */
    public function edit(Tax $tax)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Tax  $tax
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tax $tax)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Tax  $tax
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tax $tax)
    {
        $tax->delete();

        return response()->json(['status' => 'success'], 200);
    }

    public function getAmountOfTax() 
    {
        $user = auth('api')->user();

        $taxes = Tax::where('user_id', $user->id)
                    ->where('active', '1')
                    ->orwhere('created_at', '>=', Carbon::now()->startOfMonth())
                    ->get()
                    ->toArray();

        $amount = 0;

        foreach ($taxes as $tax) {

            if ($tax['type'] == 'fixed') {
                $amount += $tax['amount'];     
            }else {
                $amountIncome = Income::where('user_id', $user->id)->sum('amount');
                $amount += $amountIncome * $tax['amount'] / 100;
            }
        }

        return response()->json($amount);
    }
    

    public function getTaxForSidebar()
    {
        $user = auth('api')->user();
        
        $taxes = Tax::where('user_id', $user->id)
                    ->where('active', '1')
                    ->orwhere('created_at', '>=', Carbon::now()->startOfMonth())
                    ->orderBy('created_at')
                    ->get()
                    ->toArray();

        $taxesArr = [];

        foreach ($taxes as $tax) {

            if ($tax['type'] == 'fixed') {
                $amount = $tax['amount'];     
            }else {
                $amountIncome = Income::where('user_id', $user->id)->sum('amount');
                $amount = $amountIncome * $tax['amount'] / 100;
            }

            $taxesArr[] = ['name' => $tax['name'], 'amount' => $amount];
        }

        return response()->json($taxesArr);
    }


}
