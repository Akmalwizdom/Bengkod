<?php

namespace App\Services;

use App\Models\Obat;

class ObatService
{
    public function tambahStok(Obat $obat, int $jumlah): Obat
    {
        $obat->increment('stok', $jumlah);
        return $obat->fresh();
    }

    public function kurangiStok(Obat $obat, int $jumlah): Obat
    {
        if ($jumlah > $obat->stok) {
            throw new \InvalidArgumentException(
                "Stok {$obat->nama_obat} tidak mencukupi. Sisa: {$obat->stok}"
            );
        }

        $obat->decrement('stok', $jumlah);
        return $obat->fresh();
    }

    public function validasiStokResep(array $obatIds): array
    {
        $errors = [];
        $obatCounts = array_count_values($obatIds);

        foreach ($obatCounts as $id => $qty) {
            $obat = Obat::find($id);
            if (!$obat) continue;

            if ($obat->stok < $qty) {
                $errors[] = "Stok {$obat->nama_obat} tidak mencukupi (sisa: {$obat->stok}, butuh: {$qty}).";
            }
        }

        return $errors;
    }

    public function kurangiStokUntukResep(array $obatIds): void
    {
        $obatCounts = array_count_values($obatIds);

        foreach ($obatCounts as $id => $qty) {
            $obat = Obat::lockForUpdate()->findOrFail($id);

            if ($obat->stok < $qty) {
                throw new \RuntimeException(
                    "Stok {$obat->nama_obat} habis saat memproses resep."
                );
            }

            $obat->decrement('stok', $qty);
        }
    }
}
