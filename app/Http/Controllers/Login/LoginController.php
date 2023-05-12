<?php

namespace App\Http\Controllers\Login;

use App\Models\User;
use App\Models\Jabatan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('Login.login', [
            "tittle" => "Login"
        ]);
    }

    public function authentication(Request $request)
    {
        $credentials = $request->validate(
            [
                'email'     => 'required|email',
                'password'  => 'required',
            ],
            [
                'email.required' => 'Email harus diisi',
                'email.email' => 'Email harus berupa alamat email',
                'password.required' => 'Password harus diisi',
            ]
        );
        
        if(Auth::attempt($credentials)){
            $request->session()->regenerate();
            return redirect()->intended('dashboard');
        }
        
        return back()->with('pesan', 'Email atau password salah!');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $jabatan = Jabatan::all();
        return view('Login.register', compact('jabatan'), [
            "tittle" => "Register"
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {   
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

    }

    public function logout(Request $request)
    {
        Session::flush();
        Auth::logout();
        return redirect('login');
    }
}
