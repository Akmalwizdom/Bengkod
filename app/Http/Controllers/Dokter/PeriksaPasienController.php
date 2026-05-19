<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePeriksaRequest;
use App\Models\DaftarPoli;
use App\Models\Obat;
use App\Services\PeriksaService;
use Illuminate\Support\Facades\Auth;

class PeriksaPasienController extends Controller
{
    public function __construct(
        private readonly PeriksaService $periksaService,
    ) {}

    public function index()
    {
        $dokterId = Auth::id();

        $daftarPasien = DaftarPoli::with(['pasien', 'jadwalPeriksa', 'periksas'])
            ->whereHas('jadwalPeriksa', function ($query) use ($dokterId) {
                $query->where('id_dokter', $dokterId);
            })
            ->orderBy('no_antrian')
            ->get();

        return view('dokter.periksa-pasien.index', compact('daftarPasien'));
    }

    public function create($id)
    {
        $obats = Obat::orderBy('nama_obat')->get();
        return view('dokter.periksa-pasien.create', compact('obats', 'id'));
    }

    public function store(StorePeriksaRequest $request)
    {
        $obatIds = json_decode($request->obat_json, true);

        try {
            $this->periksaService->simpanPeriksa([
                'id_daftar_poli' => $request->id_daftar_poli,
                'tgl_periksa'    => now(),
                'catatan'        => $request->catatan,
                'biaya_periksa'  => $request->biaya_periksa + 150000,
            ], $obatIds);

            return redirect()->route('periksa-pasien.index')
                ->with('success', 'Data periksa berhasil disimpan.');
        } catch (\RuntimeException $e) {
            return redirect()->back()
                ->with('error', $e->getMessage())
                ->withInput();
        }
    }
}
