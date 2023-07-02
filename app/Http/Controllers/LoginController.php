<?php

namespace App\Http\Controllers;

use App\Models\AlertLevel;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('login.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $email = $request->input("email");
        $password = $request->input("password");

        if ($email === env("OWNER_EMAIL") && $password === env("OWNER_PASSWORD")) {
            session()->put("owner", true);
            session()->put([
                "alert" => "Welcome!",
                "alert-level" => AlertLevel::SUCCESS
            ]);

            return redirect("files");
        }

        session()->put([
            "alert" => "Access Denied",
            "alert-level" => AlertLevel::DANGER
        ]);

        return redirect()->back()->withInput();
    }
}
