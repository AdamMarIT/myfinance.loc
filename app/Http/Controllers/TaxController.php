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

        switch ($request->periodicity) {
            case 'month':
                $tax->active = 1; break;
            case 'quarter':
                $tax->active = 4; break;
            case 'year':
                $tax->active = 12; break;
            default:
                $tax->active = 0;
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

        switch ($request->periodicity) {
            case 'month':
                $tax->active = 1; break;
            case 'quarter':
                $tax->active = 4; break;
            case 'year':
                $tax->active = 12; break;
            default:
                $tax->active = 0;
        }

        // if (in_array($request->periodicity, ['month', 'quarter', 'year'])) {
        //     $tax->active = 1;
        // }
        
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
        $taxes = $this->getTaxListForSidebar();
        $amounts = array_column($taxes, 'amount');
        $amount = array_sum($amounts);

        return response()->json($amount);
    }
    

    public function getTaxForSidebar()
    {
        $taxes = $this->getTaxListForSidebar();

        return response()->json($taxes);
    }

    public function getTax() 
    {
        $month = Carbon::now()->month;

        if (in_array($month, [3, 6, 9])) {
            $active = [1, 4];
        } elseif ($month == 12) {
            $active = [1, 4, 12];
        } else {
            $active = [1];
        }

        $user = auth('api')->user();
        $taxes = Tax::where('user_id', $user->id)
                    ->where(function ($q) use ($active) {
                    $q->whereIn('active', $active)->orWhere('created_at',  Carbon::now()->startOfMonth());})
                    
                    ->orderBy('created_at')
                    ->get();
                   
        return $taxes;

    }

    public function getTaxListForSidebar() 
    {
        $user = auth('api')->user();
        $amountIncome = Income::where('user_id', $user->id)->sum('amount');

        $taxes = $this->getTax()->map(function ($tax) use ($amountIncome) {
            
            if ($tax['type'] == 'fixed') {
                $amount = $tax['amount'];     
            }else {   
                $amount = $amountIncome * $tax['amount'] / 100;
            }

            return [
                'name' => $tax['name'], 
                'amount' => $amount
            ];
        });

        return $taxes->toArray();
    }
}
