<?php

namespace App\Http\Controllers;

use App\Models\Promo;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PromoController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $data = Promo::latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    $actionBtn = '<a href="/dashboard/promo/edit-' .  $data->code . '" class="edit btn btn-secondary btn-sm"><i class="fas fa-pen"></i></a> <a class="delete btn btn-danger btn-sm" onclick="deleteConfirmation(' . $data->id . ')"><i class="fas fa-trash" style="color: white;"></i></a>';

                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('promo.index');
    }

    public function create()
    {
        return view('promo.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|unique:promo',
            'discount' => 'required|numeric',
        ]);

        Promo::create($request->all());

        return redirect()->route('promo.all')->with('success', 'Berhasil menambahkan promo');
    }

    public function edit($id)
    {
        $promo = Promo::where('code', $id)->first();
        return view('promo.edit', compact('promo'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'code' => 'required',
            'discount' => 'required|numeric',
        ]);

        $promo = Promo::where('code', $id)->first();

        $promo->update([
            'code' => $request->code,
            'discount' => $request->discount,
        ]);

        return redirect()->route('promo.all')->with('success', 'Berhasil mengubah promo');
    }

    public function destroy($id)
    {
        $promo = Promo::where('id', $id)->first();
        $promo->delete();

        return redirect()->route('promo.all')->with('success', 'Berhasil menghapus promo');
    }
}
