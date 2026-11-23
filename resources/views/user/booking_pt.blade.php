<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>GYMBRO — Booking Personal Trainer</title>
<style>
:root{--bg:#101510;--panel:#171e18;--text:#f4f6ef;--muted:#aab4a7;--accent:#c8f169;--line:rgba(255,255,255,.12)}
*{box-sizing:border-box}body{margin:0;background:radial-gradient(ellipse at 85% 10%,#799d4b20,transparent 32%),#101510;color:var(--text);font-family:Inter,system-ui,Arial,sans-serif}
.wrap{width:min(1050px,calc(100% - 32px));margin:auto}header{height:76px;display:flex;align-items:center;justify-content:space-between;border-bottom:1px solid var(--line)}
.brand{font-weight:950;letter-spacing:.12em}.brand b{display:inline-grid;place-items:center;width:34px;height:34px;margin-right:8px;border-radius:9px;background:var(--accent);color:#101510}
a{color:var(--accent);text-decoration:none}.intro{padding:38px 0 22px}.eyebrow{font-size:10px;letter-spacing:.18em;color:var(--accent);font-weight:900}.intro h1{font-size:clamp(30px,5vw,46px);margin:10px 0}.intro p,.muted{color:var(--muted);font-size:13px;line-height:1.6}
.panel{background:#171e18e8;border:1px solid var(--line);border-radius:14px;padding:20px;margin:16px 0}
.pt-list{display:flex;gap:15px;overflow-x:auto;overflow-y:hidden;padding:4px 2px 14px;scroll-snap-type:x mandatory;scroll-behavior:smooth;-webkit-overflow-scrolling:touch;scrollbar-width:thin;scrollbar-color:var(--accent) rgba(255,255,255,.08)}
.pt-list::-webkit-scrollbar{height:7px}
.pt-list::-webkit-scrollbar-track{background:rgba(255,255,255,.08);border-radius:20px}
.pt-list::-webkit-scrollbar-thumb{background:var(--accent);border-radius:20px}
.pt{flex:0 0 260px;min-width:260px;scroll-snap-align:start;background:#121912;color:var(--text);border:1px solid var(--line);border-radius:13px;padding:0;text-align:left;cursor:pointer;overflow:hidden;transition:.2s}
.pt:hover{border-color:#819d56;transform:translateY(-2px)}
.pt.selected{border-color:var(--accent);background:#c8f16912;box-shadow:0 0 0 1px rgba(200,241,105,.2)}
.pt img{width:100%;height:175px;display:block;object-fit:cover;object-position:center 18%;filter:saturate(.85)}
.pt-info{padding:13px 14px 15px}
.pt strong{display:block;margin-bottom:7px;font-size:14px}
.pt small{color:var(--muted);font-size:12px}
.calendar-head{display:flex;justify-content:space-between;align-items:center;gap:12px}.calendar-head button{background:#121912;color:var(--accent);border:1px solid var(--line);border-radius:8px;padding:8px 12px;cursor:pointer}
.calendar{display:grid;grid-template-columns:repeat(7,1fr);gap:6px;margin-top:15px}.weekday{text-align:center;color:var(--muted);font-size:11px;padding:7px 0}.day{min-height:42px;background:#121912;color:var(--text);border:1px solid var(--line);border-radius:8px;cursor:pointer}.day:disabled{opacity:.2;cursor:not-allowed}.day.active{background:var(--accent);color:#101510;border-color:var(--accent);font-weight:900}.day.empty{visibility:hidden}
.slots{display:grid;grid-template-columns:repeat(auto-fit,minmax(180px,1fr));gap:9px;margin-top:14px}.slot{background:#121912;color:var(--text);border:1px solid var(--line);border-radius:9px;padding:13px;text-align:left;cursor:pointer}.slot.selected{border-color:var(--accent);background:#c8f16912}.slot small{display:block;color:var(--muted);margin-top:5px}.empty{padding:20px;text-align:center;border:1px dashed var(--line);border-radius:9px;color:var(--muted);font-size:12px}
.chosen{display:flex;flex-wrap:wrap;gap:8px;margin-top:12px}.chip{padding:8px 10px;border:1px solid #c8f16966;border-radius:20px;color:var(--accent);font-size:11px}
.summary{display:flex;justify-content:space-between;align-items:center;gap:15px;flex-wrap:wrap;border-top:1px solid var(--line);margin-top:18px;padding-top:17px}.total strong{display:block;color:var(--accent);font-size:25px;margin-top:4px}.pay{background:var(--accent);border:0;border-radius:9px;padding:14px 22px;font-weight:900;cursor:pointer}.pay:disabled{opacity:.4;cursor:not-allowed}
.errors{background:#ff77771a;border:1px solid #ff777766;color:#ffaaaa;padding:12px;border-radius:9px;font-size:12px;margin:12px 0}
@media(max-width:560px){.panel{padding:14px}.pt{flex-basis:82%;min-width:240px}.day{min-height:36px}.summary{align-items:stretch}.pay{width:100%}}
</style>
</head>
<body>
<div class="wrap">
<header>
  <div class="brand"><b>G</b>GYMBRO</div>
  <a href="{{ route('user.dashboard_user') }}">← Kembali ke Dashboard</a>
</header>
<section class="intro">
  <div class="eyebrow">MEMBER AREA / PERSONAL TRAINER</div>
  <h1>Booking Personal Trainer</h1>
  <p>Membership kamu tetap berjalan. Pilih PT dan slot latihan yang tersedia untuk membeli sesi tambahan.</p>
  <p>Harga booking: <strong style="color:var(--accent)">Rp100.000 per sesi</strong>.</p>
</section>

@if ($errors->any())
<div class="errors">
  @foreach ($errors->all() as $error)
    <div>{{ $error }}</div>
  @endforeach
</div>
@endif

<form method="POST" action="{{ route('member.pt-booking.store') }}" id="bookingForm">
@csrf
<input type="hidden" name="pt_id" id="ptId">
<section class="panel">
  <div class="eyebrow">01 / PILIH TRAINER</div>
  <h2>Pilih Personal Trainer</h2>
  <div class="pt-list" id="ptList">
    @forelse($pts as $pt)
      <button type="button" class="pt" data-id="{{ $pt->id }}">
        <img
          src="{{ $pt->photo ? asset('storage/' . $pt->photo) : asset('images/cuking_gym.png') }}"
          alt="Personal trainer {{ $pt->pt_name }}"
          onerror="this.onerror=null;this.src='{{ asset('images/cuking_gym.png') }}';"
        >
        <div class="pt-info">
          <strong>{{ $pt->pt_name }}</strong>
          <small>Rp100.000 per sesi</small>
        </div>
      </button>
    @empty
      <div class="empty">Belum ada PT aktif.</div>
    @endforelse
  </div>
</section>

<section class="panel">
  <div class="eyebrow">02 / PILIH JADWAL</div>
  <h2>Tanggal dan Jam Latihan</h2>
  <p class="muted">Pilih tanggal yang tersedia, lalu pilih satu atau beberapa sesi. Maksimal satu sesi per tanggal.</p>
  <div class="calendar-head">
    <button type="button" id="prev">‹</button>
    <strong id="monthLabel"></strong>
    <button type="button" id="next">›</button>
  </div>
  <div class="calendar" id="calendar"></div>
  <div class="slots" id="slots"><div class="empty">Pilih PT terlebih dahulu.</div></div>
  <div style="margin-top:18px"><strong>Slot yang dipilih</strong><div class="chosen" id="chosen"><span class="muted">Belum ada sesi dipilih.</span></div></div>
  <div class="summary">
    <div class="total">Jumlah sesi <strong id="count">0 sesi</strong></div>
    <div class="total">Total pembayaran <strong id="total">Rp0</strong></div>
    <button class="pay" id="pay" type="submit" disabled>Checkout PT ↗</button>
  </div>
</section>
</form>
</div>
<script>
const slots = @json($availabilities);
const fee = 100000;
let selectedPt = null, activeDate = null, selected = [];
let cursor = new Date(new Date().getFullYear(), new Date().getMonth(), 1);
const money = n => new Intl.NumberFormat('id-ID',{style:'currency',currency:'IDR',maximumFractionDigits:0}).format(n);
const key = d => `${d.getFullYear()}-${String(d.getMonth()+1).padStart(2,'0')}-${String(d.getDate()).padStart(2,'0')}`;
const dateText = k => new Intl.DateTimeFormat('id-ID',{weekday:'short',day:'numeric',month:'short',year:'numeric'}).format(new Date(k+'T00:00:00'));
const ptSlots = () => slots.filter(s => Number(s.pt_id) === Number(selectedPt));
const daySlots = k => ptSlots().filter(s => String(s.start_at).slice(0,10) === k);
const time = s => String(s.start_at).slice(11,16);
const endTime = s => String(s.end_at).slice(11,16);

document.querySelectorAll('.pt').forEach(btn => btn.addEventListener('click',()=>{
  document.querySelectorAll('.pt').forEach(x=>x.classList.remove('selected'));
  btn.classList.add('selected'); selectedPt=Number(btn.dataset.id);
  document.getElementById('ptId').value=selectedPt;
  selected=[]; activeDate=null; render(); renderSlots(); renderChosen();
}));

function render(){
  const cal=document.getElementById('calendar'), y=cursor.getFullYear(), m=cursor.getMonth();
  document.getElementById('monthLabel').textContent=new Intl.DateTimeFormat('id-ID',{month:'long',year:'numeric'}).format(cursor);
  const first=new Date(y,m,1).getDay(), days=new Date(y,m+1,0).getDate();
  let out=['Min','Sen','Sel','Rab','Kam','Jum','Sab'].map(x=>`<div class="weekday">${x}</div>`).join('');
  for(let i=0;i<first;i++) out+='<div class="day empty"></div>';
  for(let d=1;d<=days;d++){
    const k=key(new Date(y,m,d)), available=selectedPt && daySlots(k).length>0;
    const chosen=selected.some(s=>String(s.start_at).slice(0,10)===k);
    out+=`<button type="button" class="day${activeDate===k||chosen?' active':''}" data-date="${k}" ${available?'':'disabled'}>${d}</button>`;
  }
  cal.innerHTML=out;
  cal.querySelectorAll('[data-date]').forEach(b=>b.addEventListener('click',()=>{activeDate=b.dataset.date;render();renderSlots();}));
}
function renderSlots(){
  const el=document.getElementById('slots');
  if(!selectedPt){el.innerHTML='<div class="empty">Pilih PT terlebih dahulu.</div>';return;}
  if(!activeDate){el.innerHTML='<div class="empty">Pilih tanggal yang tersedia pada kalender.</div>';return;}
  const list=daySlots(activeDate);
  if(!list.length){el.innerHTML='<div class="empty">Tidak ada slot tersedia.</div>';return;}
  el.innerHTML=list.map(s=>{
    const chosen=selected.some(x=>Number(x.id)===Number(s.id));
    return `<button type="button" class="slot${chosen?' selected':''}" data-slot="${s.id}"><strong>${time(s)} – ${endTime(s)} WIB</strong><small>${chosen?'Dipilih ✓':'Pilih sesi'}</small></button>`;
  }).join('');
  el.querySelectorAll('[data-slot]').forEach(b=>b.addEventListener('click',()=>{
    const id=Number(b.dataset.slot), idx=selected.findIndex(x=>String(x.start_at).slice(0,10)===activeDate);
    if(idx>=0 && Number(selected[idx].id)===id) selected.splice(idx,1);
    else {const slot=list.find(x=>Number(x.id)===id);if(idx>=0)selected.splice(idx,1);selected.push(slot);}
    selected.sort((a,b)=>String(a.start_at).localeCompare(String(b.start_at)));
    render();renderSlots();renderChosen();
  }));
}
function renderChosen(){
  const el=document.getElementById('chosen');
  el.innerHTML=selected.length?selected.map((s,i)=>`<span class="chip">${dateText(String(s.start_at).slice(0,10))} · ${time(s)} WIB <button type="button" data-remove="${s.id}" style="background:none;border:0;color:inherit;cursor:pointer">×</button><input type="hidden" name="sessions[${i}][availability_id]" value="${s.id}"></span>`).join(''):'<span class="muted">Belum ada sesi dipilih.</span>';
  el.querySelectorAll('[data-remove]').forEach(b=>b.addEventListener('click',()=>{selected=selected.filter(s=>Number(s.id)!==Number(b.dataset.remove));render();renderSlots();renderChosen();}));
  document.getElementById('count').textContent=selected.length+' sesi';
  document.getElementById('total').textContent=money(selected.length*fee);
  document.getElementById('pay').disabled=!selectedPt||selected.length===0;
}
document.getElementById('prev').addEventListener('click',()=>{cursor=new Date(cursor.getFullYear(),cursor.getMonth()-1,1);render();});
document.getElementById('next').addEventListener('click',()=>{cursor=new Date(cursor.getFullYear(),cursor.getMonth()+1,1);render();});
document.getElementById('bookingForm').addEventListener('submit',e=>{if(!selectedPt||!selected.length){e.preventDefault();alert('Pilih PT dan minimal satu slot.');}});
render();renderChosen();
</script>
</body>
</html>
