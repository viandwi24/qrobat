<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class LinkController extends Controller
{
    public function index(Transaction $transaction)
    {
        return view('pages.link', compact('transaction'));
    }
}
