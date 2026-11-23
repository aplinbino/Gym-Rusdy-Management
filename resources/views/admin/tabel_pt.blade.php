<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Manajemen PT | GYMBRO</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        :root {
            --bg: #101510;
            --sidebar: #151e15;
            --panel: #192119;
            --panel2: #202c20;
            --border: #344233;
            --lime: #c8f169;
            --text: #f4f6ef;
            --muted: #aab4a7;
            --red: #ef6868;
        }
        body { min-height: 100vh; background: var(--bg); color: var(--text); font-family: Arial, Helvetica, sans-serif; }
        button, input, textarea, select, a { font: inherit; }
        .topbar {
            height: 70px; position: sticky; top: 0; z-index: 20;
            display: flex; align-items: center; justify-content: space-between;
            padding: 0 26px; background: var(--sidebar); border-bottom: 1px solid var(--border);
        }
        .brand { display: flex; align-items: center; gap: 12px; color: var(--text); font-size: 19px; font-weight: 900; letter-spacing: 2px; }
        .brand-mark { width: 38px; height: 38px; display: grid; place-items: center; border-radius: 9px; background: var(--lime); color: var(--bg); font-size: 22px; }
        .topbar-right { display: flex; align-items: center; gap: 14px; }
        .admin-label { color: var(--lime); font-size: 12px; font-weight: 700; letter-spacing: 1px; }
        .logout-button { padding: 10px 14px; border: 1px solid var(--border); border-radius: 7px; background: #263226; color: var(--text); cursor: pointer; font-size: 12px; font-weight: 700; }
        .logout-button:hover { border-color: var(--lime); color: var(--lime); }
        .menu-toggle { display: none; border: 0; background: transparent; color: var(--text); font-size: 25px; cursor: pointer; }
        .layout { display: flex; min-height: calc(100vh - 70px); }
        .sidebar { width: 250px; flex: 0 0 250px; padding: 25px 15px; background: var(--sidebar); border-right: 1px solid var(--border); }
        .nav-title { margin: 18px 10px 12px; color: #82907e; font-size: 10px; font-weight: 800; letter-spacing: 1.5px; }
        .nav a { display: flex; align-items: center; gap: 12px; margin-bottom: 6px; padding: 13px 12px; border-radius: 8px; color: var(--muted); text-decoration: none; font-size: 13px; transition: .2s; }
        .nav a:hover, .nav a.active { background: #293b25; color: var(--lime); }
        .nav a.active { font-weight: 700; }
        main { min-width: 0; flex: 1; padding: 34px; }
        .page-heading {
            position: static;
            height: auto;
            min-height: 0;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            padding: 0 0 26px;
            margin: 0 0 24px;
            background: transparent;
            border: 0;
        }
        .eyebrow { color: var(--lime); font-size: 10px; font-weight: 800; letter-spacing: 2px; line-height: 1.4; }
        .page-heading h1 { margin: 9px 0 7px; font-size: 28px; line-height: 1.2; }
        .subtitle { color: var(--muted); font-size: 13px; line-height: 1.6; margin: 0; }
        .admin-chip { flex: 0 0 auto; color: var(--text); font-size: 13px; font-weight: 700; }
        .stats { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 14px; margin-bottom: 20px; }
        .stat { position: relative; overflow: hidden; min-height: 118px; padding: 18px 20px; border: 1px solid var(--border); border-radius: 12px; background: var(--panel); }
        .stat-label { color: var(--muted); font-size: 11px; }
        .stat-value { margin-top: 10px; color: var(--lime); font-size: 27px; font-weight: 800; }
        .content-card { padding: 22px; border: 1px solid var(--border); border-radius: 12px; background: var(--panel); }
        .toolbar { display: flex; align-items: center; justify-content: space-between; gap: 14px; flex-wrap: wrap; margin-bottom: 18px; }
        .toolbar h2 { font-size: 16px; margin: 0 0 5px; }
        .toolbar p { color: var(--muted); font-size: 11px; margin: 0; }
        .toolbar-actions { display: flex; gap: 9px; flex-wrap: wrap; }
        .search { min-width: 210px; background: #101710; border: 1px solid var(--border); color: var(--text); border-radius: 7px; padding: 11px 13px; outline: none; font-size: 12px; }
        .search:focus, .field input:focus, .field textarea:focus, .field select:focus { border-color: var(--lime); }
        .btn { border: 0; border-radius: 7px; padding: 10px 14px; cursor: pointer; font-weight: 700; font-size: 11px; transition: .2s; }
        .btn:hover { opacity: .86; transform: translateY(-1px); }
        .btn-primary { color: #101510; background: var(--lime); }
        .btn-secondary { background: #303b30; color: var(--text); }
        .btn-danger { background: #482727; color: #ff8888; }
        .table-wrap { width: 100%; overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; min-width: 760px; }
        th { padding: 13px 11px; background: #111a11; color: var(--lime); text-align: left; font-size: 10px; letter-spacing: .5px; white-space: nowrap; }
        td { padding: 14px 11px; border-bottom: 1px solid #303b30; color: #e2e9df; font-size: 11px; white-space: nowrap; }
        tbody tr:hover { background: var(--panel2); }
        .person { display: flex; align-items: center; gap: 11px; }
        .avatar { width: 38px; height: 38px; border-radius: 9px; display: grid; place-items: center; background: #304326; color: var(--lime); font-weight: 900; }
        .person strong { display: block; font-size: 12px; }
        .person small { color: var(--muted); display: block; margin-top: 4px; font-size: 10px; }
        .status { display: inline-block; padding: 5px 9px; border-radius: 20px; font-size: 9px; font-weight: 800; }
        .status.active { color: var(--lime); background: #304326; }
        .status.inactive { color: #ff8585; background: #462727; }
        .actions { display: flex; gap: 6px; }
        .icon-btn { border: 1px solid var(--border); color: var(--muted); background: #202c20; padding: 7px 9px; border-radius: 7px; cursor: pointer; font-size: 11px; }
        .icon-btn:hover { color: var(--lime); border-color: var(--lime); }
        .empty, .loading { text-align: center; color: var(--muted); padding: 30px; }
        .notice { display: none; margin-bottom: 15px; padding: 12px 14px; border-radius: 8px; font-size: 12px; white-space: pre-line; }
        .notice.success { display: block; color: #d6ffb0; background: #1c3218; border: 1px solid #36572a; }
        .notice.error { display: block; color: #ffb0b0; background: #3a2222; border: 1px solid #744040; }
        .modal-backdrop { display: none; position: fixed; inset: 0; z-index: 50; background: rgba(0,0,0,.76); padding: 18px; overflow-y: auto; align-items: center; justify-content: center; }
        .modal-backdrop.show { display: flex; }
        .modal { width: 100%; max-width: 510px; max-height: 90vh; overflow: auto; background: var(--panel); border: 1px solid var(--border); border-radius: 13px; padding: 24px; }
        .modal-head { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
        .modal-head h2 { margin: 0; font-size: 19px; }
        .close { background: transparent; color: var(--muted); border: 0; font-size: 25px; cursor: pointer; }
        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }
        .field { display: flex; flex-direction: column; gap: 7px; }
        .field.full { grid-column: 1 / -1; }
        .field label { color: var(--muted); font-size: 11px; }
        .field input, .field textarea, .field select { width: 100%; background: #101510; border: 1px solid var(--border); border-radius: 7px; color: var(--text); padding: 12px; outline: none; font-size: 12px; }
        .field textarea { min-height: 90px; resize: vertical; }
        .hint { color: var(--muted); font-size: 11px; }
        .modal-actions { display: flex; justify-content: flex-end; gap: 9px; margin-top: 20px; }
        .detail-list { display: grid; grid-template-columns: 130px 1fr; gap: 13px; font-size: 12px; }
        .detail-list dt { color: var(--muted); }
        .detail-list dd { margin: 0; overflow-wrap: anywhere; }
        @media (max-width: 1100px) { .stats { grid-template-columns: repeat(2, minmax(0, 1fr)); } }
        @media (max-width: 700px) {
            .topbar { padding: 0 16px; }
            .menu-toggle { display: block; }
            .admin-label { display: none; }
            .sidebar { position: fixed; top: 70px; bottom: 0; left: -260px; z-index: 15; overflow-y: auto; transition: .25s; }
            .sidebar.open { left: 0; }
            main { padding: 25px 15px; }
            h1 { font-size: 24px; }
            .content-card { padding: 15px; }
        }
        @media (max-width: 620px) {
            .stats { grid-template-columns: 1fr; gap: 10px; }
            .form-grid { grid-template-columns: 1fr; }
            .field.full { grid-column: auto; }
            .admin-chip { display: none; }
        }
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
        <div class="nav-title">MENU UTAMA</div>
        <nav class="nav">
            <a href="{{ route('admin.dashboard') }}">▦ &nbsp; Dashboard</a>
            <a href="{{ url('/tabel_user') }}">♙ &nbsp; Data Member</a>
            <a class="active" href="{{ url('/tabel_pt') }}">✦ &nbsp; Personal Trainer</a>
            <a href="{{ url('/tabel_schedule') }}">▦ &nbsp; Jadwal Latihan</a>
            <a href="{{ url('/tabel_transaction') }}">▤ &nbsp; Data Transaksi</a>
            <a href="{{ route('admin.profile.edit') }}">⚙ &nbsp; Profil Admin</a>
        </nav>
    </aside>

    <main>
        <section class="page-heading">
            <div>
                <div class="eyebrow">ADMIN / PERSONAL TRAINER</div>
                <h1>Manajemen Personal Trainer</h1>
                <p class="subtitle">Kelola akun, profil, dan status Personal Trainer GYMBRO.</p>
            </div>
            <div class="admin-chip">Administrator</div>
        </section>

        <div id="notice" class="notice"></div>

        <section class="stats">
            <div class="stat">
                <div class="stat-label">Total Personal Trainer</div>
                <div class="stat-value" id="totalPt">—</div>
            </div>
            <div class="stat">
                <div class="stat-label">PT Aktif</div>
                <div class="stat-value"><span id="activePt">—</span></div>
            </div>
            <div class="stat">
                <div class="stat-label">PT Tidak Aktif</div>
                <div class="stat-value" id="inactivePt">—</div>
            </div>
        </section>

        <section class="content-card">
            <div class="toolbar">
                <div>
                    <h2>Daftar Personal Trainer</h2>
                    <p>Data diambil langsung dari database GYMBRO.</p>
                </div>
                <div class="toolbar-actions">
                    <input id="searchInput" class="search" type="search" placeholder="Cari nama, email, atau PT...">
                    <button class="btn btn-primary" type="button" onclick="openCreateModal()">＋ Tambah PT</button>
                </div>
            </div>
            <div class="table-wrap">
                <table>
                    <thead>
                    <tr>
                        <th>Personal Trainer</th>
                        <th>Nama Profil PT</th>
                        <th>No. Telepon</th>
                        <th>Harga / Sesi</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                    </thead>
                    <tbody id="ptTableBody">
                    <tr><td colspan="6" class="loading">Memuat data Personal Trainer...</td></tr>
                    </tbody>
                </table>
            </div>
        </section>
    </main>
</div>

<div class="modal-backdrop" id="ptModal">
    <section class="modal" role="dialog" aria-modal="true" aria-labelledby="modalTitle">
        <div class="modal-head">
            <h2 id="modalTitle">Tambah Personal Trainer</h2>
            <button class="close" type="button" onclick="closeModal()" aria-label="Tutup">&times;</button>
        </div>
        <form id="ptForm">
            <input type="hidden" id="ptId">
            <div class="form-grid">
                <div class="field">
                    <label for="name">Nama akun *</label>
                    <input id="name" name="name" required maxlength="255">
                </div>
                <div class="field">
                    <label for="pt_name">Nama profil PT *</label>
                    <input id="pt_name" name="pt_name" required maxlength="255">
                </div>
                <div class="field">
                    <label for="email">Email login *</label>
                    <input id="email" name="email" type="email" required maxlength="255">
                </div>
                <div class="field">
                    <label for="phone">Nomor telepon *</label>
                    <input id="phone" name="phone" required maxlength="20">
                </div>
                <div class="field full">
                    <label for="password">Password <span id="passwordRequired">*</span></label>
                    <input id="password" name="password" type="password" minlength="8" autocomplete="new-password">
                    <span class="hint" id="passwordHint">Minimal 8 karakter.</span>
                </div>
                <div class="field full">
                    <label for="description">Deskripsi PT</label>
                    <textarea id="description" name="description" placeholder="Tuliskan deskripsi atau pengalaman Personal Trainer..."></textarea>
                </div>
                <div class="field full" id="statusField" hidden>
                    <label for="status">Status PT</label>
                    <select id="status" name="status">
                        <option value="active">Aktif</option>
                        <option value="inactive">Tidak Aktif</option>
                    </select>
                </div>
            </div>
            <div class="modal-actions">
                <button class="btn btn-secondary" type="button" onclick="closeModal()">Batal</button>
                <button class="btn btn-primary" type="submit" id="saveButton">Simpan PT</button>
            </div>
        </form>
    </section>
</div>

<div class="modal-backdrop" id="detailModal">
    <section class="modal" role="dialog" aria-modal="true" aria-labelledby="detailTitle">
        <div class="modal-head">
            <h2 id="detailTitle">Detail Personal Trainer</h2>
            <button class="close" type="button" onclick="closeDetailModal()" aria-label="Tutup">&times;</button>
        </div>
        <dl class="detail-list" id="detailContent"></dl>
        <div class="modal-actions">
            <button class="btn btn-secondary" type="button" onclick="closeDetailModal()">Tutup</button>
        </div>
    </section>
</div>

<script>
    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
    const tableBody = document.getElementById('ptTableBody');
    const notice = document.getElementById('notice');
    let trainers = [];

    function escapeHtml(value) {
        return String(value ?? '').replace(/[&<>"']/g, char => ({
            '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;'
        }[char]));
    }

    function money(value) {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency', currency: 'IDR', maximumFractionDigits: 0
        }).format(Number(value || 0));
    }

    function showNotice(message, type = 'success') {
        notice.textContent = message;
        notice.className = `notice ${type}`;
        window.scrollTo({ top: 0, behavior: 'smooth' });
        setTimeout(() => { notice.className = 'notice'; }, 5000);
    }

    async function requestJson(url, options = {}) {
        const response = await fetch(url, {
            ...options,
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                ...(options.body instanceof FormData ? {} : { 'Content-Type': 'application/json' }),
                ...(options.headers || {})
            }
        });

        const data = await response.json().catch(() => ({}));
        if (!response.ok) {
            const errors = data.errors ? Object.values(data.errors).flat().join('\n') : null;
            throw new Error(errors || data.message || `Request gagal (${response.status}).`);
        }
        return data;
    }

    async function loadTrainers() {
        tableBody.innerHTML = '<tr><td colspan="6" class="loading">Memuat data Personal Trainer...</td></tr>';
        try {
            const data = await requestJson('{{ route('admin.pt.index') }}');
            trainers = Array.isArray(data) ? data : (data.data || []);
            renderTrainers();
        } catch (error) {
            tableBody.innerHTML = `<tr><td colspan="6" class="empty">${escapeHtml(error.message)}</td></tr>`;
            showNotice(error.message, 'error');
        }
    }

    function renderTrainers() {
        const keyword = document.getElementById('searchInput').value.toLowerCase().trim();
        const filtered = trainers.filter(pt => {
            const user = pt.user || {};
            return [user.name, user.email, user.phone, pt.pt_name, pt.description]
                .some(value => String(value || '').toLowerCase().includes(keyword));
        });

        document.getElementById('totalPt').textContent = trainers.length;
        document.getElementById('activePt').textContent = trainers.filter(pt => pt.status === 'active').length;
        document.getElementById('inactivePt').textContent = trainers.filter(pt => pt.status !== 'active').length;

        if (!filtered.length) {
            tableBody.innerHTML = `<tr><td colspan="6" class="empty">${trainers.length ? 'Data tidak ditemukan.' : 'Belum ada Personal Trainer. Klik Tambah PT untuk membuat akun.'}</td></tr>`;
            return;
        }

        tableBody.innerHTML = filtered.map(pt => {
            const user = pt.user || {};
            const initial = escapeHtml((user.name || pt.pt_name || 'P').trim().charAt(0).toUpperCase());
            const status = pt.status === 'active' ? 'active' : 'inactive';
            const statusLabel = status === 'active' ? 'Aktif' : 'Tidak Aktif';
            return `
                <tr>
                    <td>
                        <div class="person">
                            <div class="avatar">${initial}</div>
                            <div>
                                <strong>${escapeHtml(user.name || '-')}</strong>
                                <small>${escapeHtml(user.email || '-')}</small>
                            </div>
                        </div>
                    </td>
                    <td>${escapeHtml(pt.pt_name || '-')}</td>
                    <td>${escapeHtml(user.phone || '-')}</td>
                    <td>${money(pt.price_per_session)}</td>
                    <td><span class="status ${status}">${statusLabel}</span></td>
                    <td>
                        <div class="actions">
                            <button class="icon-btn" type="button" onclick="showDetail(${Number(pt.id)})">Detail</button>
                            <button class="icon-btn" type="button" onclick="openEditModal(${Number(pt.id)})">Edit</button>
                            <button class="icon-btn" type="button" onclick="deleteTrainer(${Number(pt.id)})">Hapus</button>
                        </div>
                    </td>
                </tr>`;
        }).join('');
    }

    function openCreateModal() {
        document.getElementById('ptForm').reset();
        document.getElementById('ptId').value = '';
        document.getElementById('modalTitle').textContent = 'Tambah Personal Trainer';
        document.getElementById('password').required = true;
        document.getElementById('passwordRequired').hidden = false;
        document.getElementById('passwordHint').textContent = 'Minimal 8 karakter.';
        document.getElementById('statusField').hidden = true;
        document.getElementById('saveButton').textContent = 'Simpan PT';
        document.getElementById('ptModal').classList.add('show');
    }

    function openEditModal(id) {
        const pt = trainers.find(item => Number(item.id) === Number(id));
        if (!pt) return;
        const user = pt.user || {};
        document.getElementById('ptForm').reset();
        document.getElementById('ptId').value = pt.id;
        document.getElementById('name').value = user.name || '';
        document.getElementById('pt_name').value = pt.pt_name || '';
        document.getElementById('email').value = user.email || '';
        document.getElementById('phone').value = user.phone || '';
        document.getElementById('description').value = pt.description || '';
        document.getElementById('status').value = pt.status || 'active';
        document.getElementById('password').required = false;
        document.getElementById('passwordRequired').hidden = true;
        document.getElementById('passwordHint').textContent = 'Kosongkan jika password tidak ingin diubah.';
        document.getElementById('statusField').hidden = false;
        document.getElementById('modalTitle').textContent = 'Edit Personal Trainer';
        document.getElementById('saveButton').textContent = 'Simpan Perubahan';
        document.getElementById('ptModal').classList.add('show');
    }

    function closeModal() {
        document.getElementById('ptModal').classList.remove('show');
    }

    function showDetail(id) {
        const pt = trainers.find(item => Number(item.id) === Number(id));
        if (!pt) return;
        const user = pt.user || {};
        const rows = [
            ['Nama akun', user.name], ['Nama profil PT', pt.pt_name], ['Email', user.email],
            ['Nomor telepon', user.phone], ['Harga per sesi', money(pt.price_per_session)],
            ['Status', pt.status === 'active' ? 'Aktif' : 'Tidak Aktif'],
            ['Deskripsi', pt.description || 'Belum ada deskripsi']
        ];
        document.getElementById('detailContent').innerHTML = rows.map(([label, value]) =>
            `<dt>${escapeHtml(label)}</dt><dd>${escapeHtml(value || '-')}</dd>`
        ).join('');
        document.getElementById('detailModal').classList.add('show');
    }

    function closeDetailModal() {
        document.getElementById('detailModal').classList.remove('show');
    }

    document.getElementById('ptForm').addEventListener('submit', async event => {
        event.preventDefault();
        const id = document.getElementById('ptId').value;
        const payload = {
            name: document.getElementById('name').value.trim(),
            pt_name: document.getElementById('pt_name').value.trim(),
            email: document.getElementById('email').value.trim(),
            phone: document.getElementById('phone').value.trim(),
            password: document.getElementById('password').value,
            description: document.getElementById('description').value.trim()
        };

        if (id) payload.status = document.getElementById('status').value;
        if (id && !payload.password) delete payload.password;

        const button = document.getElementById('saveButton');
        button.disabled = true;
        button.textContent = 'Menyimpan...';
        try {
            await requestJson(id ? `/admin/pt/${id}` : '{{ route('admin.pt.store') }}', {
                method: id ? 'PUT' : 'POST',
                body: JSON.stringify(payload)
            });
            closeModal();
            showNotice(id ? 'Data Personal Trainer berhasil diperbarui.' : 'Personal Trainer berhasil ditambahkan.');
            await loadTrainers();
        } catch (error) {
            showNotice(error.message, 'error');
        } finally {
            button.disabled = false;
            button.textContent = id ? 'Simpan Perubahan' : 'Simpan PT';
        }
    });

    async function deleteTrainer(id) {
        const pt = trainers.find(item => Number(item.id) === Number(id));
        const label = pt?.pt_name || pt?.user?.name || 'Personal Trainer ini';
        if (!confirm(`Yakin ingin menghapus ${label}? Akun login PT terkait juga akan dihapus.`)) return;

        try {
            await requestJson(`/admin/pt/${id}`, { method: 'DELETE' });
            showNotice('Personal Trainer berhasil dihapus.');
            await loadTrainers();
        } catch (error) {
            showNotice(error.message, 'error');
        }
    }

    document.getElementById('searchInput').addEventListener('input', renderTrainers);
    document.getElementById('ptModal').addEventListener('click', event => {
        if (event.target.id === 'ptModal') closeModal();
    });
    document.getElementById('detailModal').addEventListener('click', event => {
        if (event.target.id === 'detailModal') closeDetailModal();
    });

    function toggleSidebar() {
        document.getElementById('sidebar').classList.toggle('open');
    }

    loadTrainers();
</script>
</body>
</html>
