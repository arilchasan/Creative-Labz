<?php

namespace App\Http\Controllers\Api;

use App\Models\Contact;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class ContactController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $data = Contact::latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    $actionBtn = '<a href="/dashboard/contact/detail-' .  $data->name . '" class="info btn btn-info btn-sm"><i class="fa-solid fa-circle-info" style="color: #ffffff;"></i></a> <a href="/dashboard/contact/edit-' .  $data->name . '" class="edit btn btn-secondary btn-sm"><i class="fas fa-pen"></i></a> <a class="delete btn btn-danger btn-sm" onclick="deleteConfirmation(' . $data->id . ')"><i class="fas fa-trash" style="color: white;"></i></a>';

                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('contact.contact');
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string',
                'email' => 'required|email',
                'message' => 'required',
            ]);

            $contact = Contact::create([
                'name' => $request->name,
                'email' => $request->email,
                'message' => $request->message
            ]);

            if ($request->wantsJson()) {
                return $this->postSuccessResponse('Terima Kasih, Pesan Anda Berhasil Dikirim', $contact);
            }
            return redirect()->route('contact.index')->with('success', 'Terima Kasih, Pesan Anda Berhasil Dikirim');
        } catch (\Throwable $th) {
            if ($request->wantsJson()) {
                return response()->json([
                    'message' => $th->getMessage()
                ]);
            }
            return redirect()->route('contact.index')->with('error', $th->getMessage());
        };
    }

    public function edit($id)
    {
        $contact = Contact::where('name', $id)->first();
        return view('contact.edit', ['contact' => $contact]);
    }

    public function detail($id)
    {
        $contact = Contact::where('name', $id)->first();
        return view('contact.detail', ['contact' => $contact]);
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'name' => 'required|string',
                'email' => 'required|email',
                'message' => 'required',
            ]);

            $contact = Contact::where('name',$id)->first();
            $contact->update([
                'name' => $request->name,
                'email' => $request->email,
                'message' => $request->message
            ]);

            return redirect()->route('contact.all')->with('success', 'Berhasil Mengubah Pesan');
        } catch (\Throwable $th) {
            return redirect()->route('contact.all')->with('error', $th->getMessage());
        };
    }

    public function destroy($id)
    {
        try {
            $contact = Contact::where('name', $id)->first();
            $contact->delete();
            return redirect()->route('contact.all')->with('success', 'Berhasil Menghapus Pesan');
        } catch (\Throwable $th) {
            return redirect()->route('contact.all')->with('error', $th->getMessage());
        };
    }
}
