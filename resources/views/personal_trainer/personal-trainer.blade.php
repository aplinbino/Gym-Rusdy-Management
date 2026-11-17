<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Personal Trainer | IRONHUB</title>
<style>
:root{--bg:#101510;--surface:#192119;--surface2:#202c20;--line:#344233;--lime:#c8f169;--text:#f4f6ef;--muted:#aab4a7;--gold:#f3c66d}
*{box-sizing:border-box;margin:0;padding:0}
body{font-family:Inter,Arial,sans-serif;background:var(--bg);color:var(--text);min-height:100vh}
button,input,select{font:inherit}
.topbar{height:72px;background:#151e15;border-bottom:1px solid var(--line);display:flex;align-items:center;justify-content:space-between;padding:0 28px;position:sticky;top:0;z-index:5}
.brand{display:flex;align-items:center;gap:11px;font-weight:900;letter-spacing:2px;font-size:19px}
.logo{height:38px;width:38px;border-radius:9px;background:var(--lime);color:#101510;display:grid;place-items:center;font-size:22px;font-weight:900}
.top-right{display:flex;align-items:center;gap:18px;font-size:11px;color:var(--muted)}
.role{color:var(--lime);font-weight:800;letter-spacing:1.3px}
.avatar{width:36px;height:36px;border-radius:50%;background:#52634b;display:grid;place-items:center;font-weight:800;color:white}
.layout{display:flex;min-height:calc(100vh - 72px)}
.sidebar{width:245px;flex-shrink:0;background:#151e15;border-right:1px solid var(--line);padding:25px 15px}
.side-label{font-size:10px;letter-spacing:1.5px;color:#82907e;font-weight:800;margin:5px 10px 13px}
.nav{display:flex;align-items:center;gap:12px;width:100%;padding:13px 12px;border:0;border-radius:8px;background:transparent;color:var(--muted);text-align:left;cursor:pointer;font-size:13px;margin-bottom:5px}
.nav:hover,.nav.active{background:#293b25;color:var(--lime)}
.nav .ico{width:20px;text-align:center;font-size:16px}
.sidebar-note{margin:28px 5px 0;padding:15px;border:1px solid var(--line);border-radius:10px;color:var(--muted);font-size:11px;line-height:1.7}
.sidebar-note strong{display:block;color:var(--lime);margin-bottom:4px}
main{flex:1;min-width:0;padding:32px}
.page-head{margin-bottom:23px}
.eyebrow{color:var(--lime);font-size:10px;font-weight:800;letter-spacing:2px}
h1{font-size:27px;margin:9px 0 7px}
.page-head p{font-size:12px;color:var(--muted);line-height:1.6}
.hero{padding:25px;border:1px solid var(--line);border-radius:13px;background:linear-gradient(110deg,#263824,#192119 75%);display:flex;align-items:center;justify-content:space-between;gap:20px;margin-bottom:20px}
.hero small{color:var(--lime);font-size:10px;font-weight:800;letter-spacing:1.5px}
.hero h2{font-size:22px;margin:8px 0}
.hero p{font-size:12px;color:var(--muted);line-height:1.6;max-width:570px}
.active-pill{border:1px solid #647a43;color:var(--lime);padding:10px 13px;border-radius:8px;font-size:10px;white-space:nowrap}
.stats{display:grid;grid-template-columns:repeat(4,1fr);gap:14px;margin-bottom:20px}
.stat,.panel{background:var(--surface);border:1px solid var(--line);border-radius:11px}
.stat{padding:18px}.stat span{font-size:11px;color:var(--muted)}.stat strong{display:block;font-size:27px;color:var(--lime);margin:9px 0 4px}.stat small{font-size:10px;color:#82907e}
.columns{display:grid;grid-template-columns:minmax(0,1.4fr) minmax(260px,.8fr);gap:17px;align-items:start}
.panel{padding:19px;margin-bottom:17px}
.panel-head{display:flex;justify-content:space-between;align-items:center;gap:10px;margin-bottom:16px}
.panel-head h2{font-size:15px}.sub{font-size:10px;color:var(--muted);margin-top:5px}
.btn{border:0;border-radius:7px;padding:10px 13px;font-size:10px;font-weight:800;cursor:pointer;transition:.15s}
.btn:hover{opacity:.86;transform:translateY(-1px)}.primary{background:var(--lime);color:#101510}.secondary{background:#303b30;color:var(--text)}.outline{background:transparent;border:1px solid var(--line);color:var(--text)}
.session-list{display:grid;gap:10px}
.session{display:grid;grid-template-columns:62px minmax(0,1fr) auto;gap:12px;align-items:center;background:#141c14;border:1px solid #2c392b;border-radius:9px;padding:12px}
.date{background:#293b25;border-radius:7px;text-align:center;padding:8px 4px}.date b{display:block;color:var(--lime);font-size:18px}.date span{font-size:9px;color:var(--muted)}
.session-info b{font-size:11px}.session-info p{font-size:10px;color:var(--muted);margin-top:5px;line-height:1.5}
.time{font-size:10px;color:var(--lime);font-weight:800;white-space:nowrap}
.badge{display:inline-block;padding:4px 7px;border-radius:20px;font-size:9px;font-weight:800;background:#304326;color:var(--lime)}
.member-list{display:grid;gap:12px}
.member{display:flex;align-items:center;gap:10px;padding-bottom:11px;border-bottom:1px solid #303b30}.member:last-child{border:0;padding:0}
.member-pic{width:35px;height:35px;border-radius:50%;background:#40533d;display:grid;place-items:center;font-size:10px;font-weight:800}
.member-detail{flex:1}.member-detail b{display:block;font-size:11px}.member-detail span{font-size:10px;color:var(--muted)}
.progress{height:5px;background:#303b30;border-radius:9px;margin-top:6px;overflow:hidden}.progress i{display:block;height:100%;background:var(--lime)}
.table-wrap{overflow-x:auto}table{width:100%;border-collapse:collapse;min-width:560px}th{text-align:left;padding:12px;background:#111a11;color:var(--lime);font-size:10px}td{padding:13px 12px;border-bottom:1px solid #303b30;font-size:11px;color:#e2e9df}
.week{display:grid;grid-template-columns:repeat(7,minmax(90px,1fr));gap:8px;overflow-x:auto}.day{background:#141c14;border:1px solid #2c392b;border-radius:8px;padding:10px;min-height:112px}.day h3{font-size:10px;color:var(--lime);margin-bottom:10px}.event{background:#293b25;border-left:2px solid var(--lime);padding:7px;border-radius:4px;margin-bottom:6px}.event b{display:block;font-size:9px}.event span{font-size:9px;color:var(--muted)}
.profile-card{display:flex;gap:18px;align-items:center;margin-bottom:20px}.profile-large{width:82px;height:82px;border-radius:50%;background:#40533d;display:grid;place-items:center;font-size:24px;font-weight:800}
.profile-card h2{font-size:19px;margin-bottom:5px}.profile-card p{font-size:11px;color:var(--muted)}
.info-table{width:100%;min-width:0}.info-table td:first-child{color:var(--muted);width:34%}
.review-list{display:grid;gap:13px}
.review-card{background:#141c14;border:1px solid #2c392b;border-radius:9px;padding:15px}
.review-top,.review-person{display:flex;align-items:center;justify-content:space-between;gap:12px}
.review-person{justify-content:flex-start}
.review-person b{display:block;font-size:11px}
.review-person span{display:block;color:var(--muted);font-size:10px;margin-top:4px}
.stars{color:var(--gold);font-size:14px;letter-spacing:2px;white-space:nowrap}
.stars span{color:#566052}
.review-program{font-size:9px;color:var(--lime);margin:12px 0 8px}
.review-comment{font-size:11px;color:#dce4d8;line-height:1.7}
.trainer-reply{margin-top:13px;padding:11px 12px;background:#263524;border-left:2px solid var(--lime);border-radius:5px}
.trainer-reply b{font-size:9px;color:var(--lime);text-transform:uppercase;letter-spacing:1px}
.trainer-reply p{font-size:10px;color:var(--muted);line-height:1.6;margin-top:5px}
.rating-big{text-align:center;padding:8px 0 20px;border-bottom:1px solid var(--line);margin-bottom:17px}
.rating-big strong{display:block;font-size:42px;color:var(--text)}
.rating-big .stars{margin:5px 0}
.rating-big span{display:block;font-size:10px;color:var(--muted)}
.rating-row{display:grid;grid-template-columns:40px 1fr 18px;gap:9px;align-items:center;margin:12px 0;font-size:10px;color:var(--muted)}
.rating-row .progress{margin:0;height:7px}
.rating-row b{color:var(--text);text-align:right}
.review-tip{background:#263524;border-radius:8px;padding:13px;margin-top:22px}
.review-tip b{font-size:10px;color:var(--lime)}
.review-tip p{font-size:10px;color:var(--muted);line-height:1.6;margin-top:6px}
footer{border-top:1px solid var(--line);padding:18px;text-align:center;color:#82907e;font-size:10px}
.modal-bg{position:fixed;inset:0;background:#000b;display:none;align-items:center;justify-content:center;padding:18px;z-index:10}.modal-bg.show{display:flex}
.modal{width:100%;max-width:440px;background:var(--surface);border:1px solid var(--line);border-radius:12px;padding:22px}.modal h2{font-size:17px;margin-bottom:17px}.field{margin-bottom:13px}.field label{display:block;color:var(--muted);font-size:10px;margin-bottom:6px}.field input,.field select{width:100%;padding:11px;background:var(--bg);border:1px solid var(--line);border-radius:7px;color:white}.actions{display:flex;justify-content:flex-end;gap:8px;margin-top:18px}
@media(max-width:1000px){.stats{grid-template-columns:repeat(2,1fr)}.columns{grid-template-columns:1fr}}
@media(max-width:700px){.topbar{padding:0 15px}.layout{display:block}.sidebar{width:100%;display:flex;gap:5px;overflow-x:auto;padding:10px;position:sticky;top:72px;z-index:4;border-right:0;border-bottom:1px solid var(--line)}.side-label,.sidebar-note{display:none}.nav{white-space:nowrap;width:auto;flex-shrink:0;margin:0;padding:10px}.nav .ico{display:none}main{padding:22px 14px}.hero{align-items:flex-start;flex-direction:column}.stats{gap:9px}.stat{padding:13px}.stat strong{font-size:23px}.columns{display:block}.session{grid-template-columns:55px minmax(0,1fr)}.time{grid-column:2}}
</style>
</head>
<body>
<header class="topbar">
 <div class="brand"><span class="logo">I</span> IRONHUB</div>
 <div class="top-right"><span class="role">PERSONAL TRAINER</span><div class="avatar">AR</div><span>Andi Ramadhan</span></div>
</header>
<div class="layout">
 <aside class="sidebar">
  <div class="side-label">MENU PERSONAL TRAINER</div>
  <button class="nav active" data-page="dashboard"><span class="ico">▦</span>Dashboard</button>
  <button class="nav" data-page="jadwal"><span class="ico">▣</span>Jadwal Latihan</button>
  <button class="nav" data-page="anggota"><span class="ico">♙</span>Anggota Saya</button>
  <button class="nav" data-page="review"><span class="ico">★</span>Review Member</button>
  <button class="nav" data-page="profil"><span class="ico">✦</span>Profil Saya</button>
  <div class="sidebar-note"><strong>IRONHUB TRAINER</strong>Kelola jadwal latihan dan pantau perkembangan anggota dengan lebih mudah.</div>
 </aside>
 <main id="content"></main>
</div>
<footer>© 2026 IRONHUB FITNESS CLUB · TRAIN HARD. STAY HUMBLE. KEEP GROWING.</footer>
<div class="modal-bg" id="modal">
 <form class="modal" id="form">
  <h2 id="modalTitle">Tambah Jadwal Latihan</h2>
  <div class="field"><label>Nama Anggota</label><input id="member" required placeholder="Nama anggota"></div>
  <div class="field"><label>Hari</label><select id="day"><option>Senin</option><option>Selasa</option><option>Rabu</option><option>Kamis</option><option>Jumat</option><option>Sabtu</option><option>Minggu</option></select></div>
  <div class="field"><label>Jam Mulai</label><input type="time" id="start" required></div>
  <div class="field"><label>Jam Selesai</label><input type="time" id="end" required></div>
  <div class="field"><label>Rincian Latihan</label><select id="workout"><option>Upper Body</option><option>Lower Body</option><option>Push Day</option><option>Pull Day</option><option>Leg Day</option><option>Full Body</option><option>Cardio</option></select></div>
  <div class="actions"><button type="button" class="btn secondary" onclick="closeModal()">Batal</button><button class="btn primary">Simpan Jadwal</button></div>
 </form>
</div>
<script>
const days=["Senin","Selasa","Rabu","Kamis","Jumat","Sabtu","Minggu"];
let schedules=[
{id:1,day:"Senin",date:"23 Nov",member:"Budi Santoso",time:"10:00 - 12:00",workout:"Upper Body"},
{id:2,day:"Senin",date:"23 Nov",member:"Siti Aminah",time:"14:00 - 15:00",workout:"Lower Body"},
{id:3,day:"Selasa",date:"24 Nov",member:"Andi Pratama",time:"09:00 - 11:00",workout:"Push Day"},
{id:4,day:"Rabu",date:"25 Nov",member:"Rizky Maulana",time:"13:00 - 14:00",workout:"Pull Day"},
{id:5,day:"Jumat",date:"27 Nov",member:"Budi Santoso",time:"10:00 - 12:00",workout:"Leg Day"}
];
const members=[
{name:"Budi Santoso",plan:"Membership 6 Bulan",goal:"Meningkatkan massa otot",progress:75,initial:"BS"},
{name:"Siti Aminah",plan:"Membership 3 Bulan",goal:"Menurunkan berat badan",progress:55,initial:"SA"},
{name:"Andi Pratama",plan:"Membership 1 Tahun",goal:"Meningkatkan kekuatan",progress:82,initial:"AP"},
{name:"Rizky Maulana",plan:"Membership 3 Bulan",goal:"Membangun kebugaran",progress:40,initial:"RM"}
];
const reviews=[
{id:1,name:"Budi Santoso",initial:"BS",date:"12 November 2026",rating:5,program:"Personal Training · Upper / Lower",comment:"Latihannya terarah dan mudah dipahami. Coach Andi juga selalu memperhatikan teknik gerakan agar tidak salah posisi. Progress kekuatan saya terasa meningkat."},
{id:2,name:"Siti Aminah",initial:"SA",date:"10 November 2026",rating:4,program:"Personal Training · Weight Loss",comment:"Coach-nya sabar dan program latihannya disesuaikan dengan kemampuan saya. Akan lebih bagus kalau variasi latihan cardio ditambah."},
{id:3,name:"Andi Pratama",initial:"AP",date:"8 November 2026",rating:5,program:"Personal Training · Strength",comment:"Penjelasan setiap gerakan detail, jadwal juga selalu tepat waktu. Sangat membantu untuk memperbaiki teknik squat dan bench press."},
{id:4,name:"Rizky Maulana",initial:"RM",date:"5 November 2026",rating:4,program:"Personal Training · Fitness",comment:"Sesi latihan cukup menantang tapi tetap aman. Coach memberikan arahan yang jelas dan rutin mengevaluasi perkembangan."}
];
let page="dashboard",editId=null;
const content=document.getElementById("content");
function heading(k,t,d){return `<section class="page-head"><div class="eyebrow">${k}</div><h1>${t}</h1><p>${d}</p></section>`}
function sessions(list){return list.map(s=>`<div class="session"><div class="date"><b>${s.date.split(" ")[0]}</b><span>${s.date.split(" ")[1]}</span></div><div class="session-info"><b>${s.member}</b><p>${s.day} · ${s.workout}<br><span class="badge">Dikonfirmasi</span></p></div><div class="time">${s.time}</div></div>`).join("")||'<div class="empty">Belum ada jadwal latihan.</div>'}
function week(){return `<div class="week">${days.map(d=>`<div class="day"><h3>${d.toUpperCase()}</h3>${schedules.filter(s=>s.day===d).map(s=>`<div class="event"><b>${s.time}</b><span>${s.member}<br>${s.workout}</span></div>`).join("")||'<span style="font-size:10px;color:var(--muted)">Kosong</span>'}</div>`).join("")}</div>`}
function memberCards(){return members.map(m=>`<div class="member"><div class="member-pic">${m.initial}</div><div class="member-detail"><b>${m.name}</b><span>${m.goal}</span><div class="progress"><i style="width:${m.progress}%"></i></div></div></div>`).join("")}
function dashboard(){
content.innerHTML=heading("TRAINER DASHBOARD","Dashboard Personal Trainer","Pantau jadwal latihan, anggota, dan aktivitas coaching kamu di IRONHUB.")+
`<section class="hero"><div><small>WELCOME BACK, COACH</small><h2>Siap melatih hari ini, Andi?</h2><p>Pastikan setiap anggota mendapatkan sesi latihan yang terarah. Periksa jadwal dan sesuaikan program latihan sesuai kebutuhan mereka.</p></div><div class="active-pill">● TRAINER AKTIF</div></section>
<section class="stats">
<div class="stat"><span>Total Anggota</span><strong>${members.length}</strong><small>Anggota yang kamu latih</small></div>
<div class="stat"><span>Jadwal Minggu Ini</span><strong>${schedules.length}</strong><small>Total sesi latihan</small></div>
<div class="stat"><span>Jadwal Hari Senin</span><strong>${schedules.filter(s=>s.day==="Senin").length}</strong><small>Sesi terjadwal</small></div>
<div class="stat"><span>Jam Melatih</span><strong>10 <small>jam</small></strong><small>Estimasi minggu ini</small></div></section>
<div class="columns"><section class="panel"><div class="panel-head"><h2>Jadwal Latihan Terdekat</h2><button class="btn outline" onclick="navigate('jadwal')">Lihat semua</button></div><div class="session-list">${sessions(schedules.slice(0,4))}</div></section>
<section class="panel"><div class="panel-head"><h2>Anggota Saya</h2><button class="btn outline" onclick="navigate('anggota')">Lihat</button></div><div class="member-list">${memberCards()}</div></section></div>
<section class="panel"><div class="panel-head"><h2>Ringkasan Mingguan</h2><span class="sub">Jadwal berdasarkan hari</span></div>${week()}</section>`;
}
function schedulePage(){
content.innerHTML=heading("MANAJEMEN LATIHAN","Jadwal Latihan","Lihat dan sesuaikan jadwal latihan anggota yang berada di bawah bimbinganmu.")+
`<section class="panel"><div class="panel-head"><div><h2>Daftar Jadwal</h2><p class="sub">Kelola sesi latihan mingguan.</p></div><button class="btn primary" onclick="openModal()">+ Tambah Jadwal</button></div>
<div class="table-wrap"><table><thead><tr><th>HARI / TANGGAL</th><th>ANGGOTA</th><th>JAM</th><th>PROGRAM LATIHAN</th><th>STATUS</th><th>AKSI</th></tr></thead><tbody>${schedules.map(s=>`<tr><td>${s.day}, ${s.date}</td><td>${s.member}</td><td>${s.time}</td><td>${s.workout}</td><td><span class="badge">Dikonfirmasi</span></td><td><button class="btn secondary" onclick="editSchedule(${s.id})">Ubah</button> <button class="btn secondary" onclick="deleteSchedule(${s.id})">Hapus</button></td></tr>`).join("")}</tbody></table></div></section>
<section class="panel"><div class="panel-head"><h2>Kalender Mingguan</h2><span class="sub">Tampilan jadwal per hari</span></div>${week()}</section>`;
}
function memberPage(){
content.innerHTML=heading("MANAJEMEN ANGGOTA","Anggota Saya","Daftar member yang mengikuti program latihan personal bersamamu.")+
`<section class="stats"><div class="stat"><span>Total Anggota</span><strong>${members.length}</strong></div><div class="stat"><span>Program Aktif</span><strong>${members.length}</strong></div><div class="stat"><span>Rata-rata Progres</span><strong>${Math.round(members.reduce((a,m)=>a+m.progress,0)/members.length)}%</strong></div><div class="stat"><span>Jadwal Terdaftar</span><strong>${schedules.length}</strong></div></section>
<section class="panel"><div class="panel-head"><h2>Daftar Anggota</h2><input id="search" placeholder="Cari anggota..." style="max-width:180px;width:100%;padding:9px;background:var(--bg);color:white;border:1px solid var(--line);border-radius:7px" oninput="filterMembers(this.value)"></div><div class="table-wrap"><table><thead><tr><th>NAMA ANGGOTA</th><th>PAKET MEMBERSHIP</th><th>TUJUAN LATIHAN</th><th>PROGRES PROGRAM</th></tr></thead><tbody id="memberRows">${memberRows(members)}</tbody></table></div></section>`;
}
function memberRows(list){return list.map(m=>`<tr><td><b>${m.name}</b></td><td>${m.plan}</td><td>${m.goal}</td><td><div style="display:flex;align-items:center;gap:8px"><div class="progress" style="width:90px"><i style="width:${m.progress}%"></i></div>${m.progress}%</div></td></tr>`).join("")||'<tr><td colspan="4">Anggota tidak ditemukan.</td></tr>'}
function filterMembers(q){document.getElementById("memberRows").innerHTML=memberRows(members.filter(m=>(m.name+" "+m.plan+" "+m.goal).toLowerCase().includes(q.toLowerCase())))}
function reviewPage(){
const average=(reviews.reduce((sum,r)=>sum+r.rating,0)/reviews.length).toFixed(1);
const distribution=[5,4,3,2,1].map(star=>({star,count:reviews.filter(r=>r.rating===star).length}));
content.innerHTML=heading("FEEDBACK ANGGOTA","Review Member","Lihat penilaian dan masukan dari anggota yang mengikuti program personal training.")+`<style>.review-stats{grid-template-columns:repeat(2,minmax(0,1fr))}</style>`+
`<section class="stats review-stats">
<div class="stat"><span>Rating Rata-rata</span><strong>${average} <small style="color:var(--gold)">★</small></strong><small>Dari ${reviews.length} review</small></div>
<div class="stat"><span>Total Review</span><strong>${reviews.length}</strong><small>Feedback dari anggota</small></div>
</section>
<div class="columns">
<section class="panel"><div class="panel-head"><div><h2>Ulasan dari Member</h2><p class="sub">Masukan berdasarkan pengalaman latihan bersama kamu.</p></div><span class="badge">Terbaru</span></div>
<div class="review-list">${reviews.map(r=>`<article class="review-card">
<div class="review-top"><div class="review-person"><div class="member-pic">${r.initial}</div><div><b>${r.name}</b><span>${r.date}</span></div></div><div class="stars" aria-label="${r.rating} dari 5 bintang">${"★".repeat(r.rating)}<span>${"★".repeat(5-r.rating)}</span></div></div>
<div class="review-program">${r.program}</div><p class="review-comment">“${r.comment}”</p>

</article>`).join("")}</div></section>
<aside class="panel"><div class="panel-head"><h2>Ringkasan Rating</h2></div>
<div class="rating-big"><strong>${average}</strong><div class="stars">★★★★★</div><span>${reviews.length} ulasan member</span></div>
${distribution.map(d=>`<div class="rating-row"><span>${d.star} ★</span><div class="progress"><i style="width:${reviews.length?d.count/reviews.length*100:0}%"></i></div><b>${d.count}</b></div>`).join("")}
<div class="review-tip"><b>Tips untuk Coach</b><p>Baca setiap masukan member sebagai bahan evaluasi program latihan dan kualitas coaching.</p></div>
</aside></div>`;
}
function profilePage(){
content.innerHTML=heading("AKUN TRAINER","Profil Saya","Informasi profil personal trainer yang ditampilkan kepada anggota IRONHUB.")+
`<section class="panel" style="max-width:750px"><div class="profile-card"><div class="profile-large">AR</div><div><h2>Andi Ramadhan</h2><p>Personal Trainer · IRONHUB</p><span class="badge" style="margin-top:9px">Trainer Aktif</span></div></div><div class="table-wrap"><table class="info-table"><tbody><tr><td>Email</td><td>andi.ramadhan@ironhub.test</td></tr><tr><td>Nomor HP</td><td>0812-3456-7890</td></tr><tr><td>Pengalaman</td><td>5 Tahun</td></tr><tr><td>Split Gym</td><td>PPL · Upper / Lower</td></tr><tr><td>Tarif PT</td><td>Rp 500.000 / bulan</td></tr><tr><td>Deskripsi</td><td>Membantu anggota membangun kekuatan, meningkatkan teknik latihan, dan mencapai target kebugaran melalui program yang terstruktur.</td></tr></tbody></table></div><p class="sub" style="margin-top:15px">Data profil ini merupakan contoh tampilan.</p></section>`;
}
function navigate(p){page=p;document.querySelectorAll(".nav").forEach(b=>b.classList.toggle("active",b.dataset.page===p));render()}
document.querySelectorAll(".nav").forEach(b=>b.addEventListener("click",()=>navigate(b.dataset.page)));
function render(){if(page==="dashboard")dashboard();if(page==="jadwal")schedulePage();if(page==="anggota")memberPage();if(page==="review")reviewPage();if(page==="profil")profilePage()}
function openModal(s=null){editId=s?s.id:null;document.getElementById("modalTitle").textContent=s?"Ubah Jadwal Latihan":"Tambah Jadwal Latihan";document.getElementById("member").value=s?.member||"";document.getElementById("day").value=s?.day||"Senin";document.getElementById("start").value=s?.time?.split(" - ")[0]||"10:00";document.getElementById("end").value=s?.time?.split(" - ")[1]||"12:00";document.getElementById("workout").value=s?.workout||"Upper Body";document.getElementById("modal").classList.add("show")}
function closeModal(){document.getElementById("modal").classList.remove("show")}
function editSchedule(id){openModal(schedules.find(s=>s.id===id))}
function deleteSchedule(id){if(confirm("Hapus jadwal latihan ini?")){schedules=schedules.filter(s=>s.id!==id);render()}}
document.getElementById("form").addEventListener("submit",e=>{e.preventDefault();let s={id:editId||Date.now(),member:document.getElementById("member").value.trim(),day:document.getElementById("day").value,date:"30 Nov",time:document.getElementById("start").value+" - "+document.getElementById("end").value,workout:document.getElementById("workout").value};if(editId)schedules=schedules.map(x=>x.id===editId?s:x);else schedules.push(s);closeModal();render()});
document.getElementById("modal").addEventListener("click",e=>{if(e.target===e.currentTarget)closeModal()});
render();
</script>
</body>
</html>