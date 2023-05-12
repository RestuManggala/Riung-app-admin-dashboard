<?php

namespace App\Http\Controllers\Dashboard;

use File;
use Response;
use Illuminate\Http\Request;
use App\Models\RekeningKoran;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use GuzzleHttp\Psr7\Response as Psr7Response;

class RekeningKoranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rekening = RekeningKoran::all();
        return view('Dashboard.rekeningKoran', compact('rekening'), [
            "tittle" => "Rekening Koran",
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
        $credentials = $request->validate(
            [
                'kode_rekening'  => 'required',
                'nama_bank'  => 'required',
            ],
            [
                'kode_rekening.required' => 'Kode Rekening harus diisi',
                'nama_bank.required' => 'Nama bank harus diisi',
            ]
        );

        $file_pdf = $request->file('pdf');
        $file_data = $_FILES['pdf']['tmp_name'];

        //checkk if file upload is empty then send error
        if (empty($file_data)) {
            return back()->with('pesan', 'Tidak ada file yang dipilih!');
        } else {
            //if not empty then take out the extension file
            $file_name = $file_pdf->getClientOriginalName();
            $target_dir = "file_pdf/" . $file_name;
            $ekstensi = pathinfo($file_name, PATHINFO_EXTENSION);
        }

        $ekstensi_allowed = array("pdf");
        if (!in_array($ekstensi, $ekstensi_allowed)) {
            return back()->with('pesan', 'File Ekstensi harus pdf');
        } else {

            $rekening = new RekeningKoran;
            $rekening->nama_bank = $request->nama_bank;
            $rekening->kode_rekening = $request->kode_rekening;
            $rekening->pdf = $file_name;
            $rekening->save();
            move_uploaded_file($file_data, $target_dir);
            return redirect('rekening-koran')->with('pesan', 'Data sudah berhasil ditambahkan');
        }
    }

    public function getDownload($id)
    {
        $rekening = RekeningKoran::find($id);
        $target_dir = "file_pdf/" . $rekening->pdf;

        $headers = array(
            'Content-Type: application/pdf',
        );

        return Response::download($target_dir, 'filename.pdf', $headers);
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
        $credentials = $request->validate(
            [
                'kode_rekening'  => 'required',
                'nama_bank'  => 'required',
            ],
            [
                'kode_rekening.required' => 'Kode Rekening harus diisi',
                'nama_bank.required' => 'Nama bank harus diisi',
            ]
        );

        $file_pdf = $request->file('pdf');
        if($file_pdf == null){
            $file_name = $request->fileLama;
        } else {
            $file_name = $file_pdf->getClientOriginalName();
            $ekstensi = pathinfo($file_name, PATHINFO_EXTENSION);

            $ekstensi_allowed = array("pdf");
            if (!in_array($ekstensi, $ekstensi_allowed)) {
                return back()->with('pesan', 'File Ekstensi harus pdf');
            }
        }

        if($file_name != $request->fileLama){
            $file_data = $_FILES['pdf']['tmp_name'];
            $target_dir = "file_pdf/" . $file_name;
            File::delete("file_pdf/" . $request->fileLama);
            move_uploaded_file($file_data, $target_dir);
        }

        DB::table('rekening_korans')->where('id', $id)->update([
            "nama_bank" => $request->nama_bank,
            "kode_rekening" => $request->kode_rekening,
            "pdf" => $file_name,
        ]);

        return redirect('rekening-koran')->with('pesan', 'Data berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // hapus gambar
        $fileGambar = RekeningKoran::find($id);
        FILE::delete("file_pdf/" . $fileGambar->pdf);
        
        DB::table('rekening_korans')->where('id', $id)->delete();

        return redirect('rekening-koran')->with('pesan', 'Data berhasil dihapus');
    }
}
