<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pengembalian - Admin INVENDAM</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        :root {
            --primary-dark: #0d6f9d;
            --primary-mid: #159bd8;
            --primary-soft: #e9f7fd;
            --bg: #f4f8fb;
            --text: #24323d;
            --muted: #6c7a86;
            --border: #e7edf2;
            --success: #198754;
            --success-soft: #eefbf3;
            --warning: #b7791f;
            --warning-soft: #fff8e8;
            --danger: #dc3545;
            --danger-soft: #fff1f1;
            --soft-shadow: 0 10px 28px rgba(15, 95, 134, 0.07);
        }

        * { box-sizing: border-box; }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background:
                radial-gradient(circle at top right, rgba(134, 182, 246, 0.20), transparent 30%),
                linear-gradient(180deg, #f8fbff 0%, var(--bg) 100%);
            color: var(--text);
            margin: 0;
        }

        .page-wrap {
            max-width: 860px;
            margin: 0 auto;
            padding: 26px 18px 60px;
        }

        .topbar {
            background: rgba(255,255,255,0.96);
            border: 1px solid var(--border);
            border-radius: 22px;
            padding: 18px 22px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 14px;
            box-shadow: var(--soft-shadow);
            margin-bottom: 22px;
            flex-wrap: wrap;
        }

        .topbar h3 {
            margin: 0;
            font-size: 1.3rem;
            font-weight: 900;
            color: var(--primary-dark);
        }

        .btn-back {
            border: 1px solid #dce8ef;
            background: #fff;
            color: var(--primary-dark);
            border-radius: 14px;
            padding: 10px 16px;
            font-weight: 800;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-back:hover {
            background: var(--primary-soft);
            color: var(--primary-dark);
        }

        .detail-card {
            background: rgba(255,255,255,0.98);
            border: 1px solid var(--border);
            border-radius: 22px;
            box-shadow: var(--soft-shadow);
            overflow: hidden;
        }

        .detail-head {
            padding: 18px 22px;
            border-bottom: 1px solid #edf2f7;
            background: linear-gradient(180deg, #ffffff 0%, #fbfdff 100%);
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
        }

        .detail-head h5 {
            margin: 0;
            font-weight: 900;
            color: var(--primary-dark);
        }

        .badge-status {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            border-radius: 999px;
            padding: 8px 14px;
            font-size: .8rem;
            font-weight: 900;
        }

        .status-menunggu { background: var(--warning-soft); color: var(--warning); }
        .status-disetujui { background: var(--success-soft); color: var(--success); }
        .status-ditolak { background: var(--danger-soft); color: var(--danger); }

        .detail-body {
            padding: 22px;
        }

        .detail-row {
            display: flex;
            gap: 14px;
            padding: 13px 0;
            border-bottom: 1px solid #f1f5f9;
        }

        .detail-row:last-child {
            border-bottom: none;
        }

        .detail-label {
            width: 190px;
            flex-shrink: 0;
            color: var(--muted);
            font-weight: 800;
            font-size: .9rem;
        }

        .detail-value {
            font-weight: 700;
        }

        .foto-bukti-besar {
            max-width: 100%;
            width: 420px;
            border-radius: 18px;
            border: 1px solid var(--border);
            box-shadow: var(--soft-shadow);
            display: block;
        }

        .foto-hint {
            color: var(--muted);
            font-size: .84rem;
            margin-top: 8px;
        }

        .verif-bar {
            padding: 18px 22px;
            border-top: 1px solid #edf2f7;
            background: #fbfdff;
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .btn-setuju {
            border: none;
            background: linear-gradient(135deg, #23a25d, var(--success));
            color: #fff;
            border-radius: 14px;
            padding: 11px 20px;
            font-weight: 900;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
        }

        .btn-setuju:hover { transform: translateY(-1px); }

        .btn-tolak {
            border: none;
            background: linear-gradient(135deg, #e4576a, var(--danger));
            color: #fff;
            border-radius: 14px;
            padding: 11px 20px;
            font-weight: 900;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
        }

        .btn-tolak:hover { transform: translateY(-1px); }

        .info-processed {
            color: var(--muted);
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        @media (max-width: 576px) {
            .detail-row {
                flex-direction: column;
                gap: 4px;
            }

            .detail-label {
                width: auto;
            }

            .btn-setuju,
            .btn-tolak {
                flex: 1;
                justify-content: center;
            }
        }
    </style>
</head>

<body>
<div class="page-wrap">

    <div class="topbar">
        <h3><i class="bi bi-eye me-1"></i> Detail Pengembalian</h3>

        <a href="{{ route('admin.pengembalian-barang.index') }}" class="btn-back">
            <i class="bi bi-arrow-left"></i>
            Kembali
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success rounded-4 fw-bold">
            <i class="bi bi-check-circle-fill me-1"></i>
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger rounded-4 fw-bold">
            <i class="bi bi-x-circle-fill me-1"></i>
            {{ session('error') }}
        </div>
    @endif

    @php
        $status = strtolower(trim($pengembalianBarang->status ?? ''));
    @endphp

    <div class="detail-card">
        <div class="detail-head">
            <h5>Pengembalian #{{ $pengembalianBarang->id }}</h5>

            @if($status === 'menunggu')
                <span class="badge-status status-menunggu">
                    <i class="bi bi-hourglass-split"></i> Menunggu
                </span>
            @elseif($status === 'disetujui')
                <span class="badge-status status-disetujui">
                    <i class="bi bi-check2-circle"></i> Disetujui
                </span>
            @elseif($status === 'ditolak')
                <span class="badge-status status-ditolak">
                    <i class="bi bi-x-circle"></i> Ditolak
                </span>
            @endif
        </div>

        <div class="detail-body">
            <div class="detail-row">
                <div class="detail-label">Diajukan Oleh</div>
                <div class="detail-value">
                    {{ $pengembalianBarang->user->name ?? '-' }}
                </div>
            </div>

            <div class="detail-row">
                <div class="detail-label">Tanggal Pengembalian</div>
                <div class="detail-value">
                    {{ $pengembalianBarang->tanggal_pengembalian ? \Carbon\Carbon::parse($pengembalianBarang->tanggal_pengembalian)->format('d-m-Y') : '-' }}
                </div>
            </div>

            <div class="detail-row">
                <div class="detail-label">Nama Barang</div>
                <div class="detail-value">
                    {{ $pengembalianBarang->barang->nama_barang ?? '-' }}
                </div>
            </div>

            <div class="detail-row">
                <div class="detail-label">Kode Barang</div>
                <div class="detail-value">
                    {{ $pengembalianBarang->barang->kode_barang ?? '-' }}
                </div>
            </div>

            <div class="detail-row">
                <div class="detail-label">Jumlah Dikembalikan</div>
                <div class="detail-value">
                    {{ $pengembalianBarang->jumlah }} {{ $pengembalianBarang->barang->satuan ?? '' }}
                </div>
            </div>

            <div class="detail-row">
                <div class="detail-label">Stok Barang Saat Ini</div>
                <div class="detail-value">
                    {{ $pengembalianBarang->barang->stok ?? '-' }} {{ $pengembalianBarang->barang->satuan ?? '' }}
                </div>
            </div>

            <div class="detail-row">
                <div class="detail-label">Keterangan</div>
                <div class="detail-value">
                    {{ $pengembalianBarang->keterangan ?: '-' }}
                </div>
            </div>

            <div class="detail-row">
                <div class="detail-label">Foto Bukti</div>
                <div class="detail-value" style="flex: 1;">
                    @if ($pengembalianBarang->foto_bukti)
                        <a href="{{ asset($pengembalianBarang->foto_bukti) }}" target="_blank">
                            <img src="{{ asset($pengembalianBarang->foto_bukti) }}"
                                 alt="Foto Bukti Pengembalian"
                                 class="foto-bukti-besar">
                        </a>
                        <div class="foto-hint">
                            <i class="bi bi-zoom-in"></i>
                            Klik foto untuk membuka ukuran penuh di tab baru.
                        </div>
                    @else
                        <span style="color: var(--muted);">Staf belum mengunggah foto bukti.</span>
                    @endif
                </div>
            </div>
        </div>

        <div class="verif-bar">
            @if($status === 'menunggu')
                <form action="{{ route('admin.pengembalian-barang.setuju', $pengembalianBarang->id) }}"
                      method="POST"
                      onsubmit="return confirm('Setujui pengembalian ini? Stok barang akan bertambah {{ $pengembalianBarang->jumlah }}.');"
                      class="m-0">
                    @csrf
                    @method('PUT')

                    <button type="submit" class="btn-setuju">
                        <i class="bi bi-check2-circle"></i>
                        Setujui Pengembalian
                    </button>
                </form>

                <form action="{{ route('admin.pengembalian-barang.tolak', $pengembalianBarang->id) }}"
                      method="POST"
                      onsubmit="return confirm('Tolak pengembalian ini?');"
                      class="m-0">
                    @csrf
                    @method('PUT')

                    <button type="submit" class="btn-tolak">
                        <i class="bi bi-x-circle"></i>
                        Tolak
                    </button>
                </form>
            @else
                <div class="info-processed">
                    <i class="bi bi-info-circle"></i>
                    Pengembalian ini sudah diproses ({{ $pengembalianBarang->status }}).
                </div>
            @endif
        </div>
    </div>

</div>
</body>
</html>