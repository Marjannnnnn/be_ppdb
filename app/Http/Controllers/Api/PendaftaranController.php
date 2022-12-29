<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pembayaran;
use App\Models\Pendaftaran;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PendaftaranController extends Controller
{
    public function index()
    {
        return Pendaftaran::all();
    }

    public function show(Pendaftaran $pendaftaran)
    {
        return $pendaftaran;
    }

    public function store(Request $request)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'NISN' => 'required|string|size:10|unique:pendaftaran',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'nama' => 'required|string',
            'asal_sekolah' => 'required|string',
            'email' => 'required|email|unique:pendaftaran',
            'nomor_handphone' => 'required|string|min:10',
            'nomor_hp_ayah' => 'required|string|min:10',
            'nomor_hp_ibu' => 'required|string|min:10',
            'pilih_referensi' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Create a new pendaftaran record
        $pendaftaran = Pendaftaran::create($request->all());

        // Create a new user record
        $user = User::create([
            'name' => $request->input('nama'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('NISN')),
        ]);

        // Generate the PDF file
        $pdf = PDF::loadView('pdf.template', compact('pendaftaran', 'user'));
        $pdfContent = $pdf->output();

        // Store the PDF file in the public/pdf directory
        $filePath = 'pdf/formulir_pendaftaran_' . $pendaftaran->NISN . '.pdf';
        Storage::put($filePath, $pdfContent);

        // Return the URL of the PDF file as the response
        return response(url('api/pdf_formulir_pendaftaran/' . $pendaftaran->NISN), 201);
    }

    public function downloadPDF($NISN)
    {
        // Retrieve the PDF file from the storage
        $filePath = 'pdf/formulir_pendaftaran_' . $NISN . '.pdf';
        $fileContent = Storage::get($filePath);

        // Return the PDF file as a response
        return response($fileContent, 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'attachment; filename="formulir_pendaftaran_' . $NISN . '.pdf"')
            ->header('Access-Control-Allow-Origin', '*');
    }

    public function update(Request $request, Pendaftaran $pendaftaran)
    {
        $validator = Validator::make($request->all(), [
            'nama_bank' => 'required',
            'pemilik_rekening' => 'required',
            'nominal' => 'required',
            'foto' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);


        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $file = $request->file('foto');
        $extension = $file->getClientOriginalExtension();
        $filename = time() . '.' . $extension;

        $path = $request->file('foto')->move(public_path('foto_pembayaran'), $filename);
        $url = asset('foto_pembayaran/' . $filename);

        $pendaftaran->update([
            'nama_bank' => $request->input('nama_bank'),
            'pemilik_rekening' => $request->input('pemilik_rekening'),
            'nominal' => $request->input('nominal'),
            'foto' => $url,
            'pembayaran' => true
        ]);


        return response()->json($pendaftaran, 200);
    }


    public function updateTervalidasi(Request $request, Pendaftaran $pendaftaran)
    {
        $validator = Validator::make($request->all(), [
            'tervalidasi' => 'required|in:diterima,ditolak',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $pendaftaran->update([
            'tervalidasi' => $request->input('tervalidasi'),
        ]);

        return response()->json($pendaftaran, 200);
    }

    public function delete(Pendaftaran $id)
    {
        $id->delete();

        return response()->json(null, 204);
    }
}
