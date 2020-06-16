<?php

namespace App\Http\Controllers;

use App\Models\Medicine;
use App\Models\Transaction;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax())
        {
            $transactions = Transaction::query();
            return DataTables::eloquent($transactions)
                ->addColumn('total_price', function (Transaction $transaction) {
                    return "Rp ".$transaction->total_price;
                })
                ->addColumn('created_at', function (Transaction $transaction) {
                    return $transaction->created_at->format("Y-m-d h:m");
                })
                ->addColumn('action', function (Transaction $transaction) {
                    return '
                        <div class="text-center">
                            <a href="'. route('transaction.show', [$transaction->id]) .'" class="btn btn-sm btn-primary">
                                <i class="mdi mdi-file-search"></i>
                            </a>
                            <form style="display: inline;" method="POST" action="'. route('transaction.destroy', [$transaction->id]) .'">
                                '. method_field('DELETE') .'
                                '. (csrf_field()) .'
                                <button class="btn btn-sm btn-danger">
                                    <i class="mdi mdi-delete"></i>
                                </button>
                            </form>
                        </div>
                    ';
                })
                ->make();
        }
        return view('pages.transaction.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if ($request->ajax())
        {
            $medicines = Medicine::query();
            return DataTables::eloquent($medicines)->make();
        }
        return view('pages.transaction.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            "patient" => "required|string",
            "cart" => "required|json"
        ]);
        $carts = json_decode($request->cart);
        $carts_collection = new Collection($carts);

        // 
        $medicine_cart = Medicine::whereIn("id", $carts_collection->pluck('id'))->get();
        $cart_transaction = [];
        foreach($medicine_cart as $medicine) {
            $cart = array_search($medicine->id, array_column($carts, 'id') );
            if ($cart !== false) {
                $cart_transaction[$medicine->id] = [
                    'medicine_id' => $medicine->id,
                    'stock' => $carts[$cart]->stock,
                    'price' => $medicine->price
                ];
            }
        }

        $total_price = 0;
        foreach ($cart_transaction as $item) { $total_price += ($item['price']*$item['stock']); }
        
        DB::transaction(function () use ($total_price, $cart_transaction, $request) {
            $transaction = Transaction::create([
                "patient" => $request->patient,
                "total_price" => $total_price
            ]);
            $transaction->medicines()->sync($cart_transaction);
            foreach($cart_transaction as $cart) {
                Medicine::findOrFail($cart['medicine_id'])->decrement('stock', $cart['stock']);
            }
        });

        return redirect()->route("transaction.index");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Transaction $transaction)
    {
        return view("pages.transaction.show", compact('transaction'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Transaction $transaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Transaction $transaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Transaction $transaction)
    {
        $delete = $transaction->delete();
        return redirect()->route("transaction.index");
    }
}
