<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>IRONHUB — Member Dashboard</title>
<style>
:root{--bg:#0b100e;--panel:#121a16;--panel2:#18231d;--line:#29372e;--text:#edf4ee;--muted:#91a196;--lime:#b8f34a;--lime2:#d4ff82;--danger:#ff7777;--radius:18px}
*{box-sizing:border-box}body{margin:0;background:var(--bg);color:var(--text);font-family:Inter,Segoe UI,Arial,sans-serif}button,input,select{font:inherit}
.app{display:block;min-height:100vh}.brand{display:flex;align-items:center;gap:11px;font-size:19px;font-weight:900;letter-spacing:1px;padding:0 10px}.brand-mark{height:37px;width:37px;border-radius:11px;background:var(--lime);color:#172016;display:grid;place-items:center;font-size:20px}.nav-label{color:#66766b;font-size:10px;font-weight:800;letter-spacing:1.5px;padding:0 12px;margin-bottom:8px}.nav{display:grid;gap:6px}.nav a{display:flex;align-items:center;gap:12px;padding:12px;border-radius:11px;color:#a9b7ad;text-decoration:none;font-size:13px;font-weight:650}.nav a.active,.nav a:hover{background:#213128;color:var(--lime)}.nav-icon{width:19px;text-align:center;font-size:16px}.sidebar-bottom{margin-top:auto;border:1px solid var(--line);background:var(--panel);border-radius:14px;padding:14px}.sidebar-bottom small{color:var(--muted)}.sidebar-bottom strong{display:block;margin:7px 0;color:var(--lime);font-size:13px}
main{padding:30px 38px 50px;max-width:1500px;width:100%;margin:0 auto}.topbar{display:flex;align-items:center;justify-content:space-between;margin-bottom:30px}.breadcrumb{color:var(--muted);font-size:12px}.top-actions{display:flex;align-items:center;gap:14px}.icon-btn{height:40px;width:40px;border:1px solid var(--line);border-radius:12px;background:var(--panel);color:var(--text);cursor:pointer}.avatar{height:39px;width:39px;border-radius:50%;background:#304638;color:var(--lime);display:grid;place-items:center;font-weight:800}.welcome{display:flex;justify-content:space-between;align-items:flex-end;gap:20px;margin-bottom:25px}.eyebrow{font-size:10px;color:var(--lime);letter-spacing:1.8px;font-weight:800}.welcome h1{font-size:30px;margin:8px 0 7px;letter-spacing:-.8px}.welcome p{color:var(--muted);margin:0;font-size:13px}.primary{background:var(--lime);color:#152015;border:0;border-radius:11px;padding:12px 17px;font-size:12px;font-weight:850;cursor:pointer;transition:.2s}.primary:hover{background:var(--lime2);transform:translateY(-1px)}.secondary{background:#25352b;color:var(--lime);border:1px solid #3b5141;border-radius:10px;padding:10px 13px;font-weight:750;font-size:11px;cursor:pointer}.grid-stats{display:grid;grid-template-columns:repeat(4,1fr);gap:14px;margin-bottom:18px}.stat,.card{background:var(--panel);border:1px solid var(--line);border-radius:var(--radius)}.stat{padding:17px}.stat-head{display:flex;align-items:center;justify-content:space-between;color:var(--muted);font-size:11px}.stat-icon{height:31px;width:31px;display:grid;place-items:center;background:#24352a;color:var(--lime);border-radius:9px;font-size:15px}.stat strong{display:block;font-size:24px;margin:13px 0 4px}.stat small{color:var(--muted);font-size:10px}.content-grid{display:grid;grid-template-columns:minmax(0,1.55fr) minmax(280px,.9fr);gap:17px}.card{padding:20px;margin-bottom:17px}.card-title{display:flex;justify-content:space-between;align-items:center;gap:12px;margin-bottom:17px}.card-title h2{font-size:15px;margin:0}.subtle{color:var(--muted);font-size:11px}.membership{background:linear-gradient(120deg,#1e3327,#142019 75%);border:1px solid #3a563f;position:relative;overflow:hidden}.membership:after{content:"";position:absolute;width:190px;height:190px;border:1px solid #426044;border-radius:50%;right:-55px;top:-85px;box-shadow:0 0 0 22px #ffffff05,0 0 0 45px #ffffff03}.membership-top{display:flex;justify-content:space-between;align-items:center;position:relative;z-index:1}.pill{font-size:9px;font-weight:850;padding:6px 9px;border-radius:20px;background:#29432e;color:var(--lime)}.membership h2{font-size:23px;margin:16px 0 5px}.membership p{font-size:11px;color:#b3c3b6;margin:0}.progress{height:7px;background:#34483a;border-radius:20px;margin:18px 0 9px;overflow:hidden}.progress span{display:block;width:34%;height:100%;background:var(--lime);border-radius:20px}.membership-foot{display:flex;justify-content:space-between;color:#b6c7b9;font-size:10px}.trainer-row{display:flex;gap:13px;align-items:center}.trainer-photo{height:54px;width:54px;border-radius:13px;background:linear-gradient(145deg,#455b4a,#1c2b21);display:grid;place-items:center;font-size:24px}.trainer-info{flex:1}.trainer-info strong{font-size:13px;display:block;margin-bottom:5px}.trainer-info small{font-size:10px;color:var(--muted)}.tag{font-size:9px;padding:5px 8px;border:1px solid #405845;border-radius:20px;color:var(--lime);white-space:nowrap}.session-list{display:grid;gap:10px}.session{display:flex;align-items:center;gap:12px;padding:12px;background:#17221b;border:1px solid #29382e;border-radius:13px}.datebox{width:47px;min-width:47px;background:#2a3d2d;border-radius:10px;text-align:center;padding:7px 4px}.datebox b{display:block;color:var(--lime);font-size:18px}.datebox small{font-size:8px;color:#c1d0c3;font-weight:800}.session-details{flex:1;min-width:0}.session-details strong{font-size:12px;display:block;margin-bottom:5px}.session-details small{font-size:10px;color:var(--muted)}.session-status{font-size:9px;color:var(--lime);white-space:nowrap}.empty{border:1px dashed #405044;border-radius:13px;padding:22px;text-align:center;color:var(--muted);font-size:11px}.split-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:9px}.split{border:1px solid var(--line);background:#17221b;border-radius:12px;padding:13px 9px;text-align:center;cursor:pointer;color:var(--text);transition:.18s}.split:hover,.split.selected{border-color:var(--lime);background:#243629}.split .emoji{font-size:21px;display:block;margin-bottom:8px}.split b{font-size:11px;display:block}.split small{font-size:9px;color:var(--muted);display:block;margin-top:5px}.split.selected b{color:var(--lime)}.modal-backdrop{position:fixed;inset:0;background:#000b;display:none;align-items:center;justify-content:center;padding:18px;z-index:10}.modal-backdrop.show{display:flex}.modal{width:min(530px,100%);background:#111a14;border:1px solid #405344;border-radius:20px;padding:24px;box-shadow:0 25px 80px #0009}.modal-head{display:flex;justify-content:space-between;align-items:center;margin-bottom:7px}.modal h2{font-size:19px;margin:0}.close{background:transparent;border:0;color:var(--muted);font-size:23px;cursor:pointer}.modal p{font-size:11px;color:var(--muted);line-height:1.6;margin:8px 0 18px}.field{display:grid;gap:7px;margin-top:15px}.field label{font-size:10px;color:#b8c7bb;font-weight:750}.field input,.field select{width:100%;background:#1b2820;border:1px solid #3b4b3e;border-radius:10px;padding:12px;color:var(--text);outline:none}.field input:focus,.field select:focus{border-color:var(--lime)}.modal-actions{display:flex;justify-content:flex-end;gap:9px;margin-top:22px}
.inactive-state{text-align:center;padding:58px 25px;margin-top:10px}
.inactive-icon{width:66px;height:66px;display:grid;place-items:center;margin:0 auto 20px;background:#293622;color:var(--lime);border-radius:50%;font-size:27px;font-weight:900}
.inactive-state h2{font-size:22px;margin-bottom:12px}
.inactive-state p{max-width:470px;margin:0 auto 23px;color:var(--muted);font-size:13px;line-height:1.7}
.inactive-button{display:inline-flex;text-decoration:none}
.toast{position:fixed;bottom:22px;right:22px;background:#263b2b;color:var(--lime);border:1px solid #4b684d;padding:13px 17px;border-radius:12px;font-size:12px;display:none;z-index:20}.toast.show{display:block}.mobile-nav{display:none}
@media(max-width:1050px){.grid-stats{grid-template-columns:repeat(2,1fr)}.content-grid{grid-template-columns:1fr}}
@media(max-width:700px){.app{display:block}main{padding:20px 16px 90px}.topbar{margin-bottom:24px}.welcome{align-items:flex-start;flex-direction:column}.welcome h1{font-size:25px}.grid-stats{gap:9px}.stat{padding:13px}.stat strong{font-size:21px}.split-grid{grid-template-columns:repeat(2,1fr)}.membership h2{font-size:21px}}
</style>
</head>
<body>
<div class="app">

<main id="dashboard">
  <div class="topbar"><div class="breadcrumb">Member Area <span style="color:#536257">/</span> Dashboard</div><div class="top-actions"><button class="icon-btn" aria-label="Notifikasi">♧</button><div class="avatar" id="profileAvatar">A</div></div></div>
  <section class="welcome"><div><div class="eyebrow">MEMBER DASHBOARD</div><h1 id="welcomeMessage">Halo, Alfin! 👋</h1><p>Progress dibangun dari konsistensi. Siap untuk sesi latihan berikutnya?</p></div><button class="primary" id="openBooking">＋ Atur Sesi Selanjutnya</button></section>
  <div id="activeDashboardContent">
  <section class="grid-stats">
    <div class="stat"><div class="stat-head">Sisa Membership <span class="stat-icon">◷</span></div><strong>182 Hari</strong><small>Berakhir 20 Mei 2027</small></div>
    <div class="stat"><div class="stat-head">Sisa Sesi PT <span class="stat-icon">♟</span></div><strong id="remainingSessions">8 Sesi</strong><small>Dari total 12 sesi</small></div>
    <div class="stat"><div class="stat-head">Sesi Selesai <span class="stat-icon">✓</span></div><strong id="completedSessions">4 Sesi</strong><small>Terus jaga konsistensi!</small></div>
    <div class="stat"><div class="stat-head">Personal Trainer <span class="stat-icon">✦</span></div><strong style="font-size:18px">Rizky P.</strong><small>Split program: PPL / UL</small></div>
  </section>
  <div class="content-grid">
    <div>
      <section class="card membership">
        <div class="membership-top"><span class="eyebrow">MEMBERSHIP KAMU</span><span class="pill">● ACTIVE</span></div>
        <h2>IRONHUB — 6 Bulan</h2><p>Keanggotaan aktif · Paket dengan Personal Trainer</p>
        <div class="progress"><span></span></div>
        <div class="membership-foot"><span>Mulai 20 November 2026</span><span>Berakhir 20 Mei 2027</span></div>
      </section>
      <section class="card" id="jadwal">
        <div class="card-title"><div><h2>Jadwal Latihan</h2><div class="subtle" style="margin-top:5px">Sesi PT yang sudah kamu jadwalkan</div></div><button class="secondary" id="openBooking2">＋ Pilih Sesi</button></div>
        <div class="session-list" id="sessionList">
          <div class="session"><div class="datebox"><b>22</b><small>NOV</small></div><div class="session-details"><strong>Upper Body</strong><small>10.00 – 11.00 WIB · Rizky Pratama</small></div><span class="session-status">Akan datang</span></div>
          <div class="session"><div class="datebox"><b>25</b><small>NOV</small></div><div class="session-details"><strong>Lower Body</strong><small>16.00 – 17.00 WIB · Rizky Pratama</small></div><span class="session-status">Terjadwal</span></div>
          <div class="session"><div class="datebox"><b>28</b><small>NOV</small></div><div class="session-details"><strong>Pull Day</strong><small>10.00 – 11.00 WIB · Rizky Pratama</small></div><span class="session-status">Terjadwal</span></div>
        </div>
      </section>
      <section class="card">
        <div class="card-title"><div><h2>Pilihan Jenis Sesi</h2><div class="subtle" style="margin-top:5px">Pilih fokus latihan saat mengatur sesi berikutnya</div></div></div>
        <div class="split-grid">
          <button class="split" data-split="Upper Body"><span class="emoji">💪</span><b>Upper Body</b><small>Dada, bahu, trisep</small></button>
          <button class="split" data-split="Lower Body"><span class="emoji">🦵</span><b>Lower Body</b><small>Kaki dan glutes</small></button>
          <button class="split" data-split="Pull Day"><span class="emoji">🏋️</span><b>Pull Day</b><small>Punggung dan bisep</small></button>
          <button class="split" data-split="Push Day"><span class="emoji">🔥</span><b>Push Day</b><small>Dada, bahu, trisep</small></button>
          <button class="split" data-split="Full Body"><span class="emoji">⚡</span><b>Full Body</b><small>Seluruh tubuh</small></button>
        </div>
      </section>
    </div>
    <div>
      <section class="card" id="pt">
        <div class="card-title"><h2>Personal Trainer Kamu</h2><span class="tag">PT AKTIF</span></div>
        <div class="trainer-row"><div class="trainer-photo">🏋️</div><div class="trainer-info"><strong>Rizky Pratama</strong><small>Program PPL / Upper-Lower</small></div></div>
        <div style="height:1px;background:var(--line);margin:17px 0"></div>
        <div style="display:flex;justify-content:space-between;margin-bottom:12px"><span class="subtle">Sesi digunakan</span><strong style="font-size:12px">4 / 12</strong></div>
        <div class="progress" style="margin:0 0 8px"><span style="width:33.33%"></span></div>
        <div class="subtle">8 sesi masih tersedia dalam paket PT kamu.</div>
      </section>
      <section class="card">
        <div class="card-title"><h2>Aktivitas Terakhir</h2></div>
        <div class="session-list">
          <div class="session"><div class="datebox"><b>18</b><small>NOV</small></div><div class="session-details"><strong>Push Day</strong><small>Sesi selesai · 10.00 WIB</small></div><span class="session-status">✓</span></div>
          <div class="session"><div class="datebox"><b>15</b><small>NOV</small></div><div class="session-details"><strong>Lower Body</strong><small>Sesi selesai · 16.00 WIB</small></div><span class="session-status">✓</span></div>
        </div>
      </section>
      <section class="card" id="profil">
        <div class="card-title"><h2>Informasi Member</h2><button class="secondary" onclick="alert('Fitur edit profil dapat dihubungkan ke Laravel nanti.')">Edit Profil</button></div>
        <div style="display:grid;gap:13px">
          <div><div class="subtle">Nama Lengkap</div><strong style="font-size:12px">Alfin Maulana Abiyudha</strong></div>
          <div><div class="subtle">Email</div><strong style="font-size:12px">alfin@email.com</strong></div>
          <div><div class="subtle">Nomor HP</div><strong style="font-size:12px">08xxxxxxxxxx</strong></div>
        </div>
      </section>
    </div>
  </div>
  </div>

  <section class="card inactive-state" id="inactiveMembership" style="display:none">
    <div class="inactive-icon">!</div>
    <h2>Membership Belum Aktif</h2>
    <p>
      Membership kamu belum aktif. Silakan aktifkan membership terlebih dahulu
      untuk mengakses dashboard, jadwal latihan, dan fasilitas member IRONHUB.
    </p>
    <a href="/membership" class="primary inactive-button">Aktifkan Membership</a>
  </section>

</main>
</div>


<div class="modal-backdrop" id="bookingModal">
  <div class="modal">
    <div class="modal-head"><h2>Atur Sesi Selanjutnya</h2><button class="close" id="closeModal">×</button></div>
    <p>Pilih jenis latihan yang ingin kamu lakukan bersama Rizky. Setelah itu, tentukan tanggal dan jam yang tersedia. Jadwal akan berstatus menunggu konfirmasi PT.</p>
    <div class="field"><label>JENIS LATIHAN</label>
      <div class="split-grid" id="modalSplits">
        <button class="split selected" data-modal-split="Upper Body"><span class="emoji">💪</span><b>Upper Body</b></button>
        <button class="split" data-modal-split="Lower Body"><span class="emoji">🦵</span><b>Lower Body</b></button>
        <button class="split" data-modal-split="Pull Day"><span class="emoji">🏋️</span><b>Pull Day</b></button>
        <button class="split" data-modal-split="Push Day"><span class="emoji">🔥</span><b>Push Day</b></button>
        <button class="split" data-modal-split="Full Body"><span class="emoji">⚡</span><b>Full Body</b></button>
      </div>
    </div>
    <div class="field"><label for="sessionDate">TANGGAL LATIHAN</label><input type="date" id="sessionDate" min="2026-11-20"></div>
    <div class="field"><label for="sessionTime">PILIH JAM</label><select id="sessionTime"><option value="08.00 – 09.00 WIB">08.00 – 09.00 WIB</option><option value="10.00 – 11.00 WIB">10.00 – 11.00 WIB</option><option value="13.00 – 14.00 WIB">13.00 – 14.00 WIB</option><option value="16.00 – 17.00 WIB">16.00 – 17.00 WIB</option></select></div>
    <div class="modal-actions"><button class="secondary" id="cancelBooking">Batal</button><button class="primary" id="saveBooking">Ajukan Jadwal</button></div>
  </div>
</div>
<div class="toast" id="toast">Jadwal berhasil diajukan.</div>
<script>
/*
  DATA DUMMY MEMBER
  Untuk mengetes tampilan:
  - active: true  -> tampilkan dashboard member + fitur PT
  - active: false -> tampilkan pesan membership belum aktif
  Nantinya object ini bisa diisi dari database Laravel.
*/
const userData = {
  name: "Alfin",
  membership: {
    active: true, // Ubah menjadi false untuk melihat tampilan membership nonaktif
    remainingDays: 182,
    expiredDate: "20 Mei 2027",
    plan: "6 Bulan"
  },
  personalTrainer: {
    name: "Rizky Pratama",
    remainingSessions: 8,
    totalSessions: 12
  }
};

function renderMembershipState() {
  const isActive = Boolean(userData.membership.active);
  document.getElementById("welcomeMessage").textContent =
    isActive ? `Halo, ${userData.name}! 👋` : `Halo, ${userData.name}!`;
  document.getElementById("profileName").textContent = userData.name.toUpperCase();
  document.getElementById("profileAvatar").textContent =
    userData.name.trim().charAt(0).toUpperCase();

  document.getElementById("activeDashboardContent").style.display =
    isActive ? "block" : "none";
  document.getElementById("inactiveMembership").style.display =
    isActive ? "none" : "block";

  if (isActive) {
    document.querySelector(".stat strong").textContent =
      `${userData.membership.remainingDays} Hari`;
    document.querySelector(".stat small").textContent =
      `Berakhir ${userData.membership.expiredDate}`;
    document.querySelector(".membership h2").textContent =
      `IRONHUB — ${userData.membership.plan}`;
    document.querySelector(".membership-foot span:last-child").textContent =
      `Berakhir ${userData.membership.expiredDate}`;
    document.getElementById("remainingSessions").textContent =
      `${userData.personalTrainer.remainingSessions} Sesi`;
    document.querySelector("#pt .trainer-info strong").textContent =
      userData.personalTrainer.name;
  }
}

renderMembershipState();

const modal=document.getElementById('bookingModal');
const open=()=>modal.classList.add('show');
const close=()=>modal.classList.remove('show');
document.getElementById('openBooking').onclick=open;
document.getElementById('openBooking2').onclick=open;
document.getElementById('closeModal').onclick=close;
document.getElementById('cancelBooking').onclick=close;
modal.addEventListener('click',e=>{if(e.target===modal)close()});
let selectedSplit='Upper Body';
document.querySelectorAll('[data-modal-split]').forEach(btn=>btn.addEventListener('click',()=>{
  document.querySelectorAll('[data-modal-split]').forEach(x=>x.classList.remove('selected'));
  btn.classList.add('selected');selectedSplit=btn.dataset.modalSplit;
}));
document.querySelectorAll('[data-split]').forEach(btn=>btn.addEventListener('click',()=>{
  document.querySelectorAll('[data-split]').forEach(x=>x.classList.remove('selected'));
  btn.classList.add('selected');selectedSplit=btn.dataset.split;open();
  document.querySelectorAll('[data-modal-split]').forEach(x=>x.classList.toggle('selected',x.dataset.modalSplit===selectedSplit));
}));
document.getElementById('saveBooking').addEventListener('click',()=>{
  const dateValue=document.getElementById('sessionDate').value;
  if(!dateValue){alert('Pilih tanggal latihan terlebih dahulu.');return;}
  const date=new Date(dateValue+'T00:00:00');
  const day=String(date.getDate()).padStart(2,'0');
  const month=date.toLocaleDateString('id-ID',{month:'short'}).replace('.','').toUpperCase();
  const time=document.getElementById('sessionTime').value;
  const item=document.createElement('div');item.className='session';
  item.innerHTML=`<div class="datebox"><b>${day}</b><small>${month}</small></div><div class="session-details"><strong>${selectedSplit}</strong><small>${time} · Rizky Pratama</small></div><span class="session-status">Menunggu</span>`;
  document.getElementById('sessionList').appendChild(item);
  close();const toast=document.getElementById('toast');toast.classList.add('show');setTimeout(()=>toast.classList.remove('show'),2600);
});
</script>
</body>
</html>