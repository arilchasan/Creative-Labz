<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Admin;
use App\Models\Contact;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view("layouts.app");
    }

    public function home()
    {
        $admin = Admin::count();
        $user = User::count();
        $contact = Contact::count();
        $product = Product::count();
        return view("menu.home", ['admin' => $admin, 'user' => $user, 'contact' => $contact, 'product' => $product]);
    }
}
