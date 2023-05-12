<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\User;
use App\Models\Jabatan;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class AkunController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //call model user which already get relation with model jabatan
        $akun = User::with('jabatan')->get();
        $jabatan = Jabatan::all();
        return view('Dashboard.akun', compact('akun', 'jabatan'), [
            "tittle" => "Akun"
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Session::flash('name', $request->name);
        Session::flash('email', $request->email);
        Session::flash('jabatan', $request->jabatan);
        
        $validatedData = $request -> validate([
            'name' => 'required|max:50',
            'email' => 'required|email|unique:users',
            'jabatan_id' => 'required',
            'password' => 'required|min:5|max:20'
        ]);

        $validatedData['password'] = bcrypt($validatedData['password']);

        User::create($validatedData);

        return redirect('akun')->with('success', 'Registrasi Sukses');
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
        $validasiData = $request -> validate([
            'name' => 'required|max:50',
            'jabatan_id' => 'required',
            'password' => 'required|min:5|max:20'
        ]);

        $validasiData['password'] = bcrypt($validasiData['password']);

        DB::table('users')->where('id', $id)->update([
            'name' => $validasiData["name"],
            'jabatan_id' => $validasiData["jabatan_id"],
            'password' => $validasiData["password"],
        ]);

        return redirect('akun')->with('update', 'Akun berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DB::table('users')->where('id', $id)->delete();
        DB::table('mandiris')->where('id_user', $id)->delete();

        return redirect('akun')->with('delete', 'Akun berhasil dihapus');
    }
}
