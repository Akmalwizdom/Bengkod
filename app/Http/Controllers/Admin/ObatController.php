<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreObatRequest;
use App\Http\Requests\UpdateObatRequest;
use App\Http\Requests\UpdateStokRequest;
use App\Models\Obat;
use App\Services\ObatService;

class ObatController extends Controller
{
    public function __construct(
        private readonly ObatService $obatService,
    ) {}

    public function index()
    {
        $obats = Obat::all();
        return view('admin.obat.index', compact('obats'));
    }

    public function create()
    {
        return view('admin.obat.create');
    }

    public function store(StoreObatRequest $request)
    {
        Obat::create($request->validated());

        return redirect()->route('obat.index')
            ->with('message', 'Data Obat Berhasil dibuat')
            ->with('type', 'success');
    }

    public function edit(string $id)
    {
        $obat = Obat::findOrFail($id);
        return view('admin.obat.edit', compact('obat'));
    }

    public function update(UpdateObatRequest $request, string $id)
    {
        $obat = Obat::findOrFail($id);
        $obat->update($request->validated());

        return redirect()->route('obat.index')
            ->with('message', 'Data Obat berhasil di edit')
            ->with('type', 'success');
    }

    public function destroy(string $id)
    {
        $obat = Obat::findOrFail($id);
        $obat->delete();

        return redirect()->route('obat.index')
            ->with('message', 'Data Obat berhasil di Hapus')
            ->with('type', 'success');
    }

    public function updateStok(UpdateStokRequest $request, string $id)
    {
        $obat = Obat::findOrFail($id);

        try {
            if ($request->tipe === 'tambah') {
                $this->obatService->tambahStok($obat, $request->jumlah);
            } else {
                $this->obatService->kurangiStok($obat, $request->jumlah);
            }

            return redirect()->route('obat.index')
                ->with('message', "Stok {$obat->nama_obat} berhasil di-update")
                ->with('type', 'success');
        } catch (\InvalidArgumentException $e) {
            return redirect()->back()
                ->with('message', $e->getMessage())
                ->with('type', 'error');
        }
    }
}
