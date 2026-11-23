<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#101510">
    <title>Dashboard Admin | GYMBRO</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        :root {
            --bg: #101510;
            --sidebar: #151e15;
            --panel: #192119;
            --panel-hover: #202c20;
            --border: #344233;
            --lime: #c8f169;
            --text: #f4f6ef;
            --muted: #aab4a7;
            --danger: #ef6868;
        }
        body { min-height: 100vh; background: var(--bg); color: var(--text); font-family: Arial, Helvetica, sans-serif; }
        button, a { font: inherit; }
        .topbar {
            height: 70px; position: sticky; top: 0; z-index: 20;
            display: flex; align-items: center; justify-content: space-between;
            padding: 0 28px; background: var(--sidebar); border-bottom: 1px solid var(--border);
        }
        .brand { display: flex; align-items: center; gap: 12px; color: var(--text); font-size: 19px; font-weight: 900; letter-spacing: 2px; }
        .brand-mark { width: 38px; height: 38px; display: grid; place-items: center; border-radius: 9px; background: var(--lime); color: var(--bg); font-size: 22px; }
        .topbar-right { display: flex; align-items: center; gap: 18px; }
        .admin-label { color: var(--lime); font-size: 12px; font-weight: 700; letter-spacing: 1px; }
        .logout-button { padding: 10px 14px; border: 1px solid var(--border); border-radius: 7px; background: #263226; color: var(--text); cursor: pointer; font-size: 12px; font-weight: 700; }
        .logout-button:hover { border-color: var(--lime); color: var(--lime); }
        .menu-toggle { display: none; border: 0; background: transparent; color: var(--text); font-size: 25px; cursor: pointer; }
        .layout { display: flex; min-height: calc(100vh - 70px); }
        .sidebar { width: 250px; flex: 0 0 250px; padding: 25px 15px; background: var(--sidebar); border-right: 1px solid var(--border); }
        .sidebar-title { margin: 8px 10px 12px; color: #82907e; font-size: 10px; font-weight: 800; letter-spacing: 1.5px; }
        .nav-link { display: flex; align-items: center; gap: 12px; margin-bottom: 6px; padding: 13px 12px; border-radius: 8px; color: var(--muted); text-decoration: none; font-size: 13px; transition: .2s; }
        .nav-link:hover, .nav-link.active { background: #293b25; color: var(--lime); }
        .nav-link.active { font-weight: 700; }
        .nav-icon { width: 20px; text-align: center; font-size: 16px; }
        main { min-width: 0; flex: 1; padding: 35px; }
        .page-heading { margin-bottom: 27px; }
        .eyebrow { color: var(--lime); font-size: 10px; font-weight: 800; letter-spacing: 2px; }
        h1 { margin: 9px 0; font-size: 29px; }
        .page-heading p { color: var(--muted); font-size: 13px; line-height: 1.6; }
        .stats { display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); gap: 16px; margin-bottom: 22px; }
        .stat-card { position: relative; overflow: hidden; min-height: 132px; padding: 21px; border: 1px solid var(--border); border-radius: 12px; background: var(--panel); }
        .stat-card::after { position: absolute; right: -18px; bottom: -38px; width: 105px; height: 105px; border: 1px solid rgba(200,241,105,.12); border-radius: 50%; content: ''; }
        .stat-label { color: var(--muted); font-size: 12px; }
        .stat-value { margin-top: 15px; color: var(--lime); font-size: 31px; font-weight: 800; }
        .stat-note { margin-top: 7px; color: #82907e; font-size: 10px; }
        .content-grid { display: grid; grid-template-columns: 1.15fr 1fr; gap: 18px; align-items: start; }
        .panel { min-width: 0; margin-bottom: 20px; padding: 21px; border: 1px solid var(--border); border-radius: 12px; background: var(--panel); }
        .panel-header { display: flex; align-items: center; justify-content: space-between; gap: 12px; margin-bottom: 18px; }
        .panel-header h2 { font-size: 16px; }
        .panel-header span { color: var(--muted); font-size: 11px; }
        .table-wrap { overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; min-width: 440px; }
        th { padding: 12px 10px; background: #111a11; color: var(--lime); text-align: left; font-size: 10px; letter-spacing: .5px; white-space: nowrap; }
        td { padding: 13px 10px; border-bottom: 1px solid #303b30; color: #e2e9df; font-size: 11px; white-space: nowrap; }
        tbody tr:hover { background: var(--panel-hover); }
        .status { display: inline-block; padding: 5px 9px; border-radius: 20px; font-size: 9px; font-weight: 800; }
        .status.success { background: #304326; color: var(--lime); }
        .status.pending { background: #453b25; color: #f3c66d; }
        .status.failed { background: #462727; color: #ff8585; }
        .empty { padding: 25px; color: var(--muted); text-align: center; }
        .quick-info { display: grid; grid-template-columns: repeat(3, 1fr); gap: 12px; margin-top: 18px; }
        .quick-item { padding: 14px; border: 1px solid var(--border); border-radius: 9px; background: #151e15; }
        .quick-item small { display: block; color: var(--muted); font-size: 10px; }
        .quick-item strong { display: block; margin-top: 8px; color: var(--lime); font-size: 19px; }
        footer { padding: 20px; border-top: 1px solid var(--border); color: #82907e; text-align: center; font-size: 10px; }
        @media (max-width: 1100px) { .stats { grid-template-columns: repeat(2, 1fr); } .content-grid { grid-template-columns: 1fr; } }
        @media (max-width: 700px) {
            .topbar { padding: 0 16px; }
            .menu-toggle { display: block; }
            .admin-label { display: none; }
            .sidebar { position: fixed; top: 70px; bottom: 0; left: -260px; z-index: 15; overflow-y: auto; transition: .25s; }
            .sidebar.open { left: 0; }
            main { padding: 25px 15px; }
            h1 { font-size: 24px; }
            .stats { gap: 10px; }
            .stat-card { min-height: 118px; padding: 15px; }
            .stat-value { font-size: 25px; }
            .panel { padding: 15px; }
            .quick-info { grid-template-columns: 1fr; }
        }
        @media (max-width: 380px) { .stats { grid-template-columns: 1fr; } }
    </style>
</head>
<body>
    <header class="topbar">
        <div class="brand"><span class="brand-mark">G</span> GYMBRO</div>
        <div class="topbar-right">
            <span class="admin-label">ADMINISTRATOR</span>
            <form action="{{ route('logout') }}" method="POST" onsubmit="return confirm('Yakin ingin logout?')">
                @csrf
                <button class="logout-button" type="submit">Logout ↗</button>
            </form>
            <button class="menu-toggle" type="button" onclick="toggleSidebar()" aria-label="Buka menu">☰</button>
        </div>
    </header>

    <div class="layout">
        <aside class="sidebar" id="sidebar">
            <div class="sidebar-title">MENU UTAMA</div>
            <a class="nav-link active" href="{{ route('admin.dashboard') }}"><span class="nav-icon">▦</span>Dashboard</a>
            <div class="sidebar-title">MANAJEMEN DATA</div>
            <a class="nav-link" href="{{ url('/tabel_user') }}"><span class="nav-icon">♙</span>Data Member</a>
            <a class="nav-link" href="{{ url('/tabel_pt') }}"><span class="nav-icon">✦</span>Personal Trainer</a>
            <a class="nav-link" href="{{ url('/tabel_schedule') }}"><span class="nav-icon">▦</span>Jadwal Latihan</a>
            <a class="nav-link" href="{{ url('/tabel_transaction') }}"><span class="nav-icon">▤</span>Data Transaksi</a>
            <a class="nav-link" href="{{ route('admin.profile.edit') }}"><span class="nav-icon">⚙</span>Profil Admin</a>
        </aside>

        <main>
            <section class="page-heading">
                <span class="eyebrow">ADMIN DASHBOARD</span>
                <h1>Selamat datang, {{ auth()->user()->name }}!</h1>
                <p>Pantau aktivitas dan kelola operasional GYMBRO dari satu halaman.</p>
            </section>

            <section class="stats">
                <article class="stat-card">
                    <div class="stat-label">Total Member</div>
                    <div class="stat-value">{{ number_format($totalMember, 0, ',', '.') }}</div>
                    <div class="stat-note">Seluruh akun dengan role member</div>
                </article>
                <article class="stat-card">
                    <div class="stat-label">Personal Trainer</div>
                    <div class="stat-value">{{ number_format($totalPt, 0, ',', '.') }}</div>
                    <div class="stat-note">Total profil PT terdaftar</div>
                </article>
                <article class="stat-card">
                    <div class="stat-label">Total Transaksi</div>
                    <div class="stat-value">{{ number_format($totalTransaksi, 0, ',', '.') }}</div>
                    <div class="stat-note">Seluruh transaksi yang tercatat</div>
                </article>
                <article class="stat-card">
                    <div class="stat-label">Membership Aktif</div>
                    <div class="stat-value">{{ number_format($membershipAktif, 0, ',', '.') }}</div>
                    <div class="stat-note">Member dengan status aktif</div>
                </article>
            </section>

            <section class="content-grid">
                <div class="panel">
                    <div class="panel-header">
                        <h2>Transaksi Terbaru</h2>
                        <span>5 transaksi terakhir</span>
                    </div>
                    <div class="table-wrap">
                        <table>
                            <thead><tr><th>ID</th><th>MEMBER</th><th>JENIS</th><th>TOTAL</th><th>STATUS</th></tr></thead>
                            <tbody>
                                @forelse ($transaksiTerbaru as $transaksi)
                                    @php
                                        $statusLabel = [
                                            'pending' => 'Menunggu',
                                            'approved' => 'Berhasil',
                                            'rejected' => 'Ditolak',
                                        ][$transaksi->status] ?? ucfirst($transaksi->status ?? '-');
                                        $statusClass = $transaksi->status === 'approved' ? 'success' : (in_array($transaksi->status, ['rejected', 'failed']) ? 'failed' : 'pending');
                                    @endphp
                                    <tr>
                                        <td>#{{ $transaksi->id }}</td>
                                        <td>{{ $transaksi->nama_member ?? 'Member tidak ditemukan' }}</td>
                                        <td>{{ ucfirst(str_replace('_', ' ', $transaksi->jenis_transaksi ?? '-')) }}</td>
                                        <td>Rp {{ number_format((float) $transaksi->total_harga, 0, ',', '.') }}</td>
                                        <td><span class="status {{ $statusClass }}">{{ $statusLabel }}</span></td>
                                    </tr>
                                @empty
                                    <tr><td colspan="5" class="empty">Belum ada transaksi.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="quick-info">
                        <div class="quick-item"><small>Transaksi berhasil</small><strong>{{ number_format($transaksiBerhasil, 0, ',', '.') }}</strong></div>
                        <div class="quick-item"><small>Jadwal aktif</small><strong>{{ number_format($jadwalAktif, 0, ',', '.') }}</strong></div>
                        <div class="quick-item"><small>Membership aktif</small><strong>{{ number_format($membershipAktif, 0, ',', '.') }}</strong></div>
                    </div>
                </div>

                <div class="panel">
                    <div class="panel-header">
                        <h2>Jadwal PT Terdekat</h2>
                        <span>5 Jadwal Terdekat</span>
                    </div>
                    <div class="table-wrap">
                        <table>
                            <thead><tr><th>MEMBER</th><th>PT</th><th>TANGGAL</th><th>JAM</th><th>STATUS</th></tr></thead>
                            <tbody>
                                @forelse ($jadwalTerbaru as $jadwal)
                                    @php
                                        $jadwalStatus = [
                                            'pending' => 'Menunggu',
                                            'approved' => 'Dikonfirmasi',
                                            'scheduled' => 'Terjadwal',
                                            'completed' => 'Selesai',
                                            'cancelled' => 'Dibatalkan',
                                        ][$jadwal->status] ?? ucfirst($jadwal->status ?? '-');
                                        $jadwalClass = in_array($jadwal->status, ['approved', 'completed']) ? 'success' : (in_array($jadwal->status, ['cancelled', 'rejected']) ? 'failed' : 'pending');
                                    @endphp
                                    <tr>
                                        <td>{{ $jadwal->nama_member ?? '-' }}</td>
                                        <td>{{ $jadwal->nama_pt ?? '-' }}</td>
                                        <td>{{ $jadwal->tanggal ? \Illuminate\Support\Carbon::parse($jadwal->tanggal)->format('d/m/Y') : '-' }}</td>
                                        <td>{{ $jadwal->jam ?? '-' }}</td>
                                        <td><span class="status {{ $jadwalClass }}">{{ $jadwalStatus }}</span></td>
                                    </tr>
                                @empty
                                    <tr><td colspan="5" class="empty">Belum ada jadwal PT.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>
        </main>
    </div>

    <footer>© {{ date('Y') }} GYMBRO FITNESS · Train Hard. Stay Humble. Keep Growing.</footer>

    <script>
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('open');
        }
    </script>
</body>
</html>
