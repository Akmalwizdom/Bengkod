<?php

namespace App\Services;

use App\Models\DetailPeriksa;
use App\Models\Periksa;
use Illuminate\Support\Facades\DB;

class PeriksaService
{
    public function __construct(
        private readonly ObatService $obatService,
    ) {}

    public function simpanPeriksa(array $data, array $obatIds): Periksa
    {
        return DB::transaction(function () use ($data, $obatIds) {
            $periksa = Periksa::create($data);

            foreach ($obatIds as $idObat) {
                DetailPeriksa::create([
                    'id_periksa' => $periksa->id,
                    'id_obat'    => $idObat,
                ]);
            }

            $this->obatService->kurangiStokUntukResep($obatIds);

            return $periksa;
        });
    }
}
