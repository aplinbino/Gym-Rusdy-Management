<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="theme-color" content="#101510">
<title>Admin Dashboard — IRONHUB</title>

<style>
* {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
}

:root {
    --bg: #101510;
    --panel: #192119;
    --panel2: #202c20;
    --border: #344233;
    --lime: #c8f169;
    --text: #f4f6ef;
    --muted: #aab4a7;
    --danger: #ef6868;
}

body {
    font-family: Arial, Helvetica, sans-serif;
    background: var(--bg);
    color: var(--text);
    min-height: 100vh;
}

/* HEADER */

header {
    height: 70px;
    background: #151e15;
    border-bottom: 1px solid var(--border);
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0 25px;
    position: sticky;
    top: 0;
    z-index: 10;
}

.brand {
    display: flex;
    align-items: center;
    gap: 12px;
    font-size: 19px;
    font-weight: 900;
    letter-spacing: 2px;
}

.mark {
    width: 38px;
    height: 38px;
    background: var(--lime);
    color: var(--bg);
    display: grid;
    place-items: center;
    border-radius: 9px;
    font-size: 22px;
}

.admin-profile {
    color: var(--lime);
    font-size: 13px;
    font-weight: bold;
}

.menu-toggle {
    display: none;
    background: none;
    color: white;
    border: none;
    font-size: 25px;
    cursor: pointer;
}

/* LAYOUT */

.layout {
    display: flex;
    min-height: calc(100vh - 70px);
}

.sidebar {
    width: 260px;
    flex-shrink: 0;
    background: #151e15;
    border-right: 1px solid var(--border);
    padding: 22px 15px;
}

.sidebar-search {
    width: 100%;
    padding: 12px;
    background: #101510;
    border: 1px solid var(--border);
    color: white;
    border-radius: 7px;
    margin-bottom: 25px;
}

.menu-label {
    font-size: 10px;
    color: #82907e;
    font-weight: bold;
    letter-spacing: 1.5px;
    margin: 22px 10px 10px;
}

.nav-item {
    width: 100%;
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 13px 12px;
    border: none;
    background: transparent;
    color: var(--muted);
    border-radius: 8px;
    cursor: pointer;
    font-size: 14px;
    text-align: left;
    margin-bottom: 5px;
    transition: .2s;
}

.nav-item:hover {
    background: #253225;
    color: var(--lime);
}

.nav-item.active {
    background: #293b25;
    color: var(--lime);
    font-weight: bold;
}

.nav-icon {
    width: 20px;
    font-size: 17px;
    text-align: center;
}

/* MAIN */

main {
    flex: 1;
    min-width: 0;
    padding: 35px;
}

.page-heading {
    margin-bottom: 28px;
}

.page-heading small {
    color: var(--lime);
    font-size: 11px;
    letter-spacing: 2px;
    font-weight: bold;
}

.page-heading h1 {
    font-size: 29px;
    margin: 10px 0;
}

.page-heading p {
    color: var(--muted);
    font-size: 13px;
}

/* DASHBOARD CARDS */

.stats {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 16px;
    margin-bottom: 25px;
}

.stat-card {
    background: var(--panel);
    border: 1px solid var(--border);
    border-radius: 12px;
    padding: 22px;
}

.stat-card small {
    color: var(--muted);
    font-size: 12px;
}

.stat-card h2 {
    color: var(--lime);
    font-size: 30px;
    margin-top: 13px;
}

/* TABLE CARD */

.card {
    background: var(--panel);
    border: 1px solid var(--border);
    border-radius: 12px;
    padding: 22px;
    margin-bottom: 20px;
}

.card-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 15px;
    margin-bottom: 20px;
}

.card-header h2 {
    font-size: 17px;
}

.toolbar {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
}

.search-input,
.filter-select {
    padding: 11px 13px;
    background: #101710;
    color: white;
    border: 1px solid var(--border);
    border-radius: 7px;
    outline: none;
    font-size: 12px;
}

.search-input:focus,
.filter-select:focus {
    border-color: var(--lime);
}

.btn {
    border: none;
    padding: 11px 15px;
    border-radius: 7px;
    font-size: 12px;
    font-weight: bold;
    cursor: pointer;
    transition: .2s;
}

.btn:hover {
    opacity: .85;
    transform: translateY(-1px);
}

.btn-primary {
    background: var(--lime);
    color: #101510;
}

.btn-edit {
    background: #354b2d;
    color: var(--lime);
}

.btn-delete {
    background: #482727;
    color: #ff8888;
}

.btn-secondary {
    background: #303b30;
    color: white;
}

/* TABLE */

.table-wrapper {
    width: 100%;
    overflow-x: auto;
}

table {
    width: 100%;
    border-collapse: collapse;
    min-width: 650px;
}

th {
    text-align: left;
    padding: 14px 12px;
    background: #111a11;
    color: var(--lime);
    font-size: 11px;
    letter-spacing: .5px;
    white-space: nowrap;
}

td {
    padding: 15px 12px;
    border-bottom: 1px solid #303b30;
    font-size: 12px;
    color: #e2e9df;
    white-space: nowrap;
}

tbody tr:hover {
    background: #202b20;
}

.action-buttons {
    display: flex;
    gap: 7px;
}

.action-buttons button {
    padding: 7px 10px;
    font-size: 11px;
}

.status {
    display: inline-block;
    padding: 6px 10px;
    border-radius: 20px;
    font-size: 10px;
    font-weight: bold;
}

.success {
    color: #c8f169;
    background: #304326;
}

.pending {
    color: #f3c66d;
    background: #453b25;
}

.inactive {
    color: #ff8585;
    background: #462727;
}

.empty {
    text-align: center;
    padding: 35px;
    color: var(--muted);
}

/* SCHEDULE TABS */

.tabs {
    display: flex;
    gap: 10px;
    margin-bottom: 20px;
    flex-wrap: wrap;
}

.tab {
    padding: 11px 18px;
    border: 1px solid var(--border);
    border-radius: 7px;
    background: transparent;
    color: var(--muted);
    cursor: pointer;
    font-size: 12px;
}

.tab.active {
    background: var(--lime);
    color: #101510;
    border-color: var(--lime);
    font-weight: bold;
}

/* MODAL */

.modal-overlay {
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,.75);
    display: none;
    align-items: center;
    justify-content: center;
    padding: 20px;
    z-index: 20;
}

.modal-overlay.show {
    display: flex;
}

.modal {
    background: #192119;
    border: 1px solid var(--border);
    border-radius: 14px;
    width: 100%;
    max-width: 500px;
    max-height: 90vh;
    overflow-y: auto;
    padding: 25px;
}

.modal h2 {
    margin-bottom: 22px;
    font-size: 20px;
}

.form-group {
    margin-bottom: 15px;
}

.form-group label {
    display: block;
    color: var(--muted);
    font-size: 12px;
    margin-bottom: 8px;
}

.form-group input,
.form-group select {
    width: 100%;
    padding: 12px;
    background: #101510;
    color: white;
    border: 1px solid var(--border);
    border-radius: 7px;
    outline: none;
}

.form-group input:focus,
.form-group select:focus {
    border-color: var(--lime);
}

.modal-actions {
    display: flex;
    justify-content: flex-end;
    gap: 10px;
    margin-top: 22px;
}

/* FOOTER */

footer {
    border-top: 1px solid var(--border);
    padding: 20px;
    text-align: center;
    color: #82907e;
    font-size: 11px;
}

/* RESPONSIVE */

@media(max-width: 950px) {
    .stats {
        grid-template-columns: repeat(2, 1fr);
    }

    main {
        padding: 25px 18px;
    }
}

@media(max-width: 650px) {
    .menu-toggle {
        display: block;
    }

    .sidebar {
        position: fixed;
        left: -270px;
        top: 70px;
        bottom: 0;
        z-index: 15;
        overflow-y: auto;
        transition: .3s;
    }

    .sidebar.open {
        left: 0;
    }

    main {
        width: 100%;
        padding: 25px 14px;
    }

    .stats {
        gap: 10px;
    }

    .stat-card {
        padding: 16px;
    }

    .stat-card h2 {
        font-size: 25px;
    }

    .card {
        padding: 15px;
    }

    .card-header {
        align-items: flex-start;
    }

    .search-input {
        width: 100%;
    }

    .toolbar {
        width: 100%;
    }

    .page-heading h1 {
        font-size: 24px;
    }
}
</style>
</head>

<body>

<!-- HEADER -->

<header>
    <div class="brand">
        <span class="mark">I</span>
        IRONHUB
    </div>

    <div class="admin-profile">
        ADMINISTRATOR
    </div>

    <button class="menu-toggle" onclick="toggleSidebar()">☰</button>
</header>

<div class="layout">

<!-- SIDEBAR -->

<aside class="sidebar" id="sidebar">

    <input
        type="text"
        class="sidebar-search"
        placeholder="Cari menu..."
        oninput="filterMenu(this.value)"
    >

    <div class="menu-label">MENU UTAMA</div>

    <button class="nav-item active" data-page="dashboard">
        <span class="nav-icon">▦</span>
        Dashboard
    </button>

    <div class="menu-label">MANAJEMEN DATA</div>

    <button class="nav-item" data-page="transaksi">
        <span class="nav-icon">▤</span>
        Data Transaksi
    </button>

    <button class="nav-item" data-page="users">
        <span class="nav-icon">♙</span>
        Data User
    </button>

    <button class="nav-item" data-page="trainers">
        <span class="nav-icon">✦</span>
        Personal Trainer
    </button>

    <button class="nav-item" data-page="jadwal">
        <span class="nav-icon">▦</span>
        Jadwal Personal Trainer
    </button>

    <div class="menu-label">AKUN</div>

    <button class="nav-item" onclick="logout()">
        <span class="nav-icon">⇥</span>
        Logout
    </button>

</aside>

<!-- MAIN CONTENT -->

<main id="mainContent"></main>

</div>

<footer>
    © 2026 IRONHUB FITNESS CLUB
    <br><br>
    Train Hard. Stay Humble. Keep Growing.
</footer>

<!-- MODAL -->

<div class="modal-overlay" id="modalOverlay">
    <div class="modal">
        <h2 id="modalTitle">Tambah Data</h2>

        <form id="dataForm">
            <div id="formFields"></div>

            <div class="modal-actions">
                <button type="button"
                    class="btn btn-secondary"
                    onclick="closeModal()">
                    Batal
                </button>

                <button type="submit" class="btn btn-primary">
                    Simpan Data
                </button>
            </div>
        </form>
    </div>
</div>

<script>

/* =====================================
   DATA DUMMY
   Nantinya dapat diganti dengan API
   atau database MySQL.
===================================== */

let transaksi = [
    {
        id: "TRX001",
        user: "Budi Santoso",
        produk: "Membership Premium",
        tanggal: "2026-11-20",
        total: "500000",
        status: "Berhasil"
    },
    {
        id: "TRX002",
        user: "Andi Pratama",
        produk: "Personal Trainer",
        tanggal: "2026-11-21",
        total: "250000",
        status: "Pending"
    },
    {
        id: "TRX003",
        user: "Siti Aminah",
        produk: "Membership Basic",
        tanggal: "2026-11-22",
        total: "300000",
        status: "Berhasil"
    }
];

let users = [
    {
        id: "USR001",
        nama: "Budi Santoso",
        email: "budi@gmail.com",
        hp: "081234567890",
        membership: "Premium",
        status: "Aktif"
    },
    {
        id: "USR002",
        nama: "Siti Aminah",
        email: "siti@gmail.com",
        hp: "082345678901",
        membership: "Basic",
        status: "Aktif"
    },
    {
        id: "USR003",
        nama: "Andi Pratama",
        email: "andi@gmail.com",
        hp: "083456789012",
        membership: "Tidak Ada",
        status: "Nonaktif"
    }
];

let trainers = [];

let schedules = [
    {
        id: "JDL001",
        trainer: "Andi Pratama",
        user: "Budi Santoso",
        tanggal: "2026-11-23",
        mulai: "10:00",
        selesai: "12:00",
        status: "Booking"
    },
    {
        id: "JDL002",
        trainer: "Rudi Hartono",
        user: "Siti Aminah",
        tanggal: "2026-11-25",
        mulai: "13:00",
        selesai: "15:00",
        status: "Booking"
    },
    {
        id: "JDL003",
        trainer: "Dimas Saputra",
        user: "-",
        tanggal: "2026-11-26",
        mulai: "09:00",
        selesai: "11:00",
        status: "Tersedia"
    },
    {
        id: "JDL004",
        trainer: "Andi Pratama",
        user: "-",
        tanggal: "2026-11-27",
        mulai: "14:00",
        selesai: "16:00",
        status: "Tersedia"
    }
];

/* =====================================
   PENGATURAN HALAMAN
===================================== */

let currentPage = "dashboard";
let scheduleTab = "Booking";
let currentSearch = "";
let editIndex = null;

const configs = {
    transaksi: {
        title: "Data Transaksi",
        description: "Kelola seluruh transaksi IRONHUB.",
        data: () => transaksi,
        columns: [
            ["id", "ID Transaksi"],
            ["user", "Nama User"],
            ["produk", "Produk"],
            ["tanggal", "Tanggal"],
            ["total", "Total"],
            ["status", "Status"]
        ],
        fields: [
            ["id", "ID Transaksi"],
            ["user", "Nama User"],
            ["produk", "Produk"],
            ["tanggal", "Tanggal", "date"],
            ["total", "Total Pembayaran", "number"],
            ["status", "Status", "select", ["Berhasil", "Pending", "Gagal"]]
        ]
    },

    users: {
        title: "Data User",
        description: "Kelola seluruh pengguna IRONHUB.",
        data: () => users,
        columns: [
            ["id", "ID User"],
            ["nama", "Nama"],
            ["email", "Email"],
            ["hp", "No. HP"],
            ["membership", "Membership"],
            ["status", "Status"]
        ],
        fields: [
            ["id", "ID User"],
            ["nama", "Nama Lengkap"],
            ["email", "Email", "email"],
            ["hp", "Nomor HP"],
            ["membership", "Membership"],
            ["status", "Status", "select", ["Aktif", "Nonaktif"]]
        ]
    },

    trainers: {
        title: "Data Personal Trainer",
        description: "Kelola akun dan profil Personal Trainer IRONHUB.",
        data: () => trainers,
        columns: [
            ["id", "ID"],
            ["nama", "Nama PT"],
            ["email", "Email"],
            ["hp", "No. HP"],
            ["split", "Split Gym"],
            ["tarif", "Harga/Sesi"],
            ["status", "Status"]
        ],
        fields: []
    },

    jadwal: {
        title: "Jadwal Personal Trainer",
        description: "Kelola seluruh jadwal personal trainer.",
        data: () => schedules,
        columns: [
            ["id", "ID Jadwal"],
            ["trainer", "Personal Trainer"],
            ["user", "Nama User"],
            ["tanggal", "Tanggal"],
            ["mulai", "Jam Mulai"],
            ["selesai", "Jam Selesai"],
            ["status", "Status"]
        ],
        fields: [
            ["id", "ID Jadwal"],
            ["trainer", "Nama Trainer"],
            ["user", "Nama User"],
            ["tanggal", "Tanggal", "date"],
            ["mulai", "Jam Mulai", "time"],
            ["selesai", "Jam Selesai", "time"],
            ["status", "Status Booking", "select", ["Booking", "Tersedia"]]
        ]
    }
};

/* =====================================
   SIDEBAR
===================================== */

document.querySelectorAll(".nav-item[data-page]").forEach(button => {
    button.addEventListener("click", () => {
        currentPage = button.dataset.page;
        currentSearch = "";

        document.querySelectorAll(".nav-item").forEach(item => {
            item.classList.remove("active");
        });

        button.classList.add("active");

        document.getElementById("sidebar").classList.remove("open");

        if (currentPage === "trainers") {
            loadTrainers();
        } else {
            renderPage();
        }
    });
});

function toggleSidebar() {
    document.getElementById("sidebar").classList.toggle("open");
}

function filterMenu(value) {
    document.querySelectorAll(".nav-item[data-page]").forEach(item => {
        item.style.display =
            item.textContent.toLowerCase().includes(value.toLowerCase())
            ? "flex" : "none";
    });
}

/* =====================================
   DASHBOARD
===================================== */

function renderDashboard() {

    document.getElementById("mainContent").innerHTML = `

        <section class="page-heading">
            <small>ADMIN DASHBOARD</small>
            <h1>Selamat Datang, Admin!</h1>
            <p>Kelola seluruh aktivitas IRONHUB melalui halaman ini.</p>
        </section>

        <section class="stats">

            <div class="stat-card">
                <small>Total Transaksi</small>
                <h2>${transaksi.length}</h2>
            </div>

            <div class="stat-card">
                <small>Total User</small>
                <h2>${users.length}</h2>
            </div>

            <div class="stat-card">
                <small>Personal Trainer</small>
                <h2>${trainers.length}</h2>
            </div>

            <div class="stat-card">
                <small>Jadwal Booking</small>
                <h2>${schedules.filter(s => s.status === "Booking").length}</h2>
            </div>

        </section>

        <section class="card">
            <div class="card-header">
                <h2>Ringkasan Jadwal Personal Trainer</h2>
            </div>

            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th>ID JADWAL</th>
                            <th>TRAINER</th>
                            <th>USER</th>
                            <th>TANGGAL</th>
                            <th>STATUS</th>
                        </tr>
                    </thead>

                    <tbody>
                        ${schedules.map(s => `
                            <tr>
                                <td>${s.id}</td>
                                <td>${s.trainer}</td>
                                <td>${s.user}</td>
                                <td>${s.tanggal}</td>
                                <td>${statusBadge(s.status)}</td>
                            </tr>
                        `).join("")}
                    </tbody>
                </table>
            </div>
        </section>
    `;
}

/* =====================================
   RENDER STATUS
===================================== */

function statusBadge(status) {

    let css = "pending";

    if (["Berhasil", "Aktif", "Booking"].includes(status)) {
        css = "success";
    }

    if (["Gagal", "Nonaktif"].includes(status)) {
        css = "inactive";
    }

    if (status === "Tersedia") {
        css = "pending";
    }

    return `<span class="status ${css}">${status}</span>`;
}

/* =====================================
   RENDER TABEL
===================================== */

async function loadTrainers() {
    try {
        const response = await fetch('/admin/pt', {
            headers: {
                'Accept': 'application/json'
            }
        });

        if (!response.ok) {
            throw new Error('Gagal mengambil data PT.');
        }

        const result = await response.json();

        trainers = result.map(pt => ({
            id: pt.id,
            user_id: pt.user_id,
            nama: pt.pt_name,
            email: pt.user.email,
            hp: pt.user.phone,
            split: pt.split_gym,
            tarif: pt.price_per_session,
            description: pt.description || '',
            status: pt.status === 'active' ? 'Aktif' : 'Nonaktif'
        }));

        renderPage();

    } catch (error) {
        console.error(error);
        alert('Tidak dapat mengambil data Personal Trainer.');
    }
}

function renderTable() {

    const config = configs[currentPage];

    let data = config.data();

    if (currentPage === "jadwal") {
        data = data.filter(item => item.status === scheduleTab);
    }

    const filtered = data.filter(item =>
        Object.values(item).some(value =>
            String(value).toLowerCase().includes(currentSearch.toLowerCase())
        )
    );

    let tableRows = filtered.map(item => {

        const realIndex = config.data().indexOf(item);

        return `
            <tr>
                ${config.columns.map(col => {

                    if (col[0] === "status") {
                        return `<td>${statusBadge(item[col[0]])}</td>`;
                    }

                    if (col[0] === "total" || col[0] === "tarif") {
                        return `<td>Rp ${Number(item[col[0]]).toLocaleString("id-ID")}</td>`;
                    }

                    return `<td>${item[col[0]]}</td>`;

                }).join("")}

                <td>
                    <div class="action-buttons">

                        <button class="btn btn-edit"
                            onclick="openEdit(${realIndex})">
                            Edit
                        </button>

                        <button class="btn btn-delete"
                            onclick="deleteData(${realIndex})">
                            Hapus
                        </button>

                    </div>
                </td>
            </tr>
        `;
    }).join("");

    if (filtered.length === 0) {
        tableRows = `
            <tr>
                <td colspan="${config.columns.length + 1}" class="empty">
                    Data tidak ditemukan.
                </td>
            </tr>
        `;
    }

    document.getElementById("tableBody").innerHTML = tableRows;
}

/* =====================================
   HALAMAN DATA
===================================== */

function renderDataPage() {

    const config = configs[currentPage];

    document.getElementById("mainContent").innerHTML = `

        <section class="page-heading">
            <small>MANAJEMEN DATA</small>
            <h1>${config.title}</h1>
            <p>${config.description}</p>
        </section>

        ${currentPage === "jadwal" ? `
            <div class="tabs">

                <button class="tab ${scheduleTab === "Booking" ? "active" : ""}"
                    onclick="changeScheduleTab('Booking')">
                    Sudah Booking
                </button>

                <button class="tab ${scheduleTab === "Tersedia" ? "active" : ""}"
                    onclick="changeScheduleTab('Tersedia')">
                    Belum Booking
                </button>

            </div>
        ` : ""}

        <section class="card">

            <div class="card-header">

                <h2>${currentPage === "jadwal"
                    ? scheduleTab === "Booking"
                        ? "Jadwal Sudah Booking"
                        : "Jadwal Belum Booking"
                    : config.title}</h2>

                <div class="toolbar">

                    <input
                        type="text"
                        class="search-input"
                        placeholder="Cari data..."
                        value="${currentSearch}"
                        oninput="searchData(this.value)"
                    >

                    <button class="btn btn-primary"
                        onclick="openAdd()">
                        + Tambah Data
                    </button>

                </div>

            </div>

            <div class="table-wrapper">

                <table>

                    <thead>
                        <tr>
                            ${config.columns.map(col =>
                                `<th>${col[1].toUpperCase()}</th>`
                            ).join("")}
                            <th>AKSI</th>
                        </tr>
                    </thead>

                    <tbody id="tableBody"></tbody>

                </table>

            </div>

        </section>
    `;

    renderTable();
}

/* =====================================
   NAVIGASI JADWAL
===================================== */

function changeScheduleTab(tab) {
    scheduleTab = tab;
    currentSearch = "";
    renderDataPage();
}

/* =====================================
   SEARCH
===================================== */

function searchData(value) {
    currentSearch = value;
    renderTable();
}

/* =====================================
   RENDER HALAMAN
===================================== */

function renderPage() {

    if (currentPage === "dashboard") {
        renderDashboard();
    } else {
        renderDataPage();
    }
}

/* =====================================
   TAMBAH DATA
===================================== */

function openAdd() {

    editIndex = null;

    document.getElementById("modalTitle").textContent =
        "Tambah " + configs[currentPage].title;

    renderForm({});

    document.getElementById("modalOverlay").classList.add("show");
}

/* =====================================
   EDIT DATA
===================================== */

function openEdit(index) {

    editIndex = index;

    const item = configs[currentPage].data()[index];

    document.getElementById("modalTitle").textContent =
        "Edit " + configs[currentPage].title;

    renderForm(item);

    document.getElementById("modalOverlay").classList.add("show");
}

/* =====================================
   FORM DINAMIS
===================================== */




function renderForm(item) {
    const formFields = document.getElementById("formFields");

    if (currentPage === "trainers") {
        const isEditing = editIndex !== null;

        formFields.innerHTML = `
            <div class="form-group">
                <label>Nama Lengkap</label>
                <input type="text" name="name" value="${item.nama || ""}" required>
            </div>

            <div class="form-group">
                <label>Nama Personal Trainer</label>
                <input type="text" name="pt_name" value="${item.pt_name || item.nama || ""}" required>
            </div>

            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" value="${item.email || ""}" required>
            </div>

            <div class="form-group">
                <label>Nomor HP</label>
                <input type="text" name="phone" value="${item.hp || ""}" required>
            </div>

            <div class="form-group">
                <label>Password ${isEditing ? "(Kosongkan jika tidak diubah)" : ""}</label>
                <input type="password" name="password" ${isEditing ? "" : "required"} minlength="8">
            </div>

            <div class="form-group">
                <label>Split Gym</label>
                <select name="split_gym" required>
                    ${["Push Day", "Pull Day", "Leg Day", "Upper Body", "Lower Body", "Full Body"].map(value => `
                        <option value="${value}" ${item.split === value ? "selected" : ""}>
                            ${value}
                        </option>
                    `).join("")}
                </select>
            </div>

            <div class="form-group">
                <label>Deskripsi</label>
                <input type="text" name="description" value="${item.description || ""}">
            </div>

            ${isEditing ? `
                <div class="form-group">
                    <label>Status</label>
                    <select name="status">
                        <option value="active" ${item.status === "Aktif" ? "selected" : ""}>Aktif</option>
                        <option value="inactive" ${item.status === "Nonaktif" ? "selected" : ""}>Nonaktif</option>
                    </select>
                </div>
            ` : ""}
        `;

        return;
    }

    const fields = configs[currentPage].fields;

    formFields.innerHTML = fields.map(field => {
        const [key, label, type, options] = field;
        let input = "";

        if (type === "select") {
            input = `
                <select name="${key}" required>
                    ${options.map(option => `
                        <option value="${option}" ${item[key] === option ? "selected" : ""}>
                            ${option}
                        </option>
                    `).join("")}
                </select>
            `;
        } else {
            input = `
                <input
                    type="${type || "text"}"
                    name="${key}"
                    value="${item[key] || ""}"
                    required
                >
            `;
        }

        return `
            <div class="form-group">
                <label>${label}</label>
                ${input}
            </div>
        `;
    }).join("");
}



/* =====================================
   SIMPAN DATA
===================================== */


document.getElementById("dataForm").addEventListener("submit", async function(e) {
    e.preventDefault();

    const formData = new FormData(this);
    const newData = Object.fromEntries(formData.entries());

    // Khusus Personal Trainer: simpan ke database Laravel
    if (currentPage === "trainers") {
        const isEditing = editIndex !== null;
        const trainerId = isEditing ? trainers[editIndex].id : null;

        if (isEditing && !newData.password) {
            delete newData.password;
        }

        const url = isEditing
            ? `/admin/pt/${trainerId}`
            : "/admin/pt";

        try {
            const response = await fetch(url, {
                method: isEditing ? "PUT" : "POST",
                headers: {
                    "Accept": "application/json",
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document.querySelector(
                        'meta[name="csrf-token"]'
                    ).content
                },
                body: JSON.stringify(newData)
            });

            const result = await response.json();

            if (!response.ok) {
                const validationErrors = result.errors
                    ? Object.values(result.errors).flat().join("\n")
                    : result.message;

                throw new Error(validationErrors || "Gagal menyimpan data PT.");
            }

            closeModal();
            await loadTrainers();

            alert(result.message);

        } catch (error) {
            console.error(error);
            alert(error.message || "Terjadi kesalahan saat menyimpan data.");
        }

        return;
    }

    // Penyimpanan data dummy untuk halaman lain
    const data = configs[currentPage].data();

    if (editIndex === null) {
        const duplicate = data.some(item => item.id === newData.id);

        if (duplicate) {
            alert("ID sudah digunakan. Gunakan ID lain.");
            return;
        }

        data.push(newData);
    } else {
        if (data.some((item, i) =>
            item.id === newData.id && i !== editIndex
        )) {
            alert("ID sudah digunakan oleh data lain.");
            return;
        }

        data[editIndex] = newData;
    }

    closeModal();
    renderPage();
});


/* =====================================
   HAPUS DATA
===================================== */

function deleteData(index) {

    const data = configs[currentPage].data();

    const confirmDelete = confirm(
        "Apakah kamu yakin ingin menghapus data ini?"
    );

    if (!confirmDelete) return;

    data.splice(index, 1);

    renderPage();
}

/* =====================================
   TUTUP MODAL
===================================== */

function closeModal() {

    document.getElementById("modalOverlay").classList.remove("show");

    document.getElementById("dataForm").reset();

    editIndex = null;
}

document.getElementById("modalOverlay").addEventListener("click", function(e) {
    if (e.target === this) {
        closeModal();
    }
});

/* =====================================
   LOGOUT
===================================== */

function logout() {

    const confirmLogout = confirm("Apakah kamu yakin ingin logout?");

    if (confirmLogout) {
        alert("Silakan hubungkan fungsi logout dengan sistem autentikasi.");
    }
}

/* =====================================
   JALANKAN APLIKASI
===================================== */

renderPage();

</script>

</body>
</html>
