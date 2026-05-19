<x-layouts.app title="Data Obat">

    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-bold text-slate-800">Data Obat</h2>
        <a href="{{ route('obat.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 
                  bg-primary hover:bg-primary/90 text-white text-sm font-semibold rounded-xl transition">
            <i class="fas fa-plus text-xs"></i> Tambah Obat
        </a>
    </div>

    {{-- Card --}}
    <div class="card bg-base-100 shadow-md rounded-2xl border">
        <div class="card-body p-0">
            <div class="overflow-x-auto">
                <table class="table w-full">
                    <thead class="bg-slate-50 text-slate-500 uppercase text-xs tracking-wider">
                        <tr>
                            <th class="px-6 py-4">Nama Obat</th>
                            <th class="px-6 py-4">Kemasan</th>
                            <th class="px-6 py-4">Harga</th>
                            <th class="px-6 py-4">Stok</th>
                            <th class="px-6 py-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm text-slate-700">
                        @forelse($obats as $obat)
                        <tr class="border-t border-slate-100 hover:bg-slate-50 transition">
                            <td class="px-6 py-4 font-semibold text-slate-800">{{ $obat->nama_obat }}</td>
                            <td class="px-6 py-4">
                                <span class="inline-block px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-600">
                                    {{ $obat->kemasan ?? '-' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 font-semibold text-slate-800">
                                Rp {{ number_format($obat->harga, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4">
                                @if($obat->stok === 0)
                                    <span class="inline-flex items-center gap-1 px-3 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-700 border border-red-200 stok-habis-pulse">
                                        <i class="fas fa-circle-exclamation"></i> Habis
                                    </span>
                                @elseif($obat->stok <= 10)
                                    <span class="inline-flex items-center gap-1 px-3 py-1 text-xs font-semibold rounded-full bg-amber-100 text-amber-700 border border-amber-200">
                                        <i class="fas fa-triangle-exclamation"></i> {{ $obat->stok }}
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-3 py-1 text-xs font-semibold rounded-full bg-emerald-100 text-emerald-700 border border-emerald-200">
                                        {{ $obat->stok }}
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex justify-end gap-2">
                                    {{-- Stok --}}
                                    <button type="button"
                                        data-id="{{ $obat->id }}"
                                        data-nama="{{ $obat->nama_obat }}"
                                        data-stok="{{ $obat->stok }}"
                                        onclick="openStokModal(this)"
                                        class="inline-flex items-center gap-1 px-3 py-2 bg-blue-500 hover:bg-blue-600 text-white text-xs font-semibold rounded-lg transition">
                                        <i class="fas fa-boxes-stacked text-xs"></i> Stok
                                    </button>
                                    {{-- Edit --}}
                                    <a href="{{ route('obat.edit', $obat->id) }}"
                                        class="inline-flex items-center gap-1 px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white text-xs font-semibold rounded-lg transition">
                                        <i class="fas fa-pen text-xs"></i> Edit
                                    </a>
                                    {{-- Delete --}}
                                    <form action="{{ route('obat.destroy', $obat->id) }}" method="POST">
                                        @csrf @method('DELETE')
                                        <button type="submit" onclick="return confirm('Yakin ingin menghapus obat ini?')"
                                            class="inline-flex items-center gap-1 px-4 py-2 bg-red-500 hover:bg-red-600 text-white text-xs font-semibold rounded-lg transition">
                                            <i class="fas fa-trash text-xs"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-12 text-slate-400">
                                <i class="fas fa-inbox text-3xl mb-3 block"></i>
                                Belum ada data obat
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Modal Update Stok --}}
    <dialog id="stokModal" class="modal">
        <div class="modal-box rounded-2xl p-8">
            <h3 class="text-xl font-bold text-slate-800 mb-6" id="stokModalTitle">Update Stok</h3>
            <form id="stokForm" method="POST">
                @csrf @method('PATCH')
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">Tipe</label>
                        <select name="tipe" class="w-full px-4 py-2 border-2 rounded-lg focus:border-primary focus:outline-none">
                            <option value="tambah">Tambah Stok</option>
                            <option value="kurang">Kurangi Stok</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">Jumlah</label>
                        <div class="flex items-center border-2 rounded-lg overflow-hidden">
                            <button type="button" onclick="stepJumlah(-1)"
                                class="px-3 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 transition">
                                <i class="fas fa-minus text-sm"></i>
                            </button>
                            <input type="number" name="jumlah" id="inputJumlah" min="1" value="1"
                                class="w-full px-3 py-2 text-center focus:outline-none [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none" required>
                            <button type="button" onclick="stepJumlah(1)"
                                class="px-3 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 transition">
                                <i class="fas fa-plus text-sm"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <p class="text-sm text-slate-500 mb-6">Stok saat ini: <span id="stokSaatIni" class="font-bold text-slate-800"></span></p>
                <div class="flex gap-3">
                    <button type="submit" class="px-6 py-2.5 rounded-xl bg-primary hover:bg-primary/90 text-white font-semibold text-sm transition">
                        <i class="fas fa-save mr-1"></i> Simpan
                    </button>
                    <button type="button" onclick="document.getElementById('stokModal').close()"
                        class="px-6 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-600 font-semibold text-sm transition">
                        Batal
                    </button>
                </div>
            </form>
        </div>
        <form method="dialog" class="modal-backdrop"><button>close</button></form>
    </dialog>

    <script>
        function openStokModal(btn) {
            const id = btn.dataset.id;
            const nama = btn.dataset.nama;
            const stok = btn.dataset.stok;
            document.getElementById('stokModalTitle').textContent = 'Update Stok: ' + nama;
            document.getElementById('stokSaatIni').textContent = stok;
            document.getElementById('stokForm').action = '/admin/obat/' + id + '/stok';
            document.getElementById('inputJumlah').value = 1;
            document.getElementById('stokModal').showModal();
        }

        function stepJumlah(delta) {
            const input = document.getElementById('inputJumlah');
            const val = Math.max(1, parseInt(input.value || 1) + delta);
            input.value = val;
        }
    </script>

</x-layouts.app>
