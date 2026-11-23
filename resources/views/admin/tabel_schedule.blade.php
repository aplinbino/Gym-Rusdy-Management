<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Manajemen Jadwal Latihan | GYMBRO</title>
    <style>
        :root {
            --bg: #101510; --sidebar: #151e15; --panel: #192119; --panel2: #202b20;
            --line: #344233; --text: #f2f5ef; --muted: #a4afa0; --lime: #c8f169;
            --lime-soft: #2b3a1d; --red: #ffaaaa; --amber: #f5d58b;
        }
        * { box-sizing: border-box; }
        body { margin: 0; min-height: 100vh; background: var(--bg); color: var(--text); font-family: Arial, Helvetica, sans-serif; }
        button, input, select { font: inherit; }
        .global-header {
            height: 84px; width: 100%; display: flex; align-items: center; justify-content: space-between;
            padding: 0 12px; background: #151e15; border-bottom: 1px solid var(--line);
        }
        .global-brand { display: flex; align-items: center; gap: 14px; color: var(--text); font-size: 23px; font-weight: 900; letter-spacing: 2px; }
        .brand-mark { width: 46px; height: 46px; display: grid; place-items: center; border-radius: 12px; background: var(--lime); color: #17200f; font-size: 27px; font-weight: 900; }
        .header-actions { display: flex; align-items: center; gap: 16px; }
        .admin-label { color: var(--lime); font-size: 13px; font-weight: 900; letter-spacing: 1.5px; }
        .header-logout { display: inline-flex; align-items: center; gap: 6px; padding: 13px 17px; background: #263326; border: 1px solid #344233; border-radius: 9px; color: var(--text); font-size: 13px; font-weight: 700; text-decoration: none; cursor: pointer; }
        .header-logout:hover { border-color: var(--lime); color: var(--lime); }
        .layout { display: flex; min-height: calc(100vh - 84px); }
        .sidebar { width: 280px; flex: 0 0 250px; background: var(--sidebar); border-right: 1px solid var(--line); padding: 28px 18px; display: flex; flex-direction: column; }
        .brand { color: var(--lime); font-size: 25px; font-weight: 900; letter-spacing: 1.5px; padding: 0 12px; }
        .brand small { display: block; color: var(--muted); font-size: 10px; letter-spacing: 3px; margin-top: 5px; }
        .nav-title { color: #82907e; font-size: 10px; font-weight: 800; letter-spacing: 1.5px; margin: 38px 12px 12px; }
        .nav a { display: flex; align-items: center; gap: 11px; padding: 12px 14px; margin: 4px 0; border-radius: 9px; color: var(--muted); text-decoration: none; font-size: 14px; font-weight: 700; }
        .nav a:hover, .nav a.active { background: var(--lime-soft); color: var(--lime); }
        .sidebar-bottom { margin-top: auto; }
        .logout { width: 100%; padding: 12px; border: 1px solid var(--line); border-radius: 9px; color: var(--red); background: transparent; cursor: pointer; }
        main { flex: 1; min-width: 0; padding: 34px clamp(18px, 4vw, 52px); }
        .page-heading { margin-bottom: 28px; }
        .eyebrow { color: var(--lime); font-size: 11px; font-weight: 900; letter-spacing: 2px; text-transform: uppercase; }
        h1 { font-size: clamp(25px, 3vw, 34px); margin: 9px 0 7px; }
        .subtitle { color: var(--muted); font-size: 14px; margin: 0; }
        .stats { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 16px; margin-bottom: 22px; }
        .stat, .content-card { background: var(--panel); border: 1px solid var(--line); border-radius: 15px; }
        .stat { padding: 20px 22px; }
        .stat-label { color: var(--muted); font-size: 13px; }
        .stat-value { color: var(--lime); font-size: 30px; font-weight: 900; margin-top: 9px; }
        .content-card { padding: 22px; }
        .toolbar { display: flex; align-items: center; justify-content: space-between; gap: 14px; flex-wrap: wrap; margin-bottom: 18px; }
        .toolbar h2 { margin: 0 0 6px; font-size: 18px; }
        .toolbar p { margin: 0; color: var(--muted); font-size: 13px; }
        .filters { display: flex; flex-wrap: wrap; gap: 9px; }
        .control { min-height: 40px; background: #111811; border: 1px solid var(--line); border-radius: 8px; color: var(--text); padding: 9px 11px; outline: none; }
        .control:focus { border-color: var(--lime); }
        .table-wrap { overflow-x: auto; }
        table { width: 100%; min-width: 920px; border-collapse: collapse; }
        th { padding: 13px 12px; color: var(--lime); background: #141d14; border-bottom: 1px solid var(--line); text-align: left; font-size: 11px; text-transform: uppercase; letter-spacing: .7px; }
        td { padding: 15px 12px; border-bottom: 1px solid #293629; font-size: 13px; vertical-align: middle; }
        tbody tr:hover { background: #202a20; }
        .primary-text { display: block; font-weight: 700; }
        .secondary-text { display: block; color: var(--muted); font-size: 11px; margin-top: 5px; }
        .pill { display: inline-block; border-radius: 30px; padding: 5px 9px; background: #293629; color: #d7e1d2; font-size: 11px; font-weight: 800; text-transform: capitalize; white-space: nowrap; }
        .pill.done, .pill.completed, .pill.selesai, .pill.confirmed, .pill.dikonfirmasi { background: #2b3a1d; color: var(--lime); }
        .pill.cancelled, .pill.canceled, .pill.dibatalkan, .pill.rejected { background: #402626; color: var(--red); }
        .pill.pending, .pill.menunggu { background: #40351f; color: var(--amber); }
        .empty { padding: 36px 12px; text-align: center; color: var(--muted); }
        .notice { display: none; padding: 12px 14px; border-radius: 8px; margin-bottom: 15px; font-size: 13px; }
        .notice.error { display: block; color: #ffc2c2; background: #351f1f; border: 1px solid #633; }
        .notice.info { display: block; color: #d9edc7; background: #23331c; border: 1px solid #405b30; }
        .count-label { color: var(--muted); font-size: 12px; margin-top: 14px; }

        .action-buttons { display: flex; align-items: center; gap: 7px; white-space: nowrap; }
        .action-btn {
            border: 1px solid var(--line); background: #263326; color: var(--text);
            border-radius: 7px; padding: 7px 11px; font-size: 12px; font-weight: 700;
            cursor: pointer; transition: .18s ease;
        }
        .action-btn:hover { border-color: var(--lime); color: var(--lime); background: #2b3a1d; }
        .action-btn.delete { background: #382323; border-color: #633737; color: var(--red); }
        .action-btn.delete:hover { background: #4a2929; border-color: #ff7373; color: #ffd0d0; }
        .action-btn:disabled { opacity: .55; cursor: not-allowed; }
        .modal-backdrop { display: none; position: fixed; inset: 0; z-index: 50; background: #000b; padding: 20px; overflow-y: auto; }
        .modal-backdrop.show { display: grid; place-items: center; }
        .modal { width: min(100%, 560px); background: var(--panel); border: 1px solid var(--line); border-radius: 15px; padding: 23px; box-shadow: 0 24px 70px #0009; }
        .modal-head { display: flex; align-items: center; justify-content: space-between; gap: 12px; margin-bottom: 20px; }
        .modal-head h2 { margin: 0; font-size: 19px; }
        .modal-close { border: 0; background: transparent; color: var(--muted); font-size: 25px; cursor: pointer; }
        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }
        .field { display: flex; flex-direction: column; gap: 7px; }
        .field.full { grid-column: 1 / -1; }
        .field label { color: var(--muted); font-size: 12px; font-weight: 700; }
        .field input, .field select, .field textarea {
            width: 100%; background: #111811; border: 1px solid var(--line); border-radius: 8px;
            color: var(--text); padding: 10px 11px; outline: none;
        }
        .field textarea { min-height: 90px; resize: vertical; }
        .field input:focus, .field select:focus, .field textarea:focus { border-color: var(--lime); }
        .modal-actions { display: flex; justify-content: flex-end; gap: 9px; margin-top: 20px; }
        .modal-btn { border-radius: 8px; padding: 10px 14px; cursor: pointer; font-weight: 700; border: 1px solid var(--line); }
        .modal-btn.cancel { background: #263326; color: var(--text); }
        .modal-btn.save { background: var(--lime); border-color: var(--lime); color: #17200f; }
        .detail-grid { display: grid; grid-template-columns: 135px 1fr; gap: 13px; font-size: 13px; }
        .detail-grid dt { color: var(--muted); }
        .detail-grid dd { margin: 0; overflow-wrap: anywhere; }
        .field-error { color: var(--red); font-size: 12px; margin-top: 10px; white-space: pre-line; }

        @media (max-width: 850px) { .sidebar { width: 210px; flex-basis: 210px; } .stats { grid-template-columns: 1fr 1fr; } }
        @media (max-width: 620px) {
            .global-header { height: 72px; padding: 0 12px; } .global-brand { font-size: 18px; gap: 9px; } .brand-mark { width: 40px; height: 40px; } .admin-label { font-size: 10px; letter-spacing: .8px; } .header-actions { gap: 8px; } .header-logout { padding: 10px 11px; font-size: 11px; }
            .layout { display: block; } .sidebar { width: 100%; padding: 16px; border-right: 0; border-bottom: 1px solid var(--line); }
            .nav-title, .sidebar-bottom { display: none; } .nav { display: flex; gap: 4px; overflow-x: auto; margin-top: 14px; }
            .nav a { white-space: nowrap; padding: 9px 10px; } main { padding: 24px 15px; }
            .stats { grid-template-columns: 1fr; } .filters { width: 100%; } .filters .control { flex: 1; min-width: 140px; }
        }
    </style>
</head>
<body>
<header class="global-header">
    <div class="global-brand">
        <span class="brand-mark">G</span>
        <span>GYMBRO</span>
    </div>
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
            <a class="active" href="{{ url('/tabel_schedule') }}">▦ &nbsp; Jadwal Latihan</a>
            <a href="{{ url('/tabel_transaction') }}">▤ &nbsp; Transaksi</a>
            <a href="{{ route('admin.profile.edit') }}">⚙ &nbsp; Profil Admin</a>
        </nav>
    </aside>

    <main>
        <header class="page-heading">
            <div class="eyebrow">ADMIN / JADWAL LATIHAN</div>
            <h1>Manajemen Jadwal Latihan</h1>
            <p class="subtitle">Pantau jadwal booking latihan member bersama Personal Trainer.</p>
        </header>

        <div id="notice" class="notice"></div>

        <section class="stats">
            <div class="stat"><div class="stat-label">Total Jadwal</div><div class="stat-value" id="totalSchedule">—</div></div>
            <div class="stat"><div class="stat-label">Jadwal Mendatang</div><div class="stat-value" id="upcomingSchedule">—</div></div>
            <div class="stat"><div class="stat-label">Jadwal Selesai</div><div class="stat-value" id="completedSchedule">—</div></div>
        </section>

        <section class="content-card">
            <div class="toolbar">
                <div>
                    <h2>Daftar Jadwal Member</h2>
                    <p>Informasi jadwal diambil langsung dari database GYMBRO.</p>
                </div>
                <div class="filters">
                    <input class="control" id="searchInput" type="search" placeholder="Cari member atau PT...">
                    <input class="control" id="dateFilter" type="date" aria-label="Filter tanggal">
                    <select class="control" id="statusFilter" aria-label="Filter status">
                        <option value="">Semua status</option>
                    </select>
                </div>
            </div>

            <div class="table-wrap">
                <table>
                    <thead>
                    <tr>
                        <th>Member</th>
                        <th>Personal Trainer</th>
                        <th>Tanggal</th>
                        <th>Jam</th>
                        <th>Jenis Latihan</th>
                        <th>Status</th>
                        <th>Catatan</th>
                        <th>Aksi</th>
                    </tr>
                    </thead>
                    <tbody id="scheduleTableBody">
                    <tr><td colspan="8" class="empty">Memuat jadwal latihan...</td></tr>
                    </tbody>
                </table>
            </div>
            <div class="count-label" id="resultCount"></div>
        </section>
    </main>
</div>


<div class="modal-backdrop" id="scheduleEditModal">
    <section class="modal" role="dialog" aria-modal="true" aria-labelledby="scheduleEditTitle">
        <div class="modal-head">
            <h2 id="scheduleEditTitle">Edit Jadwal Latihan</h2>
            <button class="modal-close" type="button" onclick="closeScheduleEdit()" aria-label="Tutup">&times;</button>
        </div>
        <form id="scheduleEditForm">
            <input type="hidden" id="editScheduleId">
            <div class="form-grid">
                <div class="field">
                    <label for="editTanggal">Tanggal latihan</label>
                    <input type="date" id="editTanggal" required>
                </div>
                <div class="field">
                    <label for="editJam">Jam latihan</label>
                    <input type="time" id="editJam" required>
                </div>
                <div class="field full">
                    <label for="editJenis">Jenis latihan</label>
                    <input type="text" id="editJenis" maxlength="50" required>
                </div>
                <div class="field full">
                    <label for="editStatus">Status</label>
                    <select id="editStatus" required>
                        <option value="scheduled">Scheduled</option>
                        <option value="pending">Pending</option>
                        <option value="approved">Approved</option>
                        <option value="completed">Completed</option>
                        <option value="cancelled">Cancelled</option>
                    </select>
                </div>
                <div class="field full">
                    <label for="editCatatan">Catatan</label>
                    <textarea id="editCatatan" maxlength="2000" placeholder="Catatan tambahan..."></textarea>
                </div>
            </div>
            <div class="field-error" id="scheduleEditError"></div>
            <div class="modal-actions">
                <button class="modal-btn cancel" type="button" onclick="closeScheduleEdit()">Batal</button>
                <button class="modal-btn save" type="submit" id="scheduleSaveButton">Simpan Perubahan</button>
            </div>
        </form>
    </section>
</div>

<div class="modal-backdrop" id="scheduleDetailModal">
    <section class="modal" role="dialog" aria-modal="true" aria-labelledby="scheduleDetailTitle">
        <div class="modal-head">
            <h2 id="scheduleDetailTitle">Detail Jadwal Latihan</h2>
            <button class="modal-close" type="button" onclick="closeScheduleDetail()" aria-label="Tutup">&times;</button>
        </div>
        <dl class="detail-grid" id="scheduleDetailContent"></dl>
        <div class="modal-actions">
            <button class="modal-btn cancel" type="button" onclick="closeScheduleDetail()">Tutup</button>
        </div>
    </section>
</div>

<script>
    let schedules = [];
    const body = document.getElementById('scheduleTableBody');
    const notice = document.getElementById('notice');

    function escapeHtml(value) {
        return String(value ?? '').replace(/[&<>"']/g, char => ({
            '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;'
        }[char]));
    }

    function parseDate(value) {
        if (!value) return null;
        const date = new Date(`${String(value).slice(0, 10)}T00:00:00`);
        return Number.isNaN(date.getTime()) ? null : date;
    }

    function formatDate(value) {
        const date = parseDate(value);
        return date ? new Intl.DateTimeFormat('id-ID', { day: '2-digit', month: 'long', year: 'numeric' }).format(date) : (value || '-');
    }

    function statusClass(status) {
        const value = String(status || '').toLowerCase();
        if (['selesai', 'completed', 'done', 'dikonfirmasi', 'confirmed'].includes(value)) return 'done';
        if (['dibatalkan', 'cancelled', 'canceled', 'rejected'].includes(value)) return 'cancelled';
        if (['menunggu', 'pending'].includes(value)) return 'pending';
        return '';
    }

    function showError(message) {
        notice.textContent = message;
        notice.className = 'notice error';
    }

    async function loadSchedules() {
        body.innerHTML = '<tr><td colspan="8" class="empty">Memuat jadwal latihan...</td></tr>';
        try {
            const response = await fetch('{{ route('admin.jadwal-pt.index') }}', {
                headers: { 'Accept': 'application/json' }
            });
            const data = await response.json().catch(() => []);
            if (!response.ok) throw new Error(data.message || `Gagal mengambil data (${response.status}).`);
            schedules = Array.isArray(data) ? data : (data.data || []);
            populateStatusFilter();
            renderSchedules();
        } catch (error) {
            body.innerHTML = `<tr><td colspan="8" class="empty">${escapeHtml(error.message)}</td></tr>`;
            showError(error.message);
        }
    }

    function populateStatusFilter() {
        const select = document.getElementById('statusFilter');
        const current = select.value;
        const statuses = [...new Set(schedules.map(item => item.status).filter(Boolean))];
        select.innerHTML = '<option value="">Semua status</option>' + statuses.map(status =>
            `<option value="${escapeHtml(status)}">${escapeHtml(status)}</option>`
        ).join('');
        if (statuses.includes(current)) select.value = current;
    }

    function renderSchedules() {
        const keyword = document.getElementById('searchInput').value.toLowerCase().trim();
        const selectedDate = document.getElementById('dateFilter').value;
        const selectedStatus = document.getElementById('statusFilter').value;

        const completed = schedules.filter(item => ['selesai', 'completed', 'done'].includes(String(item.status || '').toLowerCase())).length;
        const upcoming = schedules.filter(item => {
            const date = parseDate(item.tanggal);
            return date && date >= new Date(new Date().toDateString()) &&
                !['selesai', 'completed', 'done', 'dibatalkan', 'cancelled', 'canceled'].includes(String(item.status || '').toLowerCase());
        }).length;

        document.getElementById('totalSchedule').textContent = schedules.length;
        document.getElementById('upcomingSchedule').textContent = upcoming;
        document.getElementById('completedSchedule').textContent = completed;

        const filtered = schedules.filter(item => {
            const member = item.user?.name || '';
            const trainer = item.pt?.pt_name || item.pt?.user?.name || '';
            const matchesKeyword = [member, trainer, item.jenis_latihan, item.catatan]
                .some(value => String(value || '').toLowerCase().includes(keyword));
            const matchesDate = !selectedDate || String(item.tanggal || '').slice(0, 10) === selectedDate;
            const matchesStatus = !selectedStatus || item.status === selectedStatus;
            return matchesKeyword && matchesDate && matchesStatus;
        });

        if (!filtered.length) {
            body.innerHTML = `<tr><td colspan="8" class="empty">${schedules.length ? 'Tidak ada jadwal yang sesuai dengan filter.' : 'Belum ada jadwal latihan PT yang tercatat.'}</td></tr>`;
        } else {
            body.innerHTML = filtered.map(item => {
                const memberName = item.user?.name || 'Member tidak ditemukan';
                const ptName = item.pt?.pt_name || item.pt?.user?.name || 'PT tidak ditemukan';
                const status = item.status || 'Belum ditentukan';
                return `<tr>
                    <td><span class="primary-text">${escapeHtml(memberName)}</span><span class="secondary-text">ID Member: ${escapeHtml(item.user_id ?? '-')}</span></td>
                    <td><span class="primary-text">${escapeHtml(ptName)}</span></td>
                    <td>${escapeHtml(formatDate(item.tanggal))}</td>
                    <td>${escapeHtml(item.jam || '-')}</td>
                    <td>${escapeHtml(item.jenis_latihan || '-')}</td>
                    <td><span class="pill ${statusClass(status)}">${escapeHtml(status)}</span></td>
                    <td>${escapeHtml(item.catatan || '-')}</td>
                    <td><div class="action-buttons">
                        <button class="action-btn" type="button" onclick="showScheduleDetail(${Number(item.id)})">Detail</button>
                        <button class="action-btn" type="button" onclick="openScheduleEdit(${Number(item.id)})">Edit</button>
                        <button class="action-btn delete" type="button" onclick="deleteSchedule(${Number(item.id)})">Hapus</button>
                    </div></td>
                </tr>`;
            }).join('');
        }
        document.getElementById('resultCount').textContent = `Menampilkan ${filtered.length} dari ${schedules.length} jadwal`;
    }


    function findSchedule(id) {
        return schedules.find(item => Number(item.id) === Number(id));
    }

    function showScheduleDetail(id) {
        const item = findSchedule(id);
        if (!item) return;

        const details = [
            ['ID Jadwal', item.id],
            ['Member', item.user?.name || 'Member tidak ditemukan'],
            ['Personal Trainer', item.pt?.pt_name || item.pt?.user?.name || 'PT tidak ditemukan'],
            ['Tanggal', formatDate(item.tanggal)],
            ['Jam', item.jam || '-'],
            ['Jenis Latihan', item.jenis_latihan || '-'],
            ['Status', item.status || '-'],
            ['Catatan', item.catatan || '-'],
            ['ID Transaksi', item.transaksi_id || '-']
        ];

        document.getElementById('scheduleDetailContent').innerHTML = details.map(([label, value]) =>
            `<dt>${escapeHtml(label)}</dt><dd>${escapeHtml(value)}</dd>`
        ).join('');
        document.getElementById('scheduleDetailModal').classList.add('show');
    }

    function closeScheduleDetail() {
        document.getElementById('scheduleDetailModal').classList.remove('show');
    }

    function openScheduleEdit(id) {
        const item = findSchedule(id);
        if (!item) return;

        document.getElementById('editScheduleId').value = item.id;
        document.getElementById('editTanggal').value = String(item.tanggal || '').slice(0, 10);
        document.getElementById('editJam').value = String(item.jam || '').slice(0, 5);
        document.getElementById('editJenis').value = item.jenis_latihan || '';
        document.getElementById('editStatus').value = item.status || 'scheduled';
        document.getElementById('editCatatan').value = item.catatan || '';
        document.getElementById('scheduleEditError').textContent = '';
        document.getElementById('scheduleEditModal').classList.add('show');
    }

    function closeScheduleEdit() {
        document.getElementById('scheduleEditModal').classList.remove('show');
    }

    function showNotice(message, type = 'info') {
        notice.textContent = message;
        notice.className = `notice ${type}`;
        window.scrollTo({ top: 0, behavior: 'smooth' });
        window.setTimeout(() => { notice.className = 'notice'; }, 5000);
    }

    async function sendScheduleRequest(url, method, payload = null) {
        const options = {
            method,
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        };
        if (payload !== null) {
            options.headers['Content-Type'] = 'application/json';
            options.body = JSON.stringify(payload);
        }

        const response = await fetch(url, options);
        const data = await response.json().catch(() => ({}));
        if (!response.ok) {
            const validation = data.errors ? Object.values(data.errors).flat().join('\n') : '';
            throw new Error(validation || data.message || `Permintaan gagal (${response.status}).`);
        }
        return data;
    }

    document.getElementById('scheduleEditForm').addEventListener('submit', async event => {
        event.preventDefault();

        const id = document.getElementById('editScheduleId').value;
        const button = document.getElementById('scheduleSaveButton');
        const errorBox = document.getElementById('scheduleEditError');
        const payload = {
            tanggal: document.getElementById('editTanggal').value,
            jam: document.getElementById('editJam').value,
            jenis_latihan: document.getElementById('editJenis').value.trim(),
            status: document.getElementById('editStatus').value,
            catatan: document.getElementById('editCatatan').value.trim()
        };

        button.disabled = true;
        button.textContent = 'Menyimpan...';
        errorBox.textContent = '';

        try {
            const url = `{{ url('/admin/jadwal-pt') }}/${encodeURIComponent(id)}`;
            await sendScheduleRequest(url, 'PUT', payload);
            closeScheduleEdit();
            showNotice('Jadwal latihan berhasil diperbarui.');
            await loadSchedules();
        } catch (error) {
            errorBox.textContent = error.message;
        } finally {
            button.disabled = false;
            button.textContent = 'Simpan Perubahan';
        }
    });

    async function deleteSchedule(id) {
        const item = findSchedule(id);
        if (!item) return;

        const member = item.user?.name || 'member';
        if (!confirm(`Yakin ingin menghapus jadwal latihan ${member} pada ${formatDate(item.tanggal)}? Tindakan ini tidak dapat dibatalkan.`)) {
            return;
        }

        try {
            const url = `{{ url('/admin/jadwal-pt') }}/${encodeURIComponent(id)}`;
            const result = await sendScheduleRequest(url, 'DELETE');
            showNotice(result.message || 'Jadwal latihan berhasil dihapus.');
            await loadSchedules();
        } catch (error) {
            showNotice(error.message, 'error');
        }
    }

    document.getElementById('scheduleEditModal').addEventListener('click', event => {
        if (event.target.id === 'scheduleEditModal') closeScheduleEdit();
    });
    document.getElementById('scheduleDetailModal').addEventListener('click', event => {
        if (event.target.id === 'scheduleDetailModal') closeScheduleDetail();
    });


    document.getElementById('searchInput').addEventListener('input', renderSchedules);
    document.getElementById('dateFilter').addEventListener('change', renderSchedules);
    document.getElementById('statusFilter').addEventListener('change', renderSchedules);

    loadSchedules();
</script>
</body>
</html>
