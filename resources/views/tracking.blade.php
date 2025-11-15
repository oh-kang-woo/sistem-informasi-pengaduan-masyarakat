    @extends('layouts.app')

    @section('title', 'Riwayat & Tracking Pengaduan')

    @section('content')
    <div class="container-fluid px-4 py-5">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="h4 fw-bold mb-1">Riwayat & Tracking Pengaduan</h2>
                <p class="text-muted">Lihat semua progres pengaduan yang telah Anda buat.</p>
            </div>
            <a href="{{ route('pengaduan.create') }}" class="btn btn-primary shadow-sm">
                + Buat Pengaduan Baru
            </a>
        </div>

        {{-- Statistik --}}
        <div class="row g-3 mb-4">
            @foreach(['menunggu'=>'Menunggu Verifikasi','proses'=>'Sedang Diproses','selesai'=>'Selesai','ditolak'=>'Ditolak'] as $key=>$label)
            <div class="col-md-3">
                <div class="card p-3 shadow-sm border-left-{{ $key=='menunggu'?'warning':($key=='proses'?'info':($key=='selesai'?'success':'danger')) }}">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-muted small text-uppercase">{{ $label }}</div>
                            <div class="h3 fw-bold">{{ $stats[$key] ?? 0 }}</div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        {{-- Filter --}}
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-light">
                <h5 class="mb-0">Filter Pengaduan</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('pengaduan.riwayat') }}" method="GET">
                    <div class="row g-3 align-items-end">
                        <div class="col-md-3">
                            <label for="status" class="form-label">Status</label>
                            <select id="status" name="status" class="form-select">
                                <option value="">Semua Status</option>
                                <option value="menunggu" @if(request('status')=='menunggu') selected @endif>Menunggu Verifikasi</option>
                                <option value="proses" @if(request('status')=='proses') selected @endif>Sedang Diproses</option>
                                <option value="selesai" @if(request('status')=='selesai') selected @endif>Selesai</option>
                                <option value="ditolak" @if(request('status')=='ditolak') selected @endif>Ditolak</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="kategori" class="form-label">Kategori</label>
                            <select id="kategori" name="kategori_id" class="form-select">
                                <option value="">Semua Kategori</option>
                                @foreach($kategoriOptions as $kategori)
                                    <option value="{{ $kategori->id }}" @if(request('kategori_id') == $kategori->id) selected @endif>
                                        {{ $kategori->nama }}
                                    </option>
                                @endforeach
                            </select>

                        </div>
                        <div class="col-md-2">
                            <label for="dari_tanggal" class="form-label">Dari Tanggal</label>
                            <input type="date" id="dari_tanggal" name="dari_tanggal" class="form-control" value="{{ request('dari_tanggal') }}">
                        </div>
                        <div class="col-md-2">
                            <label for="sampai_tanggal" class="form-label">Sampai Tanggal</label>
                            <input type="date" id="sampai_tanggal" name="sampai_tanggal" class="form-control" value="{{ request('sampai_tanggal') }}">
                        </div>
                        <div class="col-md-2 d-flex">
                            <button type="submit" class="btn btn-success me-2 w-100">Terapkan</button>
                            <a href="{{ route('pengaduan.riwayat') }}" class="btn btn-secondary w-100">Reset</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- List pengaduan --}}
        <div class="list-pengaduan">
            @forelse($pengaduanList as $pengaduan)
                <div class="card shadow-sm mb-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <div>
                                <span class="fw-bold text-primary">{{ $pengaduan->kode_unik }}</span>
                                <span class="badge bg-{{ $pengaduan->status=='Menunggu Verifikasi'?'warning':($pengaduan->status=='Sedang Diproses'?'info':($pengaduan->status=='Selesai'?'success':'danger')) }}">
                                    {{ $pengaduan->status }}
                                </span>
                                <h4 class="h5 mt-1 mb-1">{{ $pengaduan->judul_pengaduan }}</h4>
                            </div>
                        </div>

                        <p class="text-muted">{{ Str::limit($pengaduan->isi_laporan, 150) }}</p>
                        <div class="d-flex flex-wrap small text-muted mb-3">
                            <span class="me-3">📅 {{ $pengaduan->created_at->format('d F Y') }}</span>
                            <span class="me-3">🏷️ {{ $pengaduan->kategori->nama }}</span>
                            <span>📍 {{ $pengaduan->lokasi_kejadian }}</span>
                        </div>

                        <a href="{{ route('pengaduan.show', $pengaduan->id) }}" class="btn btn-primary btn-sm">Lihat Detail</a>
                    </div>
                </div>
            @empty
                <div class="card text-center p-5">
                    <p class="text-muted mb-0">Anda belum membuat pengaduan apapun.</p>
                </div>
            @endforelse

            <div class="mt-4">
                {{ $pengaduanList->links() }}
            </div>
        </div>
    </div>
    @endsection
