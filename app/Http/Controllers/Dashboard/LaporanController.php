<?php

namespace App\Http\Controllers\Dashboard;

use Carbon\Carbon;
use App\Models\Laporan;
use Illuminate\Http\Request;
use App\Models\RekeningKoran;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\Response;

class LaporanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::user()->jabatan_id == 1) {
            $laporan = Laporan::with('user', 'rekeningKoran')->get();
        } else {
            $laporan = Laporan::with('user', 'rekeningKoran')->where('id_user', Auth::user()->id)->get();
        }
        $rekening = RekeningKoran::all();
        return view('Dashboard.laporan', compact('laporan', 'rekening'), [
            "tittle" => "Laporan",
            "id" => Auth::user()->jabatan_id,
        ]);
    }

    /**
     * Import data from Excel into MySQL
     */
    public function import(Request $request, Laporan $Laporan)
    {
        $file_excel = $request->file_excel;
        $file_name = $_FILES['file_excel']['name'];
        $file_data = $_FILES['file_excel']['tmp_name'];

        //checkk if file upload is empty then send error
        if (empty($file_data)) {
            return back()->with('pesan', 'Tidak ada file yang dipilih!');
        } else {
            //if not empty then take out the extension file
            $ekstensi = pathinfo($file_name, PATHINFO_EXTENSION);
        }

        //check the extension file
        $ekstensi_allowed = array("xls", "xlsx");
        if (!in_array($ekstensi, $ekstensi_allowed)) {
            return back()->with('pesan', 'File Ekstensi harus xlx atau xlsx!');
        } else {

            //using phpspreadsheet for read excel file
            $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReaderForFile($file_data);;
            $spreadSheet = $reader->load($file_data);
            $sheetData = $spreadSheet->getActiveSheet()->toArray();
            $jumlahData = 0;

            //insert data from phpspreadsheet into MySQL using variable $data
            for ($i = 1; $i < count($sheetData); $i++) {
                $tanggal = Carbon::parse($sheetData[$i][0])->format('Y-m-d');
                $data[] = [
                    'nama_bank' => $request->kode_rekening,
                    'tanggal' => $tanggal,
                    'rincian_transaksi' => $sheetData[$i][1],
                    'debit' => $sheetData[$i][2],
                    'kredit' => $sheetData[$i][3],
                    'no_dokumen' => $sheetData[$i][4],
                    'analisis_input' => $sheetData[$i][5],
                    'id_user' => Auth::user()->id,
                ];

                Laporan::create($data[$jumlahData]);
                $jumlahData++;
            };
            return redirect('laporan')->with('pesan', $jumlahData . ' data sudah berhasil dimasukkan');
        }
    }

    /**
     * Download template import excel
     */
    public function getDownload()
    {
        $target_dir = "template_input/template.xlsx";

        $headers = array(
            'Content-Type: application/xslx',
        );

        return Response::download($target_dir, 'template_input.xlsx', $headers);
        // return Storage::download(public_path('template_input/template.pdf'));
    }

    /**
     * Eksport data from MySQL into excel(.xlsx)
     */
    public function export()
    {
        if (Auth::user()->jabatan_id == 1) {
            $data = Laporan::all();
        } else {
            $data = Laporan::with('user')->where('id_user', Auth::user()->id)->get();
        }
        return view('Dashboard.exportExcel', compact('data'));
    }

    public function exportRek(string $id)
    {
        if (Auth::user()->jabatan_id == 1) {
            $data = Laporan::with('rekeningKoran')->where('nama_bank', $id)->get();
        } else {
            $data = Laporan::with('user', 'rekeningKoran')->where('id_user', Auth::user()->id)
                ->where('nama_bank', $id)->get();
        }
        return view('Dashboard.exportExcel', compact('data'));
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
                'rincian_transaksi'  => 'required',
                'debit'  => 'required',
                'kredit'  => 'required',
                'no_dokumen'  => 'required',
                'analisis_input'  => 'required',
            ],
            [
                'rincian_transaksi.required' => 'Rincian Transaksi harus diisi',
                'debit.required' => 'Debit harus diisi',
                'kredit.required' => 'Kredit harus diisi',
                'no_dokumen.required' => 'No dokumen harus diisi',
                'analisis_input.required' => 'Analisis input harus diisi',
            ]
        );

            if($request->tanggal == null){
                $mytime = Carbon::now();
                $tanggal = $mytime->toDateTimeString();
            } else {
                $tanggal = Carbon::parse($request->tanggal)->format('Y-m-d');
            }
    
            $laporan = new Laporan;
            $laporan->nama_bank = $request->kode_rekening;
            $laporan->tanggal = $tanggal;
            $laporan->rincian_transaksi = $request->rincian_transaksi;
            $laporan->debit = $request->debit;
            $laporan->kredit = $request->kredit;
            $laporan->no_dokumen = $request->no_dokumen;
            $laporan->analisis_input = $request->analisis_input;
            $laporan->id_user = Auth::user()->id;
            $laporan->save();

            session()->flash('pesan','Input data sukses');

            return redirect('laporan');
    }

    /**
     * Display the specified resource.
     */
    // public function show($id)
    // {
    //     if (Auth::user()->jabatan_id == 1) {
    //         $laporan = Mandiri::with('user', 'rekeningKoran')->where('nama_bank', $id)->get();
    //     } else {
    //         $laporan = Mandiri::with('user', 'rekeningKoran')->where('id_user', Auth::user()->id)
    //             ->where('nama_bank', $id)->get();
    //     }
    //     $rekening = RekeningKoran::all();

    //     return view('Dashboard.laporan', compact('laporan', 'rekening'), [
    //         "tittle" => "Laporan",
    //         "id" => Auth::user()->jabatan_id,
    //     ]);
    // }

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
                'rincian_transaksi'  => 'required',
                'debit'  => 'required',
                'kredit'  => 'required',
                'no_dokumen'  => 'required',
                'analisis_input'  => 'required',
            ],
            [
                'rincian_transaksi.required' => 'Rincian Transaksi harus diisi',
                'debit.required' => 'Debit harus diisi',
                'kredit.required' => 'Kredit harus diisi',
                'no_dokumen.required' => 'No dokumen harus diisi',
                'analisis_input.required' => 'Analisis input harus diisi',
            ]
        );

        //parse data "tanggal" into mySQL
        $tanggal = Carbon::parse($request->tanggal)->format('Y-m-d');

        DB::table('laporans')->where('id', $id)->update([
            "nama_bank" => $request->kode_rekening,
            "tanggal" => $tanggal,
            "rincian_transaksi" => $request->rincian_transaksi,
            "kredit" => $request->kredit,
            "debit" => $request->debit,
            "no_dokumen" => $request->no_dokumen,
            "analisis_input" => $request->analisis_input,
        ]);

        return redirect('laporan')->with('pesan', 'Data berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DB::table('laporans')->where('id', $id)->delete();

        return redirect('laporan')->with('pesan', 'Data berhasil dihapus');
    }
}
