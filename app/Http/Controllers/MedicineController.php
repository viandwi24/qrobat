<?php

namespace App\Http\Controllers;

use App\Models\Medicine;
use Illuminate\Http\Request;
use DataTables;

class MedicineController extends Controller
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
            $medicines = Medicine::query();
            return DataTables::eloquent($medicines)
                ->addColumn('action', function (Medicine $medicine) {
                    return '
                        <div class="text-center">
                            <a href="'. route('medicine.edit', [$medicine->id]) .'" class="btn btn-sm btn-warning">
                                <i class="mdi mdi-pencil"></i>
                            </a>
                            <form style="display: inline;" method="POST" action="'. route('medicine.destroy', [$medicine->id]) .'">
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
        return view('pages.medicine.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.medicine.create');
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
            'name' => 'required|string|min:3',
            'stock' => 'required|integer|min:3',
            'unit' => 'required|string|min:3',
            'price' => 'required|integer|min:3',
        ]);
        
        $store = Medicine::create($request->only("name", "stock", "unit", "price"));

        return redirect()->route("medicine.index");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Medicine $medicine)
    {
        return view('pages.medicine.edit', compact('medicine'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Medicine $medicine)
    {
        $request->validate([
            'name' => 'required|string|min:3',
            'stock' => 'required|integer|min:3',
            'unit' => 'required|string|min:3',
            'price' => 'required|integer|min:3',
        ]);
        
        $update = $medicine->update($request->only("name", "stock", "unit", "price"));

        return redirect()->route("medicine.index");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Medicine $medicine)
    {
        $delete = $medicine->delete();
        return redirect()->route("medicine.index");
    }
}
