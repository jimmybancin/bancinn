
<x-layouts.app :title="'Manajemen Buku'">
    <div class="max-w-6xl mx-auto py-10 px-4 space-y-10">
        {{-- Header --}}
        <div class="flex justify-between items-center">
            <h1 class="text-3xl font-bold text-black">📚 Manajemen Buku</h1>
            <a href="#form-section" class="bg-blue-600 text-gray-900 px-5 py-2 rounded hover:bg-blue-700 transition">
                + Tambah Buku
            </a>
        </div>
  
        {{-- Alert --}}
        @if(session('success'))
            <div class="p-4 rounded bg-green-100 text-green-700 border border-green-300">
                {{ session('success') }}
            </div>
        @endif
  
        {{-- Filter --}}
        <form method="GET" class="flex flex-col md:flex-row gap-4">
            <input type="text" name="search" placeholder="Cari judul buku..." value="{{ request('search') }}" class="flex-1 border px-3 py-2 rounded shadow-sm">
            <select name="kategori" class="border px-3 py-2 rounded shadow-sm">
                <option value="">Semua Kategori</option>
                <option value="Novel" {{ request('kategori') == 'Novel' ? 'selected' : '' }}>Novel</option>
                <option value="Ensiklopedia" {{ request('kategori') == 'Ensiklopedia' ? 'selected' : '' }}>Ensiklopedia</option>
                <option value="Biografi" {{ request('kategori') == 'Biografi' ? 'selected' : '' }}>Biografi</option>
            </select>
            <button type="submit" class="flex items-center gap-2 bg-gray-800 text-gray-900 px-4 py-2 rounded hover:bg-gray-900">
                🔍 Filter
            </button>
        </form>
  
        {{-- Form Tambah Buku --}}
        <div id="form-section" class="bg-white p-6 rounded shadow">
            <h2 class="text-xl font-semibold mb-4">📝 Tambah Buku</h2>
            <form method="POST" action="{{ route('buku.store') }}" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @csrf
                <input type="text" name="judul" placeholder="Judul Buku" class="border px-3 py-2 rounded" required>
                <input type="text" name="pengarang" placeholder="Pengarang" class="border px-3 py-2 rounded" required>
                <input type="text" name="tahun" placeholder="Tahun Terbit" class="border px-3 py-2 rounded" required>
                <input type="text" name="penerbit" placeholder="Penerbit" class="border px-3 py-2 rounded" required>
                <select name="kategori" class="border px-3 py-2 rounded md:col-span-2">
                    <option value="Novel">Novel</option>
                    <option value="Ensiklopedia">Ensiklopedia</option>
                    <option value="Biografi">Biografi</option>
                </select>
                <button class="bg-green-600 text-gray-900 px-5 py-2 rounded hover:bg-green-700 md:col-span-2">
                    💾 Simpan
                </button>
            </form>
        </div>
  
        {{-- Daftar Buku --}}
        <div class="bg-white p-6 rounded shadow">
            <h2 class="text-xl font-semibold mb-4">📖 Daftar Buku</h2>
            <div class="overflow-x-auto">
                <table class="w-full text-left border">
                    <thead class="bg-blue-100 text-blue-900">
                        <tr>
                            <th class="p-2">Judul</th>
                            <th class="p-2">Pengarang</th>
                            <th class="p-2">Tahun</th>
                            <th class="p-2">Penerbit</th>
                            <th class="p-2">Kategori</th>
                            <th class="p-2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($bukus as $buku)
                            @if(request('edit_id') == $buku->id)
                                {{-- Baris Form Edit --}}
                                <tr class="border-t bg-yellow-50">
                                    <form method="POST" action="{{ route('buku.update', $buku->id) }}">
                                        @csrf
                                        @method('PUT')
                                        <td class="p-2"><input type="text" name="judul" value="{{ $buku->judul }}" class="border px-2 py-1 w-full rounded" required></td>
                                        <td class="p-2"><input type="text" name="pengarang" value="{{ $buku->pengarang }}" class="border px-2 py-1 w-full rounded" required></td>
                                        <td class="p-2"><input type="text" name="tahun" value="{{ $buku->tahun }}" class="border px-2 py-1 w-full rounded" required></td>
                                        <td class="p-2"><input type="text" name="penerbit" value="{{ $buku->penerbit }}" class="border px-2 py-1 w-full rounded" required></td>
                                        <td class="p-2">
                                            <select name="kategori" class="border px-2 py-1 rounded w-full">
                                                <option value="Novel" {{ $buku->kategori == 'Novel' ? 'selected' : '' }}>Novel</option>
                                                <option value="Ensiklopedia" {{ $buku->kategori == 'Ensiklopedia' ? 'selected' : '' }}>Ensiklopedia</option>
                                                <option value="Biografi" {{ $buku->kategori == 'Biografi' ? 'selected' : '' }}>Biografi</option>
                                            </select>
                                        </td>
                                        <td class="p-2 flex gap-2">
                                            <button class="bg-green-600 text-gray-900 px-3 py-1 rounded hover:bg-green-700">💾 Simpan</button>
                                            <a href="{{ route('buku.index') }}" class="bg-gray-400 text-gray-900 px-3 py-1 rounded hover:bg-gray-500">Batal</a>
                                        </td>
                                    </form>
                                </tr>
                            @else
                                {{-- Baris Biasa --}}
                                <tr class="border-t hover:bg-gray-50">
                                    <td class="p-2">{{ $buku->judul }}</td>
                                    <td class="p-2">{{ $buku->pengarang }}</td>
                                    <td class="p-2">{{ $buku->tahun }}</td>
                                    <td class="p-2">{{ $buku->penerbit }}</td>
                                    <td class="p-2">{{ $buku->kategori }}</td>
                                    <td class="p-2 flex gap-2">
                                        <a href="{{ route('buku.index', ['edit_id' => $buku->id]) }}" class="bg-yellow-400 text-gray-900 px-3 py-1 rounded hover:bg-yellow-500">✏️ Edit</a>
                                        <form action="{{ route('buku.destroy', $buku->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="bg-red-600 text-gray-900 px-3 py-1 rounded hover:bg-red-700">🗑️ Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @endif
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-gray-500 py-4">Tidak ada data buku.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
  
            {{-- Pagination --}}
            <div class="mt-4 flex justify-between items-center text-sm text-gray-600">
                <div>
                    Menampilkan {{ $bukus->firstItem() }} - {{ $bukus->lastItem() }} dari {{ $bukus->total() }} buku
                </div>
                <div class="text-right">
                    {{ $bukus->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    </div>
  </x-layouts.app>
  