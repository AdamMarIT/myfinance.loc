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
        $taxes = $this->getTax();

        return response()->json($taxes);
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

        $tax = new Tax;

        $tax->user_id = $user->id;
        $tax->created_by = $user->id;
        $tax->name = $request->name;
        $tax->amount = $request->amount;
        $tax->type = $request->type;
        $tax->periodicity = $request->periodicity;

        if (in_array($request->periodicity, ['month', 'quarter', 'year'])) {
            $tax->active = 1;
        }

        $tax->save();

        return response()->json(['status' => 'success'], 200);
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
        $tax->name = $request->name;
        $tax->amount = $request->amount;
        $tax->type = $request->type;
        $tax->periodicity = $request->periodicity;

        if (in_array($request->periodicity, ['month', 'quarter', 'year'])) {
            $tax->active = 1;
        }
        
        $tax->update();

        return response()->json(['status' => 'success'], 200);
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

    public function getTaxAmount() 
    {
        $taxesArr = $this->getTaxListForSidebar();
        $amountArr = array_column($taxesArr, 'amount');
        $amount = array_sum($amountArr);

        return response()->json($amount);
    }
    

    public function getTaxForSidebar()
    {
        $taxesArr = $this->getTaxListForSidebar();

        return response()->json($taxesArr);
    }

    public function getTax() 
    {
        $user = auth('api')->user();
        $taxes = Tax::where('user_id', $user->id)
                    ->where('active', '1')
                    ->orwhere('created_at', '>=', Carbon::now()->startOfMonth())
                    ->orderBy('created_at')
                    ->get();

        return $taxes;
    }

    public function getTaxListForSidebar() 
    {
        $taxes = $this->getTax()->toArray();
        $taxesArr = [];

        foreach ($taxes as $tax) {

            if ($tax['type'] == 'fixed') {
                $amount = $tax['amount'];     
            }else {
                $user = auth('api')->user();
                $amountIncome = Income::where('user_id', $user->id)->sum('amount');
                $amount = $amountIncome * $tax['amount'] / 100;
            }

            $taxesArr[] = ['name' => $tax['name'], 'amount' => $amount];
        }

        return $taxesArr;
    }
}
