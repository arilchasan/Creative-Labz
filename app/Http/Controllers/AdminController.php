<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class AdminController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $data = Admin::latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    $actionBtn = '<a href="/dashboard/admin/edit/' .  $data->id . '" class="edit btn btn-secondary btn-sm"><i class="fas fa-pen"></i></a> <a class="delete btn btn-danger btn-sm" onclick="deleteConfirmation(' . $data->id . ')"><i class="fas fa-trash" style="color: white;"></i></a>';

                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('admin.all');
    }

    public function create()
    {
        return view('admin.create');
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string',
                'password' => 'required|min:6',
            ]);

            $admin = Admin::create([
                'name' => $request->name,
                'password' => bcrypt($request->password)
            ]);

            if ($request->wantsJson()) {
                return $this->postSuccessResponse('Admin Berhasil Ditambahkan', $admin);
            }
            return redirect()->route('admin.all')->with('success', 'Admin Berhasil Ditambahkan');
        } catch (\Throwable $th) {
            if ($request->wantsJson()) {
                return response()->json([
                    'message' => $th->getMessage()
                ]);
            }
            return redirect()->route('admin.all')->with('error', $th->getMessage());
        };
    }

    public function edit($id)
    {
        $admin = Admin::where('id', $id)->first();
        //dd($admin);
        return view('admin.edit', ['admin' => $admin]);
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'name' => 'required|string',
                'password' => 'required|min:6',
            ]);

            $admin = Admin::where('name', $id)->first();
            $admin->update([
                'name' => $request->name,
                'password' => bcrypt($request->password)
            ]);

            if ($request->wantsJson()) {
                return $this->postSuccessResponse('Admin Berhasil Diubah', $admin);
            }
            return redirect()->route('admin.all')->with('success', 'Admin Berhasil Diubah');
        } catch (\Throwable $th) {
            if ($request->wantsJson()) {
                return response()->json([
                    'message' => $th->getMessage()
                ]);
            }
            return redirect()->route('admin.all')->with('error', $th->getMessage());
        };
    }
}
