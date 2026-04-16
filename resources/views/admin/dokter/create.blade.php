<x-layouts.app title="Tambah Dokter">

    {{-- Header --}}
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('dokter.index') }}" class="flex items-center justify-center transition rounded-lg w-9 h-9 bg-slate-100 hover:bg-slate-200 text-slate-600">
            <i class="text-sm fas fa-arrow-left"></i>
        </a>

        <h2 class="text-2xl font-bold text-slate-800">
            Tambah Dokter
        </h2>
    </div>

    {{-- Card Form --}}
    <div class="border shadow-md card bg-base-100 rounded-2xl border-slate-200">
        <div class="p-8 card-body">

            <form action="{{ route('dokter.store') }}" method="POST">
                @csrf

                {{-- Grid 2 Column --}}
                <div class="grid grid-cols-1 gap-6 mb-6 md:grid-cols-2">

                    {{-- Nama --}}
                    <div class="form-control">
                        <label class="label">
                            <span class="text-sm font-semibold label-text text-slate-700">
                                Nama Dokter <span class="text-red-500">*</span>
                            </span>
                        </label>
                        <input type="text" name="nama" value="{{ old('nama') }}" placeholder="Masukkan nama dokter..."
                            class="input input-bordered border-2 rounded-lg p-2 w-full 
                                      focus:outline-none focus:ring-2 focus:ring-primary
                                      @error('nama') input-error @enderror" required>
                        @error('nama')
                        <span class="mt-1 text-xs text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Email --}}
                    <div class="form-control">
                        <label class="label">
                            <span class="text-sm font-semibold label-text text-slate-700">
                                Email <span class="text-red-500">*</span>
                            </span>
                        </label>
                        <input type="email" name="email" value="{{ old('email') }}" placeholder="Masukkan email..."
                            class="input input-bordered border-2 rounded-lg p-2 w-full 
                                      focus:ring-2 focus:ring-primary
                                      @error('email') input-error @enderror" required>
                        @error('email')
                        <span class="mt-1 text-xs text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- No KTP --}}
                    <div class="form-control">
                        <label class="label">
                            <span class="text-sm font-semibold label-text text-slate-700">
                                No. KTP <span class="text-red-500">*</span>
                            </span>
                        </label>
                        <input type="number" name="no_ktp" value="{{ old('no_ktp') }}" placeholder="Masukkan No. KTP..."
                            class="input input-bordered border-2 rounded-lg p-2 w-full
                                      focus:ring-2 focus:ring-primary
                                      @error('no_ktp') input-error @enderror" required>
                        @error('no_ktp')
                        <span class="mt-1 text-xs text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- No HP --}}
                    <div class="form-control">
                        <label class="label">
                            <span class="text-sm font-semibold label-text text-slate-700">
                                No. HP <span class="text-red-500">*</span>
                            </span>
                        </label>
                        <input type="number" name="no_hp" value="{{ old('no_hp') }}" placeholder="Masukkan No. HP..."
                            class="input input-bordered border-2 rounded-lg p-2 w-full
                                      focus:ring-2 focus:ring-primary
                                      @error('no_hp') input-error @enderror" required>
                        @error('no_hp')
                        <span class="mt-1 text-xs text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                </div>

                {{-- Alamat --}}
                <div class="mb-6 form-control">
                    <label class="label">
                        <span class="text-sm font-semibold label-text text-slate-700">
                            Alamat <span class="text-red-500">*</span>
                        </span>
                    </label>
                    <textarea name="alamat" rows="3" placeholder="Masukkan alamat..." class="textarea textarea-bordered border-2 rounded-lg p-2 w-full
                                     focus:ring-2 focus:ring-primary
                                     @error('alamat') textarea-error @enderror" required>{{ old('alamat') }}</textarea>
                    @error('alamat')
                    <span class="mt-1 text-xs text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Poli --}}
                <div class="mb-6 form-control">
                    <label class="label">
                        <span class="text-sm font-semibold label-text text-slate-700">
                            Poli <span class="text-red-500">*</span>
                        </span>
                    </label>
                    <select name="id_poli" class="select select-bordered border-2 rounded-lg p-2 w-full
                                   focus:ring-2 focus:ring-primary
                                   @error('id_poli') select-error @enderror" required>
                        <option value="">Pilih Poli</option>
                        @foreach($polis as $poli)
                        <option value="{{ $poli->id }}" {{ old('id_poli')==$poli->id ? 'selected' : '' }}>
                            {{ $poli->nama_poli }}
                        </option>
                        @endforeach
                    </select>
                    @error('id_poli')
                    <span class="mt-1 text-xs text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Password --}}
                <div class="mb-8 form-control">
                    <label class="label">
                        <span class="text-sm font-semibold label-text text-slate-700">
                            Password <span class="text-red-500">*</span>
                        </span>
                    </label>
                    <input type="password" name="password" placeholder="Minimal 8 karakter..." class="input input-bordered border-2 rounded-lg p-2 w-full
                                  focus:ring-2 focus:ring-primary
                                  @error('password') input-error @enderror" required>
                    @error('password')
                    <span class="mt-1 text-xs text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Buttons --}}
                <div class="flex items-center gap-3">
                    <button type="submit" class="inline-flex items-center gap-2 px-6 py-2.5
                               bg-primary hover:bg-primary/90
                               text-white border-2 rounded-lg p-2 font-semibold text-sm transition">
                        <i class="text-sm fas fa-save"></i>
                        Simpan
                    </button>

                    <a href="{{ route('dokter.index') }}" class="inline-flex items-center gap-2 px-6 py-2.5
                              bg-slate-100 hover:bg-slate-200
                              text-slate-600 rounded-xl font-semibold text-sm transition">
                        Batal
                    </a>
                </div>

            </form>
        </div>
    </div>

</x-layouts.app>