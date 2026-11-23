<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Manajemen Transaksi | GYMBRO</title>
    <style>
        :root {
            --bg:#101510; --sidebar:#151e15; --panel:#192119; --panel2:#202b20;
            --line:#344233; --text:#f2f5ef; --muted:#a4afa0; --lime:#c8f169;
            --lime-soft:#2b3a1d; --red:#ffaaaa; --amber:#f5d58b;
        }
        *{box-sizing:border-box}
        body{margin:0;min-height:100vh;background:var(--bg);color:var(--text);font-family:Arial,Helvetica,sans-serif}
        button,input,select{font:inherit}
        .global-header{height:84px;width:100%;display:flex;align-items:center;justify-content:space-between;padding:0 12px;background:var(--sidebar);border-bottom:1px solid var(--line)}
        .global-brand{display:flex;align-items:center;gap:14px;color:var(--text);font-size:23px;font-weight:900;letter-spacing:2px}
        .brand-mark{width:46px;height:46px;display:grid;place-items:center;border-radius:12px;background:var(--lime);color:#17200f;font-size:27px;font-weight:900}
        .header-actions{display:flex;align-items:center;gap:16px}
        .admin-label{color:var(--lime);font-size:13px;font-weight:900;letter-spacing:1.5px}
        .header-logout{display:inline-flex;align-items:center;gap:6px;padding:13px 17px;background:#263326;border:1px solid var(--line);border-radius:9px;color:var(--text);font-size:13px;font-weight:700;cursor:pointer}
        .header-logout:hover{border-color:var(--lime);color:var(--lime)}
        .layout{display:flex;min-height:calc(100vh - 84px)}
        .sidebar{width:250px;flex:0 0 250px;background:var(--sidebar);border-right:1px solid var(--line);padding:28px 18px}
        .nav-title{color:#82907e;font-size:10px;font-weight:800;letter-spacing:1.5px;margin:10px 12px 12px}
        .nav a{display:flex;align-items:center;gap:11px;padding:12px 14px;margin:4px 0;border-radius:9px;color:var(--muted);text-decoration:none;font-size:14px;font-weight:700}
        .nav a:hover,.nav a.active{background:var(--lime-soft);color:var(--lime)}
        main{flex:1;min-width:0;padding:34px clamp(18px,4vw,52px)}
        .page-heading{margin-bottom:28px}
        .eyebrow{color:var(--lime);font-size:11px;font-weight:900;letter-spacing:2px;text-transform:uppercase}
        h1{font-size:clamp(25px,3vw,34px);margin:9px 0 7px}
        .subtitle{color:var(--muted);font-size:14px;margin:0}
        .stats{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:16px;margin-bottom:22px}
        .stat,.content-card{background:var(--panel);border:1px solid var(--line);border-radius:15px}
        .stat{padding:20px 22px}
        .stat-label{color:var(--muted);font-size:13px}
        .stat-value{color:var(--lime);font-size:30px;font-weight:900;margin-top:9px}
        .content-card{padding:22px}
        .toolbar{display:flex;align-items:center;justify-content:space-between;gap:14px;flex-wrap:wrap;margin-bottom:18px}
        .toolbar h2{margin:0 0 6px;font-size:18px}
        .toolbar p{margin:0;color:var(--muted);font-size:13px}
        .filters{display:flex;flex-wrap:wrap;gap:9px}
        .control{min-height:40px;background:#111811;border:1px solid var(--line);border-radius:8px;color:var(--text);padding:9px 11px;outline:none}
        .control:focus{border-color:var(--lime)}
        .table-wrap{overflow-x:auto}
        table{width:100%;min-width:950px;border-collapse:collapse}
        th{padding:13px 12px;color:var(--lime);background:#141d14;border-bottom:1px solid var(--line);text-align:left;font-size:11px;text-transform:uppercase;letter-spacing:.7px}
        td{padding:15px 12px;border-bottom:1px solid #293629;font-size:13px;vertical-align:middle}
        tbody tr:hover{background:#202a20}
        .primary-text{display:block;font-weight:700}
        .secondary-text{display:block;color:var(--muted);font-size:11px;margin-top:5px}
        .pill{display:inline-block;border-radius:30px;padding:5px 9px;background:#293629;color:#d7e1d2;font-size:11px;font-weight:800;text-transform:capitalize;white-space:nowrap}
        .pill.paid,.pill.success,.pill.berhasil,.pill.approved,.pill.completed{background:#2b3a1d;color:var(--lime)}
        .pill.pending,.pill.menunggu{background:#40351f;color:var(--amber)}
        .pill.failed,.pill.gagal,.pill.cancelled,.pill.dibatalkan,.pill.rejected{background:#402626;color:var(--red)}
        .action-buttons{display:flex;align-items:center;gap:7px;white-space:nowrap}
        .action-btn{border:1px solid var(--line);background:#263326;color:var(--text);border-radius:7px;padding:7px 11px;font-size:12px;font-weight:700;cursor:pointer;transition:.18s ease}
        .action-btn:hover{border-color:var(--lime);color:var(--lime);background:#2b3a1d}
        .empty{padding:36px 12px;text-align:center;color:var(--muted)}
        .notice{display:none;padding:12px 14px;border-radius:8px;margin-bottom:15px;font-size:13px}
        .notice.error{display:block;color:#ffc2c2;background:#351f1f;border:1px solid #633}
        .count-label{color:var(--muted);font-size:12px;margin-top:14px}
        .modal-backdrop{display:none;position:fixed;inset:0;z-index:50;background:#000b;padding:20px;overflow-y:auto}
        .modal-backdrop.show{display:grid;place-items:center}
        .modal{width:min(100%,560px);background:var(--panel);border:1px solid var(--line);border-radius:15px;padding:23px;box-shadow:0 24px 70px #0009}
        .modal-head{display:flex;align-items:center;justify-content:space-between;gap:12px;margin-bottom:20px}
        .modal-head h2{margin:0;font-size:19px}
        .modal-close{border:0;background:transparent;color:var(--muted);font-size:25px;cursor:pointer}
        .detail-grid{display:grid;grid-template-columns:145px 1fr;gap:13px;font-size:13px}
        .detail-grid dt{color:var(--muted)}
        .detail-grid dd{margin:0;overflow-wrap:anywhere}
        .modal-actions{display:flex;justify-content:flex-end;margin-top:20px}
        .modal-btn{border:1px solid var(--line);background:#263326;color:var(--text);border-radius:8px;padding:10px 14px;cursor:pointer;font-weight:700}
        @media(max-width:850px){.sidebar{width:210px;flex-basis:210px}.stats{grid-template-columns:1fr 1fr}}
        @media(max-width:620px){
            .global-header{height:72px;padding:0 12px}.global-brand{font-size:18px;gap:9px}.brand-mark{width:40px;height:40px}
            .admin-label{font-size:10px;letter-spacing:.8px}.header-actions{gap:8px}.header-logout{padding:10px 11px;font-size:11px}
            .layout{display:block}.sidebar{width:100%;padding:16px;border-right:0;border-bottom:1px solid var(--line)}
            .nav{display:flex;gap:4px;overflow-x:auto}.nav-title{display:none}.nav a{white-space:nowrap;padding:9px 10px}
            main{padding:24px 15px}.stats{grid-template-columns:1fr}.filters{width:100%}.filters .control{flex:1;min-width:140px}
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
            <a class="active" href="{{ url('/tabel_transaction') }}">▤ &nbsp; Transaksi</a>
            <a href="{{ route('admin.profile.edit') }}">⚙ &nbsp; Profil Admin</a>
        </nav>
    </aside>

    <main>
        <header class="page-heading">
            <div class="eyebrow">ADMIN / TRANSAKSI</div>
            <h1>Manajemen Transaksi</h1>
            <p class="subtitle">Pantau riwayat pembayaran membership dan layanan Personal Trainer.</p>
        </header>

        <div id="notice" class="notice"></div>

        <section class="stats">
            <div class="stat"><div class="stat-label">Total Transaksi</div><div class="stat-value" id="totalTransactions">—</div></div>
            <div class="stat"><div class="stat-label">Transaksi Berhasil</div><div class="stat-value" id="successfulTransactions">—</div></div>
            <div class="stat"><div class="stat-label">Total Nilai Transaksi</div><div class="stat-value" id="totalRevenue">—</div></div>
        </section>

        <section class="content-card">
            <div class="toolbar">
                <div>
                    <h2>Riwayat Transaksi</h2>
                    <p>Data ditampilkan langsung dari database GYMBRO.</p>
                </div>
                <div class="filters">
                    <input class="control" id="searchInput" type="search" placeholder="Cari member atau transaksi...">
                    <select class="control" id="statusFilter" aria-label="Filter status">
                        <option value="">Semua status</option>
                    </select>
                    <select class="control" id="typeFilter" aria-label="Filter jenis transaksi">
                        <option value="">Semua jenis</option>
                    </select>
                    <input class="control" id="dateFrom" type="date" aria-label="Tanggal mulai" title="Dari tanggal">
                    <input class="control" id="dateTo" type="date" aria-label="Tanggal akhir" title="Sampai tanggal">
                    <button class="action-btn" id="resetFilters" type="button">Reset Filter</button>
                </div>
            </div>
            <div class="table-wrap">
                <table>
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Member</th>
                        <th>Jenis Transaksi</th>
                        <th>Tanggal</th>
                        <th>Nominal</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                    </thead>
                    <tbody id="transactionTableBody">
                    <tr><td colspan="7" class="empty">Memuat transaksi...</td></tr>
                    </tbody>
                </table>
            </div>
            <div class="count-label" id="resultCount"></div>
        </section>
    </main>
</div>

<div class="modal-backdrop" id="transactionDetailModal">
    <section class="modal" role="dialog" aria-modal="true" aria-labelledby="transactionDetailTitle">
        <div class="modal-head">
            <h2 id="transactionDetailTitle">Detail Transaksi</h2>
            <button class="modal-close" type="button" onclick="closeTransactionDetail()" aria-label="Tutup">&times;</button>
        </div>
        <dl class="detail-grid" id="transactionDetailContent"></dl>
        <div class="modal-actions">
            <button class="modal-btn" type="button" onclick="closeTransactionDetail()">Tutup</button>
        </div>
    </section>
</div>

<script>
    let transactions = [];
    const tableBody = document.getElementById('transactionTableBody');
    const notice = document.getElementById('notice');

    function escapeHtml(value) {
        return String(value ?? '').replace(/[&<>"']/g, char => ({
            '&':'&amp;', '<':'&lt;', '>':'&gt;', '"':'&quot;', "'":'&#039;'
        }[char]));
    }

    function firstValue(object, keys, fallback = '-') {
        for (const key of keys) {
            const value = object?.[key];
            if (value !== null && value !== undefined && value !== '') return value;
        }
        return fallback;
    }

    function money(value) {
        const amount = Number(value || 0);
        return new Intl.NumberFormat('id-ID', {
            style:'currency', currency:'IDR', maximumFractionDigits:0
        }).format(Number.isFinite(amount) ? amount : 0);
    }

    function dateValue(transaction) {
        return firstValue(transaction, ['tanggal_transaksi', 'tanggal', 'created_at', 'updated_at']);
    }

    function formatDate(value) {
        if (!value) return '-';
        const date = new Date(String(value).length <= 10 ? `${value}T00:00:00` : value);
        if (Number.isNaN(date.getTime())) return String(value);
        return new Intl.DateTimeFormat('id-ID', {
            day:'2-digit', month:'long', year:'numeric'
        }).format(date);
    }

    // Ambil tanggal kalender (YYYY-MM-DD) agar filter tidak terpengaruh zona waktu.
    function dateOnly(value) {
        if (!value || value === '-') return '';
        const text = String(value);
        const isoMatch = text.match(/^(\d{4}-\d{2}-\d{2})/);
        if (isoMatch) return isoMatch[1];
        const parsed = new Date(text);
        if (Number.isNaN(parsed.getTime())) return '';
        const year = parsed.getFullYear();
        const month = String(parsed.getMonth() + 1).padStart(2, '0');
        const day = String(parsed.getDate()).padStart(2, '0');
        return `${year}-${month}-${day}`;
    }

    function amountValue(transaction) {
        return firstValue(transaction, ['total_harga', 'total_bayar', 'jumlah_bayar', 'nominal', 'jumlah', 'harga', 'amount'], 0);
    }

    function typeValue(transaction) {
        return firstValue(transaction, ['jenis_transaksi', 'tipe_transaksi', 'jenis', 'type', 'layanan'], 'Transaksi');
    }

    function statusValue(transaction) {
        return firstValue(transaction, ['status_pembayaran', 'status', 'payment_status'], 'Tidak diketahui');
    }

    function statusClass(status) {
        const value = String(status || '').toLowerCase();
        if (['paid','success','berhasil','approved','completed','lunas'].includes(value)) return 'paid';
        if (['pending','menunggu','belum dibayar','unpaid'].includes(value)) return 'pending';
        if (['failed','gagal','cancelled','dibatalkan','rejected','expired'].includes(value)) return 'failed';
        return '';
    }

    function memberName(transaction) {
        return transaction.user?.name || transaction.nama_member || transaction.nama || 'Member tidak ditemukan';
    }

    function showError(message) {
        notice.textContent = message;
        notice.className = 'notice error';
    }

    async function loadTransactions() {
        tableBody.innerHTML = '<tr><td colspan="7" class="empty">Memuat transaksi...</td></tr>';
        try {
            const response = await fetch('{{ route('admin.transaksi.index') }}', {
                headers: { 'Accept':'application/json' }
            });
            const data = await response.json().catch(() => ({}));
            if (!response.ok) throw new Error(data.message || `Gagal mengambil data (${response.status}).`);
            transactions = Array.isArray(data) ? data : (data.data || []);
            populateFilters();
            renderTransactions();
        } catch (error) {
            tableBody.innerHTML = `<tr><td colspan="7" class="empty">${escapeHtml(error.message)}</td></tr>`;
            showError(error.message);
        }
    }

    function populateFilters() {
        const statusSelect = document.getElementById('statusFilter');
        const typeSelect = document.getElementById('typeFilter');
        const oldStatus = statusSelect.value;
        const oldType = typeSelect.value;
        const statuses = [...new Set(transactions.map(statusValue).filter(value => value !== 'Tidak diketahui'))];
        const types = [...new Set(transactions.map(typeValue).filter(value => value !== 'Transaksi'))];

        statusSelect.innerHTML = '<option value="">Semua status</option>' +
            statuses.map(value => `<option value="${escapeHtml(value)}">${escapeHtml(value)}</option>`).join('');
        typeSelect.innerHTML = '<option value="">Semua jenis</option>' +
            types.map(value => `<option value="${escapeHtml(value)}">${escapeHtml(value)}</option>`).join('');

        if (statuses.includes(oldStatus)) statusSelect.value = oldStatus;
        if (types.includes(oldType)) typeSelect.value = oldType;
    }

    function renderTransactions() {
        const keyword = document.getElementById('searchInput').value.toLowerCase().trim();
        const statusFilter = document.getElementById('statusFilter').value;
        const typeFilter = document.getElementById('typeFilter').value;
        const dateFrom = document.getElementById('dateFrom').value;
        const dateTo = document.getElementById('dateTo').value;

        const isInDateRange = item => {
            const transactionDate = dateOnly(dateValue(item));
            if (!transactionDate) return !dateFrom && !dateTo;
            return (!dateFrom || transactionDate >= dateFrom) &&
                (!dateTo || transactionDate <= dateTo);
        };

        // Statistik mengikuti pilihan jenis dan rentang tanggal.
        const summaryTransactions = transactions.filter(item =>
            (!typeFilter || typeValue(item) === typeFilter) && isInDateRange(item)
        );

        const successful = summaryTransactions.filter(item =>
            ['paid','success','berhasil','approved','completed','lunas'].includes(String(statusValue(item)).toLowerCase())
        );
        const revenue = successful.reduce((sum, item) => sum + (Number(amountValue(item)) || 0), 0);

        document.getElementById('totalTransactions').textContent = summaryTransactions.length;
        document.getElementById('successfulTransactions').textContent = successful.length;
        document.getElementById('totalRevenue').textContent = money(revenue);

        const filtered = transactions.filter(item => {
            const searchText = [
                item.id, memberName(item), item.user?.email, typeValue(item),
                item.pt?.pt_name, item.pt?.user?.name
            ].join(' ').toLowerCase();
            return searchText.includes(keyword) &&
                (!statusFilter || statusValue(item) === statusFilter) &&
                (!typeFilter || typeValue(item) === typeFilter) &&
                isInDateRange(item);
        });

        if (!filtered.length) {
            tableBody.innerHTML = `<tr><td colspan="7" class="empty">${transactions.length ? 'Tidak ada transaksi yang sesuai dengan filter.' : 'Belum ada transaksi yang tercatat.'}</td></tr>`;
        } else {
            tableBody.innerHTML = filtered.map(item => {
                const status = statusValue(item);
                return `<tr>
                    <td><span class="primary-text">#${escapeHtml(item.id ?? '-')}</span></td>
                    <td>
                        <span class="primary-text">${escapeHtml(memberName(item))}</span>
                        <span class="secondary-text">${escapeHtml(item.user?.email || '-')}</span>
                    </td>
                    <td>${escapeHtml(typeValue(item))}</td>
                    <td>${escapeHtml(formatDate(dateValue(item)))}</td>
                    <td><span class="primary-text">${escapeHtml(money(amountValue(item)))}</span></td>
                    <td><span class="pill ${statusClass(status)}">${escapeHtml(status)}</span></td>
                    <td><div class="action-buttons">
                        <button class="action-btn" type="button" onclick="showTransactionDetail(${Number(item.id)})">Detail</button>
                    </div></td>
                </tr>`;
            }).join('');
        }

        document.getElementById('resultCount').textContent =
            `Menampilkan ${filtered.length} dari ${transactions.length} transaksi`;
    }

    function showTransactionDetail(id) {
        const item = transactions.find(transaction => Number(transaction.id) === Number(id));
        if (!item) return;

        const details = [
            ['ID Transaksi', item.id],
            ['Nama Member', memberName(item)],
            ['Email Member', item.user?.email || '-'],
            ['Jenis Transaksi', typeValue(item)],
            ['Tanggal Transaksi', formatDate(dateValue(item))],
            ['Nominal', money(amountValue(item))],
            ['Status', statusValue(item)],
            ['Personal Trainer', item.pt?.pt_name || item.pt?.user?.name || '-'],
            ['ID Member', item.user_id],
            ['ID PT', item.pt_id],
            ['Catatan', firstValue(item, ['catatan', 'keterangan', 'description'])]
        ];

        document.getElementById('transactionDetailContent').innerHTML = details.map(([label, value]) =>
            `<dt>${escapeHtml(label)}</dt><dd>${escapeHtml(value)}</dd>`
        ).join('');
        document.getElementById('transactionDetailModal').classList.add('show');
    }

    function closeTransactionDetail() {
        document.getElementById('transactionDetailModal').classList.remove('show');
    }

    document.getElementById('searchInput').addEventListener('input', renderTransactions);
    document.getElementById('statusFilter').addEventListener('change', renderTransactions);
    document.getElementById('typeFilter').addEventListener('change', renderTransactions);
    document.getElementById('dateFrom').addEventListener('change', renderTransactions);
    document.getElementById('dateTo').addEventListener('change', renderTransactions);
    document.getElementById('resetFilters').addEventListener('click', () => {
        document.getElementById('searchInput').value = '';
        document.getElementById('statusFilter').value = '';
        document.getElementById('typeFilter').value = '';
        document.getElementById('dateFrom').value = '';
        document.getElementById('dateTo').value = '';
        renderTransactions();
    });
    document.getElementById('transactionDetailModal').addEventListener('click', event => {
        if (event.target.id === 'transactionDetailModal') closeTransactionDetail();
    });

    loadTransactions();
</script>
</body>
</html>
