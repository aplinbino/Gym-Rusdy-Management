<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Profil Admin | GYMBRO</title>
    <style>
        :root {
            --bg:#101510; --sidebar:#151e15; --panel:#192119; --panel2:#202b20;
            --line:#344233; --text:#f2f5ef; --muted:#a4afa0; --lime:#c8f169;
            --lime-soft:#2b3a1d; --red:#ffaaaa; --green:#b9e88b;
        }
        * { box-sizing:border-box; }
        body { margin:0; min-height:100vh; background:var(--bg); color:var(--text); font-family:Arial,Helvetica,sans-serif; }
        button,input { font:inherit; }
        .global-header { height:84px; width:100%; display:flex; align-items:center; justify-content:space-between; padding:0 12px; background:var(--sidebar); border-bottom:1px solid var(--line); }
        .global-brand { display:flex; align-items:center; gap:14px; color:var(--text); font-size:23px; font-weight:900; letter-spacing:2px; }
        .brand-mark { width:46px; height:46px; display:grid; place-items:center; border-radius:12px; background:var(--lime); color:#17200f; font-size:27px; font-weight:900; }
        .header-actions { display:flex; align-items:center; gap:16px; }
        .admin-label { color:var(--lime); font-size:13px; font-weight:900; letter-spacing:1.5px; }
        .header-logout { padding:13px 17px; background:#263326; border:1px solid var(--line); border-radius:9px; color:var(--text); font-size:13px; font-weight:700; cursor:pointer; }
        .header-logout:hover { border-color:var(--lime); color:var(--lime); }
        .layout { display:flex; min-height:calc(100vh - 84px); }
        .sidebar { width:250px; flex:0 0 250px; background:var(--sidebar); border-right:1px solid var(--line); padding:28px 18px; }
        .nav-title { color:#82907e; font-size:10px; font-weight:800; letter-spacing:1.5px; margin:10px 12px 12px; }
        .nav a { display:flex; align-items:center; gap:11px; padding:12px 14px; margin:4px 0; border-radius:9px; color:var(--muted); text-decoration:none; font-size:14px; font-weight:700; }
        .nav a:hover,.nav a.active { background:var(--lime-soft); color:var(--lime); }
        main { flex:1; min-width:0; padding:34px clamp(18px,4vw,52px); }
        .page-heading { margin-bottom:26px; }
        .eyebrow { color:var(--lime); font-size:11px; font-weight:900; letter-spacing:2px; }
        h1 { font-size:clamp(25px,3vw,34px); margin:9px 0 7px; }
        .subtitle { color:var(--muted); margin:0; font-size:14px; line-height:1.6; }
        .profile-grid { display:grid; grid-template-columns:minmax(0,1fr) minmax(0,1fr); gap:20px; align-items:start; }
        .card { background:var(--panel); border:1px solid var(--line); border-radius:15px; padding:24px; }
        .card h2 { margin:0 0 7px; font-size:19px; }
        .card-description { color:var(--muted); font-size:13px; line-height:1.5; margin:0 0 23px; }
        .field { margin-bottom:17px; }
        label { display:block; color:#dce5d7; font-size:12px; font-weight:800; margin-bottom:8px; }
        input { width:100%; padding:13px 14px; border:1px solid var(--line); border-radius:9px; background:#111811; color:var(--text); outline:none; }
        input:focus { border-color:var(--lime); box-shadow:0 0 0 3px rgba(200,241,105,.10); }
        input[readonly] { color:var(--muted); cursor:not-allowed; }
        .hint { color:var(--muted); font-size:11px; margin-top:7px; }
        .btn { border:0; border-radius:9px; padding:12px 17px; background:var(--lime); color:#17200f; font-weight:900; cursor:pointer; }
        .btn:hover { filter:brightness(1.06); }
        .alert { padding:12px 14px; border-radius:9px; margin-bottom:17px; font-size:13px; line-height:1.5; }
        .success { background:#20331c; border:1px solid #49643b; color:var(--green); }
        .error { background:#351d1d; border:1px solid #704040; color:var(--red); }
        .error ul { margin:6px 0 0; padding-left:18px; }
        .account-chip { display:inline-flex; align-items:center; gap:8px; border:1px solid var(--line); background:var(--panel2); border-radius:999px; padding:8px 12px; color:var(--lime); font-size:11px; font-weight:800; margin-top:15px; }
        @media(max-width:900px) { .profile-grid { grid-template-columns:1fr; } }
        @media(max-width:620px) {
            .global-header { height:72px; padding:0 12px; }
            .global-brand { font-size:18px; gap:9px; }
            .brand-mark { width:40px; height:40px; }
            .admin-label { font-size:10px; letter-spacing:.8px; }
            .header-actions { gap:8px; }
            .header-logout { padding:10px 11px; font-size:11px; }
            .layout { display:block; }
            .sidebar { width:100%; padding:16px; border-right:0; border-bottom:1px solid var(--line); }
            .nav { display:flex; gap:4px; overflow-x:auto; }
            .nav-title { display:none; }
            .nav a { white-space:nowrap; padding:9px 10px; }
            main { padding:24px 15px; }
            .card { padding:19px; }
        }
    </style>
</head>
<body>
<header class="global-header">
    <div class="global-brand"><span class="brand-mark">G</span><span>GYMBRO</span></div>
    <div class="header-actions">
        <span class="admin-label">ADMINISTRATOR</span>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="header-logout" type="submit">Logout ↗</button>
        </form>
    </div>
</header>

<div class="layout">
    <aside class="sidebar">
        <div class="nav-title">MENU UTAMA</div>
        <nav class="nav">
            <a href="{{ url('/admin/dashboard') }}">▦ &nbsp; Dashboard</a>
            <a href="{{ url('/tabel_user') }}">♙ &nbsp; Data Member</a>
            <a href="{{ url('/tabel_pt') }}">✦ &nbsp; Data Personal Trainer</a>
            <a href="{{ url('/tabel_schedule') }}">▦ &nbsp; Jadwal Latihan</a>
            <a href="{{ url('/tabel_transaction') }}">▤ &nbsp; Transaksi</a>
            <a class="active" href="{{ route('admin.profile.edit') }}">⚙ &nbsp; Profil Admin</a>
        </nav>
    </aside>

    <main>
        <header class="page-heading">
            <div class="eyebrow">ADMIN / PENGATURAN AKUN</div>
            <h1>Profil Admin</h1>
            <p class="subtitle">Kelola informasi pribadi dan keamanan akun administrator GYMBRO.</p>
            <div class="account-chip">● AKUN ADMINISTRATOR</div>
        </header>

        @if (session('profile_success'))
            <div class="alert success">{{ session('profile_success') }}</div>
        @endif
        @if (session('password_success'))
            <div class="alert success">{{ session('password_success') }}</div>
        @endif
        @if ($errors->any())
            <div class="alert error">
                <strong>Periksa kembali data yang kamu masukkan.</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <section class="profile-grid">
            <div class="card">
                <h2>Informasi Profil</h2>
                <p class="card-description">Perbarui nama dan alamat email yang digunakan pada akun admin.</p>
                <form method="POST" action="{{ route('admin.profile.update') }}">
                    @csrf
                    @method('PUT')
                    <div class="field">
                        <label for="name">Nama Admin</label>
                        <input id="name" name="name" type="text" value="{{ old('name', $admin->name) }}" maxlength="255" required>
                    </div>
                    <div class="field">
                        <label for="email">Alamat Email</label>
                        <input id="email" name="email" type="email" value="{{ old('email', $admin->email) }}" maxlength="255" required>
                    </div>
                    <div class="field">
                        <label>Role Akun</label>
                        <input type="text" value="Administrator" readonly>
                        <div class="hint">Role akun tidak dapat diubah dari halaman ini.</div>
                    </div>
                    <button class="btn" type="submit">Simpan Perubahan</button>
                </form>
            </div>

            <div class="card">
                <h2>Keamanan Akun</h2>
                <p class="card-description">Gunakan password saat ini untuk memverifikasi perubahan password baru.</p>
                <form method="POST" action="{{ route('admin.password.update') }}">
                    @csrf
                    @method('PUT')
                    <div class="field">
                        <label for="current_password">Password Saat Ini</label>
                        <input id="current_password" name="current_password" type="password" autocomplete="current-password" required>
                    </div>
                    <div class="field">
                        <label for="password">Password Baru</label>
                        <input id="password" name="password" type="password" autocomplete="new-password" minlength="8" required>
                        <div class="hint">Minimal 8 karakter.</div>
                    </div>
                    <div class="field">
                        <label for="password_confirmation">Konfirmasi Password Baru</label>
                        <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" minlength="8" required>
                    </div>
                    <button class="btn" type="submit">Perbarui Password</button>
                </form>
            </div>
        </section>
    </main>
</div>
</body>
</html>
