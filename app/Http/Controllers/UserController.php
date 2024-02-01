<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $data = User::latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    $actionBtn = '<a href="/dashboard/user/edit/' .  $data->id . '" class="edit btn btn-secondary btn-sm"><i class="fas fa-pen"></i></a> <a class="delete btn btn-danger btn-sm" onclick="deleteConfirmation(' . $data->id . ')"><i class="fas fa-trash" style="color: white;"></i></a>';

                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('user.index');
    }

    public function create()
    {
        return view('user.create');
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string|min:6|max:20',
            ]);
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
            ]);
            return redirect()->route('user.all')->with('success', 'Berhasil Menambahkan User');
        } catch (\Throwable $th) {
            return redirect()->route('user.all')->with('error', $th->getMessage());
        };
    }

    public function edit($id)
    {
        $user = User::find($id);
        return view('user.edit', ['user' => $user]);
    }

    public function update(Request $request, $id) {
        try {
            $request->validate([
                'name' => 'required|string',
                'email' => 'required|email|unique:users,email,' . $id,
                'password' => 'nullable|string|min:6|max:20',
            ]);
            $user = User::find($id);
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
            ]);
            if ($request->password) {
                $user->update([
                    'password' => bcrypt($request->password),
                ]);
            }
            return redirect()->route('user.all')->with('success', 'Berhasil Mengubah User');
        } catch (\Throwable $th) {
            return redirect()->route('user.all')->with('error', $th->getMessage());
        };
    }

    public function destroy($id)
    {
        try {
            $user = User::find($id);
            $user->delete();
            return redirect()->route('user.all')->with('success', 'Berhasil Menghapus User');
        } catch (\Throwable $th) {
            return redirect()->route('user.all')->with('error', $th->getMessage());
        };
    }
}
