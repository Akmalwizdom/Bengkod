<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Obat extends Model
{
    protected $table = 'obat';

    protected $fillable = [
        'nama_obat',
        'kemasan',
        'harga',
        'stok',
    ];

    protected $casts = [
        'harga' => 'integer',
        'stok'  => 'integer',
    ];

    public function scopeStokMenipis(Builder $query, int $threshold = 10): Builder
    {
        return $query->where('stok', '>', 0)->where('stok', '<=', $threshold);
    }

    public function scopeStokHabis(Builder $query): Builder
    {
        return $query->where('stok', 0);
    }

    public function scopeTersedia(Builder $query): Builder
    {
        return $query->where('stok', '>', 0);
    }

    public function isStokHabis(): bool
    {
        return $this->stok <= 0;
    }

    public function isStokMenipis(int $threshold = 10): bool
    {
        return $this->stok > 0 && $this->stok <= $threshold;
    }

    public function detailPeriksas()
    {
        return $this->hasMany(DetailPeriksa::class, 'id_obat');
    }
}
