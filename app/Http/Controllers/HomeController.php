<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $statisticMedicinePurchased = $this->statisticMedicinePurchased();
        return view('pages.index', compact('statisticMedicinePurchased'));
    }

    private function statisticMedicinePurchased() 
    {
        $transactions = Transaction::all();
        $byDate = [];
        foreach($transactions as $item)
        {
            if (!isset($byDate[$item->created_at->format("d-m-Y")])) $byDate[$item->created_at->format("d-m-Y")] = [];
            $byDate[$item->created_at->format("d-m-Y")][] = $item;
        }
        
        // count purchase & unit
        $result = [];
        foreach($byDate as $key => $item) {
            if (!isset($result[$key])) $result[$key] = (object) ["stock" => 0, "patient" => 0, "medicine" => 0, "income" => 0];
            foreach($item as $transaction) {
                foreach($transaction->medicines as $medicine) {
                    $result[$key]->stock += $medicine->pivot->stock;
                }
                $result[$key]->medicine = count($transaction->medicines);
                $result[$key]->patient++;
                $result[$key]->income += $transaction->total_price;
            }
        }
        
        // formatting
        $output = [];
        foreach($result as $key => $item) { 
            $output[] = (object) [
                "y"      => $key, 
                "stock"     => $item->stock, 
                "patient"   => $item->patient,
                "medicine"  => $item->medicine,
                "income"    => $item->income,
            ];
        }
        // dd($output);
        return $output;
    }
}
