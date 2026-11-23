<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Manajemen Member | GYMBRO</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        :root { --bg:#101510; --sidebar:#151e15; --panel:#192119; --panel2:#202c20; --border:#344233; --lime:#c8f169; --text:#f4f6ef; --muted:#aab4a7; --red:#ef6868; }
        body { min-height:100vh; background:var(--bg); color:var(--text); font-family:Arial,Helvetica,sans-serif; }
        button,input { font:inherit; }
        .topbar { height:70px; position:sticky; top:0; z-index:20; display:flex; align-items:center; justify-content:space-between; padding:0 26px; background:var(--sidebar); border-bottom:1px solid var(--border); }
        .brand { display:flex; align-items:center; gap:12px; font-size:19px; font-weight:900; letter-spacing:2px; }
        .brand-mark { width:38px; height:38px; display:grid; place-items:center; border-radius:9px; background:var(--lime); color:var(--bg); font-size:22px; }
        .top-actions { display:flex; align-items:center; gap:14px; }
        .admin-label { color:var(--lime); font-size:12px; font-weight:bold; letter-spacing:1px; }
        .logout { padding:10px 14px; border:1px solid var(--border); border-radius:7px; background:#263226; color:var(--text); cursor:pointer; font-size:12px; }
        .menu-toggle { display:none; border:0; background:none; color:white; font-size:25px; cursor:pointer; }
        .layout { display:flex; min-height:calc(100vh - 70px); }
        .sidebar { width:250px; flex:0 0 250px; padding:24px 15px; background:var(--sidebar); border-right:1px solid var(--border); }
        .menu-label { margin:18px 10px 10px; color:#82907e; font-size:10px; font-weight:bold; letter-spacing:1.5px; }
        .nav-link { display:flex; align-items:center; gap:12px; margin-bottom:5px; padding:13px 12px; border-radius:8px; color:var(--muted); text-decoration:none; font-size:13px; }
        .nav-link:hover,.nav-link.active { background:#293b25; color:var(--lime); }
        .nav-link.active { font-weight:bold; }
        main { flex:1; min-width:0; padding:34px; }
        .heading { margin-bottom:25px; }
        .heading small { color:var(--lime); font-size:10px; font-weight:bold; letter-spacing:2px; }
        .heading h1 { margin:9px 0; font-size:28px; }
        .heading p { color:var(--muted); font-size:13px; line-height:1.6; }
        .summary { display:grid; grid-template-columns:repeat(3,minmax(0,1fr)); gap:14px; margin-bottom:20px; }
        .summary-card,.card { border:1px solid var(--border); border-radius:12px; background:var(--panel); }
        .summary-card { padding:18px 20px; }
        .summary-card small { color:var(--muted); font-size:11px; }
        .summary-card strong { display:block; margin-top:10px; color:var(--lime); font-size:27px; }
        .card { padding:22px; }
        .card-header { display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:14px; margin-bottom:18px; }
        .card-header h2 { font-size:16px; }
        .toolbar { display:flex; gap:9px; flex-wrap:wrap; }
        .search,.filter { min-width:190px; padding:11px 13px; border:1px solid var(--border); border-radius:7px; outline:none; background:#101710; color:white; font-size:12px; }
        .search:focus,.filter:focus,.field input:focus { border-color:var(--lime); }
        .btn { padding:10px 14px; border:0; border-radius:7px; cursor:pointer; font-size:11px; font-weight:bold; transition:.2s; }
        .btn:hover { opacity:.86; transform:translateY(-1px); }
        .btn-primary { background:var(--lime); color:#101510; }
        .btn-secondary { background:#303b30; color:white; }
        .btn-edit { background:#354b2d; color:var(--lime); }
        .btn-delete { background:#482727; color:#ff8888; }
        .table-wrap { width:100%; overflow-x:auto; }
        table { width:100%; min-width:850px; border-collapse:collapse; }
        th { padding:13px 11px; background:#111a11; color:var(--lime); text-align:left; font-size:10px; letter-spacing:.5px; white-space:nowrap; }
        td { padding:14px 11px; border-bottom:1px solid #303b30; color:#e2e9df; font-size:11px; white-space:nowrap; }
        tbody tr:hover { background:var(--panel2); }
        .badge { display:inline-block; padding:5px 9px; border-radius:20px; font-size:9px; font-weight:bold; }
        .badge.active { background:#304326; color:var(--lime); }
        .badge.inactive { background:#462727; color:#ff8585; }
        .badge.other { background:#453b25; color:#f3c66d; }
        .actions { display:flex; gap:6px; }
        .empty { padding:30px; color:var(--muted); text-align:center; }
        .modal-overlay { position:fixed; inset:0; z-index:50; display:none; align-items:center; justify-content:center; padding:18px; background:rgba(0,0,0,.76); }
        .modal-overlay.show { display:flex; }
        .modal { width:100%; max-width:510px; max-height:90vh; overflow:auto; padding:24px; border:1px solid var(--border); border-radius:13px; background:var(--panel); }
        .modal h2 { margin-bottom:20px; font-size:19px; }
        .field { margin-bottom:14px; }
        .field label { display:block; margin-bottom:7px; color:var(--muted); font-size:11px; }
        .field input { width:100%; padding:12px; border:1px solid var(--border); border-radius:7px; outline:none; background:#101510; color:white; font-size:12px; }
        .field input[readonly] { color:var(--muted); }
        .modal-actions { display:flex; justify-content:flex-end; gap:9px; margin-top:20px; }
        .alert { display:none; margin-bottom:15px; padding:12px 14px; border:1px solid #744040; border-radius:8px; background:#3a2222; color:#ffb0b0; font-size:12px; white-space:pre-line; }
        .alert.show { display:block; }
        footer { padding:19px; border-top:1px solid var(--border); color:#82907e; text-align:center; font-size:10px; }
        @media(max-width:950px) { main { padding:25px 18px; } }
        @media(max-width:700px) { .topbar { padding:0 15px; } .menu-toggle { display:block; } .admin-label { display:none; } .sidebar { position:fixed; top:70px; bottom:0; left:-260px; z-index:15; overflow-y:auto; transition:.25s; } .sidebar.open { left:0; } main { padding:24px 14px; } .summary { grid-template-columns:repeat(2,minmax(0,1fr)); } .card { padding:15px; } .toolbar,.search,.filter { width:100%; } .card-header { align-items:flex-start; } }
        @media(max-width:420px) { .summary { grid-template-columns:1fr; } }
    </style>
</head>
<body>
<header class="topbar">
    <div class="brand"><span class="brand-mark">G</span> GYMBRO</div>
    <div class="top-actions">
        <span class="admin-label">ADMINISTRATOR</span>
        <form action="{{ route('logout') }}" method="POST" onsubmit="return confirm('Yakin ingin logout?')">
            @csrf
            <button class="logout" type="submit">Logout ↗</button>
        </form>
        <button class="menu-toggle" type="button" onclick="toggleSidebar()">☰</button>
    </div>
</header>
<div class="layout">
    <aside class="sidebar" id="sidebar">
        <div class="menu-label">MENU UTAMA</div>
        <a class="nav-link" href="{{ route('admin.dashboard') }}">▦ &nbsp; Dashboard</a>
        <div class="menu-label">MANAJEMEN DATA</div>
        <a class="nav-link active" href="{{ url('/tabel_user') }}">♙ &nbsp; Data Member</a>
        <a class="nav-link" href="{{ url('/tabel_pt') }}">✦ &nbsp; Personal Trainer</a>
        <a class="nav-link" href="{{ url('/tabel_schedule') }}">▦ &nbsp; Jadwal Latihan</a>
        <a class="nav-link" href="{{ url('/tabel_transaction') }}">▤ &nbsp; Data Transaksi</a>
        <a class="nav-link" href="{{ route('admin.profile.edit') }}">⚙ &nbsp; Profil Admin</a>
    </aside>

    <main>
        <section class="heading">
            <small>MANAJEMEN DATA</small>
            <h1>Data Member</h1>
            <p>Kelola akun member GYMBRO. Data ditampilkan langsung dari database.</p>
        </section>

        <section class="summary">
            <article class="summary-card"><small>Total Member</small><strong id="totalMember">—</strong></article>
            <article class="summary-card"><small>Membership Aktif</small><strong id="activeMember">—</strong></article>
            <article class="summary-card"><small>Membership Tidak Aktif</small><strong id="inactiveMember">—</strong></article>
        </section>

        <section class="card">
            <div class="card-header">
                <h2>Daftar Member</h2>
                <div class="toolbar">
                    <input class="search" id="searchInput" type="search" placeholder="Cari nama, email, atau nomor HP..." oninput="renderMembers()">
                    <select class="filter" id="statusFilter" onchange="renderMembers()">
                        <option value="all">Semua Status</option>
                        <option value="active">Membership Aktif</option>
                        <option value="inactive">Membership Tidak Aktif</option>
                    </select>
                    <button class="btn btn-primary" type="button" onclick="openAddModal()">+ Tambah Member</button>
                </div>
            </div>
            <div class="alert" id="pageAlert"></div>
            <div class="table-wrap">
                <table>
                    <thead><tr><th>ID</th><th>NAMA MEMBER</th><th>EMAIL</th><th>NO. HP</th><th>STATUS MEMBERSHIP</th><th>MULAI</th><th>BERAKHIR</th><th>AKSI</th></tr></thead>
                    <tbody id="memberTableBody"><tr><td colspan="8" class="empty">Memuat data member...</td></tr></tbody>
                </table>
            </div>
        </section>
    </main>
</div>
<footer>© {{ date('Y') }} GYMBRO FITNESS · Train Hard. Stay Humble. Keep Growing.</footer>

<div class="modal-overlay" id="memberModal" onclick="overlayClose(event)">
    <div class="modal">
        <h2 id="modalTitle">Tambah Member</h2>
        <div class="alert" id="modalAlert"></div>
        <form id="memberForm">
            <input type="hidden" id="memberId">
            <div class="field"><label for="memberName">Nama lengkap</label><input id="memberName" name="name" type="text" maxlength="255" required></div>
            <div class="field"><label for="memberEmail">Email</label><input id="memberEmail" name="email" type="email" maxlength="255" required></div>
            <div class="field"><label for="memberPhone">Nomor HP</label><input id="memberPhone" name="phone" type="text" maxlength="20"></div>
            <div class="field" id="passwordField"><label for="memberPassword">Password (minimal 8 karakter)</label><input id="memberPassword" name="password" type="password" minlength="8" autocomplete="new-password"></div>
            <div class="modal-actions">
                <button class="btn btn-secondary" type="button" onclick="closeModal()">Batal</button>
                <button class="btn btn-primary" id="saveButton" type="submit">Simpan</button>
            </div>
        </form>
    </div>
</div>

<script>
    let members = [];
    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

    function toggleSidebar() {
        document.getElementById('sidebar').classList.toggle('open');
    }

    function escapeHtml(value) {
        return String(value ?? '').replace(/[&<>"']/g, char => ({
            '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;'
        }[char]));
    }

    function formatDate(value) {
        if (!value) return '-';
        const date = new Date(value);
        if (Number.isNaN(date.getTime())) return '-';
        return date.toLocaleDateString('id-ID', { day: '2-digit', month: 'short', year: 'numeric' });
    }

    function membershipBadge(status) {
        const normalized = String(status || '').toLowerCase();
        if (normalized === 'active') return '<span class="badge active">Aktif</span>';
        if (normalized === 'inactive') return '<span class="badge inactive">Tidak Aktif</span>';
        return `<span class="badge other">${escapeHtml(status || 'Belum ada status')}</span>`;
    }

    function showAlert(elementId, message) {
        const element = document.getElementById(elementId);
        element.textContent = message;
        element.classList.add('show');
    }

    function hideAlert(elementId) {
        const element = document.getElementById(elementId);
        element.textContent = '';
        element.classList.remove('show');
    }

    async function loadMembers() {
        const tbody = document.getElementById('memberTableBody');
        tbody.innerHTML = '<tr><td colspan="8" class="empty">Memuat data member...</td></tr>';
        hideAlert('pageAlert');
        try {
            const response = await fetch('{{ route('admin.users.index') }}', {
                headers: { 'Accept': 'application/json' },
                credentials: 'same-origin'
            });
            const result = await response.json();
            if (!response.ok) throw new Error(result.message || 'Gagal mengambil data member.');
            members = Array.isArray(result) ? result : [];
            updateSummary();
            renderMembers();
        } catch (error) {
            tbody.innerHTML = '<tr><td colspan="8" class="empty">Data member gagal dimuat.</td></tr>';
            showAlert('pageAlert', error.message);
        }
    }

    function updateSummary() {
        const active = members.filter(member => String(member.membership_status).toLowerCase() === 'active').length;
        document.getElementById('totalMember').textContent = members.length.toLocaleString('id-ID');
        document.getElementById('activeMember').textContent = active.toLocaleString('id-ID');
        document.getElementById('inactiveMember').textContent = (members.length - active).toLocaleString('id-ID');
    }

    function renderMembers() {
        const query = document.getElementById('searchInput').value.trim().toLowerCase();
        const filter = document.getElementById('statusFilter').value;
        const filtered = members.filter(member => {
            const matchesSearch = [member.name, member.email, member.phone, member.id]
                .some(value => String(value ?? '').toLowerCase().includes(query));
            const status = String(member.membership_status || '').toLowerCase();
            const matchesStatus = filter === 'all' || status === filter;
            return matchesSearch && matchesStatus;
        });

        const tbody = document.getElementById('memberTableBody');
        if (!filtered.length) {
            tbody.innerHTML = '<tr><td colspan="8" class="empty">Tidak ada member yang cocok dengan pencarian.</td></tr>';
            return;
        }

        tbody.innerHTML = filtered.map(member => `
            <tr>
                <td>#${escapeHtml(member.id)}</td>
                <td>${escapeHtml(member.name)}</td>
                <td>${escapeHtml(member.email)}</td>
                <td>${escapeHtml(member.phone || '-')}</td>
                <td>${membershipBadge(member.membership_status)}</td>
                <td>${formatDate(member.membership_start)}</td>
                <td>${formatDate(member.membership_end)}</td>
                <td><div class="actions">
                    <button class="btn btn-edit" type="button" onclick="showDetail(${Number(member.id)})">Detail</button>
                    <button class="btn btn-primary" type="button" onclick="openEditModal(${Number(member.id)})">Edit</button>
                    <button class="btn btn-delete" type="button" onclick="deleteMember(${Number(member.id)})">Hapus</button>
                </div></td>
            </tr>
        `).join('');
    }

    function openAddModal() {
        document.getElementById('memberForm').reset();
        document.getElementById('memberId').value = '';
        document.getElementById('modalTitle').textContent = 'Tambah Member';
        document.getElementById('passwordField').style.display = 'block';
        document.getElementById('memberPassword').required = true;
        document.getElementById('saveButton').textContent = 'Tambah Member';
        hideAlert('modalAlert');
        document.getElementById('memberModal').classList.add('show');
    }

    function openEditModal(id) {
        const member = members.find(item => Number(item.id) === Number(id));
        if (!member) return;
        document.getElementById('memberForm').reset();
        document.getElementById('memberId').value = member.id;
        document.getElementById('memberName').value = member.name || '';
        document.getElementById('memberEmail').value = member.email || '';
        document.getElementById('memberPhone').value = member.phone || '';
        document.getElementById('modalTitle').textContent = 'Edit Data Member';
        document.getElementById('passwordField').style.display = 'none';
        document.getElementById('memberPassword').required = false;
        document.getElementById('saveButton').textContent = 'Simpan Perubahan';
        hideAlert('modalAlert');
        document.getElementById('memberModal').classList.add('show');
    }

    function showDetail(id) {
        const member = members.find(item => Number(item.id) === Number(id));
        if (!member) return;
        alert(
            `DETAIL MEMBER\n\n` +
            `ID: ${member.id}\n` +
            `Nama: ${member.name || '-'}\n` +
            `Email: ${member.email || '-'}\n` +
            `No. HP: ${member.phone || '-'}\n` +
            `Membership: ${member.membership_status || '-'}\n` +
            `Mulai: ${formatDate(member.membership_start)}\n` +
            `Berakhir: ${formatDate(member.membership_end)}`
        );
    }

    function closeModal() {
        document.getElementById('memberModal').classList.remove('show');
        document.getElementById('memberForm').reset();
        hideAlert('modalAlert');
    }

    function overlayClose(event) {
        if (event.target.id === 'memberModal') closeModal();
    }

    document.getElementById('memberForm').addEventListener('submit', async event => {
        event.preventDefault();
        hideAlert('modalAlert');
        const id = document.getElementById('memberId').value;
        const isEdit = Boolean(id);
        const payload = {
            name: document.getElementById('memberName').value.trim(),
            email: document.getElementById('memberEmail').value.trim(),
            phone: document.getElementById('memberPhone').value.trim()
        };
        if (!isEdit) payload.password = document.getElementById('memberPassword').value;

        const button = document.getElementById('saveButton');
        button.disabled = true;
        button.textContent = 'Menyimpan...';
        try {
            const response = await fetch(isEdit ? `/admin/users/${id}` : '{{ route('admin.users.store') }}', {
                method: isEdit ? 'PUT' : 'POST',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                credentials: 'same-origin',
                body: JSON.stringify(payload)
            });
            const result = await response.json();
            if (!response.ok) {
                const errors = result.errors ? Object.values(result.errors).flat().join('\n') : result.message;
                throw new Error(errors || 'Gagal menyimpan data member.');
            }
            closeModal();
            await loadMembers();
            showAlert('pageAlert', result.message || 'Data berhasil disimpan.');
        } catch (error) {
            showAlert('modalAlert', error.message);
        } finally {
            button.disabled = false;
            button.textContent = isEdit ? 'Simpan Perubahan' : 'Tambah Member';
        }
    });

    async function deleteMember(id) {
        const member = members.find(item => Number(item.id) === Number(id));
        if (!member) return;
        if (!confirm(`Yakin ingin menghapus member ${member.name}?`)) return;
        try {
            const response = await fetch(`/admin/users/${id}`, {
                method: 'DELETE',
                headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': csrfToken },
                credentials: 'same-origin'
            });
            const result = await response.json();
            if (!response.ok) throw new Error(result.message || 'Gagal menghapus member.');
            await loadMembers();
            showAlert('pageAlert', result.message || 'Member berhasil dihapus.');
        } catch (error) {
            showAlert('pageAlert', error.message);
        }
    }

    loadMembers();
</script>
</body>
</html>
