<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Address;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    public function store(Request $request, $id)
    {
        $request->validate([
            'user_id' => 'nullable',
            'address' => 'required',
            'province' => 'required',
            'city' => 'required',
            'subdistrict' => 'required',
            'zip_code' => 'required',
            'phone' => 'required',
        ]);

        $address = Address::create([
            'user_id' => auth()->user()->id ?? null,
            'address' => $request->address,
            'province' => $request->province,
            'city' => $request->city,
            'subdistrict' => $request->subdistrict,
            'zip_code' => $request->zip_code,
            'phone' => $request->phone,
            'fullname' => $request->firstname . ' ' . $request->lastname,
            'full_address' => $request->address . ', ' . $request->subdistrict_name . ', ' . $request->city_name . ', ' . $request->province_name . ', ' . $request->zip_code,
        ]);
        $order = Order::find($id);
        if (!$order) {
            if ($request->wantsJson()) {
                return $this->notFoundResponse(null);
            }
        }
        $order->update([
            'address_id' => $address->id,
            'payment' => $request->payment,
        ]);


        if ($request->wantsJson()) {
            return $this->postSuccessResponse('Alamat berhasil ditambahkan!', [$order, $address]);
        }
        return redirect()->route('order.payment', $order->id)->with('success', 'Alamat berhasil ditambahkan!');
    }
}
