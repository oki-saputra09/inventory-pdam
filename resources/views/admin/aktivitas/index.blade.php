<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Aktivitas - INVENDAM</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background: #f4f8fb;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .page-header {
            background: linear-gradient(135deg, #159bd8, #0d6f9d);
            color: #fff;
            border-radius: 22px;
            padding: 24px;
            margin-bottom: 24px;
        }

        .card-soft {
            background: #fff;
            border: 1px solid #e7edf2;
            border-radius: 20px;
            box-shadow: 0 10px 24px rgba(0,0,0,0.04);
            padding: 24px;
        }

        .table thead th {
            background: #f7fafc;
            color: #0d6f9d;
            font-weight: 700;
            white-space: nowrap;
        }
    </style>
</head>

<body>
    <div class="container py-5">
        <div class="page-header">
            <h3 class="fw-bold mb-1">Semua Aktivitas</h3>
            <p class="mb-0">Riwayat aktivitas admin pada sistem inventory.</p>
        </div>

        @if (session('success'))
            <div class="alert alert-success rounded-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="card-soft">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="fw-bold mb-0">Daftar Aktivitas</h5>

                <form action="{{ route('admin.aktivitas.destroy-all') }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus semua aktivitas?')">
                    @csrf
                    @method('DELETE')

                    <button type="submit" class="btn btn-danger btn-sm">
                        <i class="bi bi-trash"></i> Hapus Semua
                    </button>
                </form>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Waktu</th>
                            <th>User</th>
                            <th>Tipe</th>
                            <th>Aktivitas</th>
                            <th>Deskripsi</th>
                            <th width="100">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($aktivitas as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->created_at->format('d-m-Y H:i') }}</td>
                                <td>{{ $item->user->name ?? 'Sistem' }}</td>
                                <td>{{ $item->tipe ?? '-' }}</td>
                                <td>{{ $item->aktivitas }}</td>
                                <td>{{ $item->deskripsi ?? '-' }}</td>
                                <td>
                                    <form action="{{ route('admin.aktivitas.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus aktivitas ini?')">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="btn btn-outline-danger btn-sm">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4">
                                    Belum ada aktivitas.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <a href="{{ route('admin.dashboard') }}" class="btn btn-light mt-4">
                <i class="bi bi-arrow-left"></i> Kembali ke Dashboard
            </a>
        </div>
    </div>
</body>
</html>