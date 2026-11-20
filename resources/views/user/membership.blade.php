<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="theme-color" content="#101510" />
  <title>IRONHUB — Membership & Personal Trainer</title>
  <style>
    :root{--bg:#101510;--panel:#171e18;--panel2:#1d261e;--text:#f4f6ef;--muted:#aab4a7;--accent:#c8f169;--line:rgba(255,255,255,.12);--danger:#ff8c8c}
    *{box-sizing:border-box}html{scroll-behavior:smooth}body{margin:0;background:var(--bg);color:var(--text);font-family:Inter,ui-sans-serif,system-ui,-apple-system,"Segoe UI",sans-serif}
    button{font:inherit}.page{min-height:100vh;background:radial-gradient(ellipse at 85% 10%,rgba(121,157,75,.13),transparent 32%),linear-gradient(115deg,#101510,#111912 55%,#172018)}
    .container{width:min(1120px,calc(100% - 40px));margin:auto}header{height:82px;display:flex;align-items:center;justify-content:space-between;border-bottom:1px solid var(--line)}
    .brand{display:flex;align-items:center;gap:11px;font-weight:950;letter-spacing:.12em}.brand-mark{width:34px;height:34px;display:grid;place-items:center;color:#101510;background:var(--accent);border-radius:9px;font-size:20px;transform:skew(-8deg)}
    nav{display:flex;gap:28px;color:var(--muted);font-size:13px}nav a{color:inherit;text-decoration:none}.header-right{color:var(--muted);font-size:13px}
    .intro{padding:48px 0 30px}.eyebrow{color:var(--accent);font-size:11px;font-weight:900;letter-spacing:.2em;text-transform:uppercase}.intro h1{font-size:clamp(34px,5vw,54px);line-height:1.02;letter-spacing:-.055em;margin:13px 0}.intro h1 span{color:var(--accent)}.intro p{color:var(--muted);max-width:650px;line-height:1.7;margin:0}
    .section{margin:26px 0 34px}.section-head{display:flex;align-items:end;justify-content:space-between;gap:16px;margin-bottom:17px}.section h2{font-size:21px;letter-spacing:-.03em;margin:0}.section-sub{font-size:12px;color:var(--muted);margin-top:6px}.step{color:var(--accent);font-size:11px;font-weight:900;letter-spacing:.13em}
    .plans{display:grid;grid-template-columns:repeat(4,1fr);gap:13px}.plan{background:rgba(23,30,24,.88);border:1px solid var(--line);border-radius:12px;padding:19px;text-align:left;color:var(--text);cursor:pointer;transition:.2s;min-height:126px}.plan:hover,.trainer:hover,.slot:hover{border-color:rgba(200,241,105,.6);transform:translateY(-2px)}.plan.selected,.trainer.selected,.slot.selected{border-color:var(--accent);background:rgba(200,241,105,.08);box-shadow:0 0 0 1px rgba(200,241,105,.12)}.plan .duration{font-size:17px;font-weight:850}.plan .price{font-size:22px;font-weight:900;color:var(--accent);margin:12px 0 3px}.plan .per{font-size:11px;color:var(--muted)}
    .trainers{display:flex;gap:15px;overflow-x:auto;overflow-y:hidden;padding:2px 2px 14px;scroll-snap-type:x mandatory;scroll-behavior:smooth;-webkit-overflow-scrolling:touch;scrollbar-width:thin;scrollbar-color:var(--accent) rgba(255,255,255,.08)}.trainers::-webkit-scrollbar{height:7px}.trainers::-webkit-scrollbar-track{background:rgba(255,255,255,.08);border-radius:20px}.trainers::-webkit-scrollbar-thumb{background:var(--accent);border-radius:20px}.trainer{flex:0 0 calc((100% - 30px)/3);min-width:260px;scroll-snap-align:start;padding:0;overflow:hidden;text-align:left;color:var(--text);background:var(--panel);border:1px solid var(--line);border-radius:13px;cursor:pointer;transition:.2s}.trainer img{width:100%;height:190px;display:block;object-fit:cover;filter:saturate(.8)}.trainer-info{padding:16px}.trainer-top{display:flex;align-items:center;justify-content:space-between;gap:8px}.trainer h3{font-size:17px;margin:0}.tag{font-size:10px;color:var(--accent);border:1px solid rgba(200,241,105,.35);border-radius:20px;padding:5px 8px;white-space:nowrap}.trainer p{color:var(--muted);font-size:12px;line-height:1.6;margin:10px 0 12px;min-height:58px}.trainer-meta{display:flex;justify-content:space-between;color:var(--muted);font-size:11px}.trainer-meta strong{color:var(--text)}
    .schedule-wrap{background:rgba(23,30,24,.72);border:1px solid var(--line);border-radius:13px;padding:20px}.schedule-note{color:var(--muted);font-size:12px;margin:7px 0 16px}.slots{display:grid;grid-template-columns:repeat(2,1fr);gap:10px}.slot{display:flex;align-items:center;justify-content:space-between;gap:14px;text-align:left;color:var(--text);background:#121912;border:1px solid var(--line);border-radius:10px;padding:14px;cursor:pointer;transition:.2s}.slot-day{font-weight:800;font-size:13px}.slot-time{font-size:11px;color:var(--muted);margin-top:4px}.slot-workout{text-align:right;font-size:12px;color:var(--accent);font-weight:750}.empty{padding:26px;text-align:center;color:var(--muted);font-size:13px;border:1px dashed var(--line);border-radius:10px}

    .pt-options{margin-top:15px}
    .no-trainer{width:100%;display:flex;justify-content:space-between;align-items:center;gap:12px;padding:15px 17px;background:#121912;color:var(--text);border:1px dashed rgba(200,241,105,.45);border-radius:10px;text-align:left;cursor:pointer;font-weight:800;font-size:13px;transition:.2s}
    .no-trainer span{color:var(--muted);font-size:11px;font-weight:500}
    .no-trainer:hover,.no-trainer.selected{border-style:solid;border-color:var(--accent);background:rgba(200,241,105,.08)}
    .session-picker{margin-top:14px;padding:17px;background:rgba(23,30,24,.72);border:1px solid var(--line);border-radius:10px}
    .session-picker label{display:block;font-size:12px;font-weight:800;margin-bottom:9px}
    .session-picker select{width:100%;max-width:260px;padding:11px 12px;color:var(--text);background:#121912;border:1px solid var(--line);border-radius:8px;font:inherit}
    .session-picker p{font-size:10px;color:var(--muted);margin:9px 0 0}
    .session-picker.disabled{opacity:.45;pointer-events:none}

    .calendar-heading{display:flex;align-items:center;justify-content:space-between;gap:15px;flex-wrap:wrap}
    .calendar-heading label{display:block;font-size:12px;font-weight:850;margin-bottom:5px}
    .calendar-help{font-size:10px;color:var(--muted);line-height:1.55;margin:6px 0 0}
    .calendar-nav{display:flex;align-items:center;gap:10px}
    .calendar-nav strong{font-size:12px;min-width:115px;text-align:center}
    .calendar-nav button{width:30px;height:30px;border:1px solid var(--line);border-radius:7px;background:#121912;color:var(--accent);font-size:19px;cursor:pointer}
    .calendar{display:grid;grid-template-columns:repeat(7,minmax(0,1fr));gap:6px;margin-top:17px}
    .calendar-weekday{text-align:center;color:var(--muted);font-size:10px;font-weight:800;padding:5px 0}
    .calendar-day{min-height:39px;border:1px solid var(--line);border-radius:7px;background:#121912;color:var(--text);font-size:11px;cursor:pointer}
    .calendar-day:hover:not(:disabled){border-color:var(--accent)}
    .calendar-day.selected{background:var(--accent);border-color:var(--accent);color:#11170d;font-weight:900}
    .calendar-day:disabled{opacity:.22;cursor:not-allowed}
    .calendar-day.empty-day{visibility:hidden}
    .selected-dates{margin-top:16px;padding-top:13px;border-top:1px solid var(--line)}
    .selected-dates-head{display:flex;align-items:center;justify-content:space-between;gap:12px;font-size:11px}
    .selected-dates-head span{color:var(--accent);font-weight:850}
    .selected-dates-list{display:flex;flex-wrap:wrap;gap:7px;margin-top:10px;color:var(--muted);font-size:10px}
    .date-chip{padding:6px 9px;border:1px solid rgba(200,241,105,.35);border-radius:20px;color:var(--accent);background:rgba(200,241,105,.07)}
    @media(max-width:420px){.calendar{gap:4px}.calendar-day{min-height:35px}.calendar-heading{align-items:flex-start}.calendar-nav{width:100%;justify-content:space-between}}
    .summary{display:grid;grid-template-columns:1fr 330px;gap:20px;align-items:start;margin:36px 0 60px}.summary-info,.summary-card{background:rgba(23,30,24,.9);border:1px solid var(--line);border-radius:13px;padding:21px}.summary-info h2{font-size:20px;margin:0 0 8px}.summary-info p{color:var(--muted);font-size:12px;line-height:1.7;margin:0}.summary-card h3{font-size:15px;margin:0 0 17px}.line-item{display:flex;justify-content:space-between;gap:12px;color:var(--muted);font-size:12px;margin:12px 0}.line-item strong{color:var(--text);text-align:right}.total{border-top:1px solid var(--line);padding-top:15px;margin-top:16px;font-size:14px;color:var(--text);font-weight:850}.total strong{font-size:23px;color:var(--accent)}.pay{width:100%;border:0;border-radius:8px;background:var(--accent);color:#11170d;font-weight:950;padding:15px;margin-top:17px;cursor:pointer;transition:.2s}.pay:hover{background:#d8ff85;transform:translateY(-1px)}.pay:disabled{opacity:.4;cursor:not-allowed;transform:none}.fineprint{font-size:10px;color:var(--muted);line-height:1.5;margin:10px 0 0}.toast{display:none;margin-top:12px;padding:11px;border-radius:8px;background:rgba(200,241,105,.12);border:1px solid rgba(200,241,105,.3);color:var(--accent);font-size:12px}.toast.show{display:block}footer{border-top:1px solid var(--line);padding:20px 0 28px;color:#7f8a7c;font-size:10px;letter-spacing:.13em;display:flex;justify-content:space-between;gap:12px}
    @media(max-width:800px){.plans{grid-template-columns:repeat(2,1fr)}.trainer{flex-basis:calc((100% - 15px)/2)}.summary{grid-template-columns:1fr}.summary-card{max-width:none}}
    @media(max-width:560px){.container{width:calc(100% - 30px)}header{height:70px}nav{display:none}.intro{padding-top:35px}.trainer{flex-basis:85%;min-width:250px}.trainer img{height:220px}.slots{grid-template-columns:1fr}.section-head{align-items:start;flex-direction:column}.plan{padding:15px;min-height:115px}.plan .price{font-size:19px}footer{flex-direction:column}}
  </style>
</head>
<body>
<div class="page">
  <div class="container">
    <header>
      <a class="brand" href="#top"><span class="brand-mark">I</span><span>IRONHUB</span></a>
      <nav><a href="#membership">Membership</a><a href="#trainer">Personal Trainer</a><a href="#summary">Pembayaran</a></nav>
      <div class="header-right">MEMBER AREA&nbsp; / &nbsp;CHECKOUT</div>
    </header>

    <main id="top">
      <section class="intro">
        <div class="eyebrow">Build your strength</div>
        <h1>PILIH PROGRAM.<br><span>MULAI PROGRES.</span></h1>
        <p>Tentukan durasi membership, lalu pilih pendampingan personal trainer sesuai kebutuhan. Kamu juga bisa mengambil membership tanpa personal trainer.</p>
      </section>

      <section class="section" id="membership">
        <div class="section-head"><div><div class="step">01 / MEMBERSHIP</div><h2>Pilih durasi membership</h2><div class="section-sub">Semakin lama durasi membership, semakin hemat biaya per bulannya.</div></div></div>
        <div class="plans" id="plans">
          <button class="plan selected" data-months="1" data-price="350000"><div class="duration">1 Bulan</div><div class="price">Rp350.000</div><div class="per">Rp350.000 / bulan</div></button>
          <button class="plan" data-months="3" data-price="950000"><div class="duration">3 Bulan</div><div class="price">Rp950.000</div><div class="per">Rp316.667 / bulan</div></button>
          <button class="plan" data-months="6" data-price="1750000"><div class="duration">6 Bulan</div><div class="price">Rp1.750.000</div><div class="per">Rp291.667 / bulan</div></button>
          <button class="plan" data-months="12" data-price="3200000"><div class="duration">1 Tahun</div><div class="price">Rp3.200.000</div><div class="per">Rp266.667 / bulan</div></button>
        </div>
      </section>

      <section class="section" id="trainer">
        <div class="section-head"><div><div class="step">02 / PERSONAL TRAINER</div><h2>Pilih personal trainer</h2><div class="section-sub">Pilih trainer jika ingin didampingi, atau lanjutkan tanpa personal trainer. Biaya PT dihitung berdasarkan jumlah sesi.</div></div></div>
        <p class="calendar-help" style="margin:0 0 10px">Geser ke kanan atau kiri untuk melihat semua personal trainer.</p>\n        <div class="trainers" id="trainers">
          <button class="trainer" data-trainer="Rizky Pratama" data-fee="500000">
            <img src="https://images.unsplash.com/photo-1567013127542-490d757e51fc?auto=format&fit=crop&w=900&q=85" alt="Personal trainer Rizky sedang berlatih" />
            <div class="trainer-info"><div class="trainer-top"><h3>Rizky Pratama</h3><span class="tag">PPL</span></div><p>Fokus pada pembentukan otot dan progressive overload. Membantu member membangun rutinitas latihan yang konsisten.</p><div class="trainer-meta"><span>Pengalaman</span><strong>5 Tahun</strong></div><div class="trainer-meta" style="margin-top:7px"><span>Biaya PT</span><strong>Rp500.000 / sesi</strong></div></div>
          </button>
          <button class="trainer" data-trainer="Andi Saputra" data-fee="450000">
            <img src="https://images.unsplash.com/photo-1583454110551-21f2fa2afe61?auto=format&fit=crop&w=900&q=85" alt="Personal trainer Andi" />
            <div class="trainer-info"><div class="trainer-top"><h3>Andi Saputra</h3><span class="tag">UL</span></div><p>Berpengalaman mendampingi program upper-lower split, peningkatan kekuatan, dan perbaikan teknik gerakan.</p><div class="trainer-meta"><span>Pengalaman</span><strong>4 Tahun</strong></div><div class="trainer-meta" style="margin-top:7px"><span>Biaya PT</span><strong>Rp450.000 / sesi</strong></div></div>
          </button>
          <button class="trainer" data-trainer="Dimas Alvaro" data-fee="550000">
            <img src="https://images.unsplash.com/photo-1534438327276-14e5300c3a48?auto=format&fit=crop&w=900&q=85" alt="Personal trainer Dimas di gym" />
            <div class="trainer-info"><div class="trainer-top"><h3>Dimas Alvaro</h3><span class="tag">PPL / UL</span></div><p>Membantu member menyusun program latihan sesuai target, mulai dari membangun massa otot hingga kebugaran umum.</p><div class="trainer-meta"><span>Pengalaman</span><strong>6 Tahun</strong></div><div class="trainer-meta" style="margin-top:7px"><span>Biaya PT</span><strong>Rp550.000 / sesi</strong></div></div>
          </button>
          <button class="trainer" data-trainer="Arga Mahendra" data-fee="475000">
            <img src="https://images.unsplash.com/photo-1581009146145-b5ef050c2e1e?auto=format&fit=crop&w=900&q=85" alt="Personal trainer Arga sedang berlatih" />
            <div class="trainer-info"><div class="trainer-top"><h3>Arga Mahendra</h3><span class="tag">UL</span></div><p>Fokus pada peningkatan kekuatan tubuh bagian atas dan bawah, teknik latihan, serta progres beban bertahap.</p><div class="trainer-meta"><span>Pengalaman</span><strong>3 Tahun</strong></div><div class="trainer-meta" style="margin-top:7px"><span>Biaya PT</span><strong>Rp475.000 / sesi</strong></div></div>
          </button>
          <button class="trainer" data-trainer="Fajar Ramadhan" data-fee="500000">
            <img src="https://images.unsplash.com/photo-1583454110551-21f2fa2afe61?auto=format&fit=crop&w=900&q=85" alt="Personal trainer Fajar di gym" />
            <div class="trainer-info"><div class="trainer-top"><h3>Fajar Ramadhan</h3><span class="tag">PPL / UL</span></div><p>Mendampingi program pembentukan otot dan kebugaran dengan penyesuaian intensitas sesuai kemampuan member.</p><div class="trainer-meta"><span>Pengalaman</span><strong>5 Tahun</strong></div><div class="trainer-meta" style="margin-top:7px"><span>Biaya PT</span><strong>Rp500.000 / sesi</strong></div></div>
          </button>
        </div>
        <div class="pt-options">
          <button type="button" class="no-trainer" id="noTrainer">Lanjut tanpa Personal Trainer <span>Membership saja</span></button>
        </div>
        <div class="session-picker disabled" id="sessionPicker">
          <div class="calendar-heading">
            <div><label>Pilih tanggal sesi PT</label><p class="calendar-help" id="calendarRangeText">Pilih personal trainer dan durasi membership terlebih dahulu.</p></div>
            <div class="calendar-nav">
              <button type="button" id="prevMonth" aria-label="Bulan sebelumnya">‹</button>
              <strong id="calendarMonthLabel">Bulan</strong>
              <button type="button" id="nextMonth" aria-label="Bulan berikutnya">›</button>
            </div>
          </div>
          <div class="calendar" id="sessionCalendar"></div>
          <div class="selected-dates">
            <div class="selected-dates-head"><strong>Tanggal sesi dipilih</strong><span id="sessionCountLabel">0 sesi</span></div>
            <div id="selectedDatesList" class="selected-dates-list">Belum ada tanggal yang dipilih.</div>
          </div>
          <p class="calendar-help">Pilih beberapa tanggal pada kalender. Setiap tanggal yang dipilih dihitung sebagai satu sesi PT. Tanggal dibatasi sesuai masa membership.</p>
        </div>
      </section>

      <section class="summary" id="summary">
        <div class="summary-info"><div class="step">03 / ORDER SUMMARY</div><h2>Satu langkah lagi menuju progresmu.</h2><p>Periksa kembali pilihan membership dan personal trainer sebelum melanjutkan pembayaran. Total biaya akan diperbarui otomatis sesuai pilihanmu.</p></div>
        <div class="summary-card">
          <h3>Rincian pembayaran</h3>
          <div class="line-item"><span>Membership</span><strong id="membershipLabel">1 Bulan</strong></div>
          <div class="line-item"><span>Biaya membership</span><strong id="membershipCost">Rp350.000</strong></div>
          <div class="line-item"><span>Personal trainer</span><strong id="trainerLabel">Tanpa PT</strong></div>
          <div class="line-item"><span>Jumlah sesi PT</span><strong id="sessionLabel">0 sesi</strong></div>
          <div class="line-item"><span>Biaya PT</span><strong id="trainerCost">Rp0</strong></div>
          <div class="line-item total"><span>Total pembayaran</span><strong id="totalCost">Rp350.000</strong></div>
          <button class="pay" id="payButton" disabled>Bayar Sekarang&nbsp; ↗</button>
          <p class="fineprint">*Harga di halaman ini merupakan contoh untuk prototype. Integrasikan tombol pembayaran dengan payment gateway pada tahap backend.</p>
          <div class="toast" id="toast" role="status"></div>
        </div>
      </section>
      <footer><span>© 2026 IRONHUB FITNESS CLUB</span><span>TRAIN HARD · STAY HUMBLE · KEEP GROWING</span></footer>
    </main>
  </div>
</div>
<script>
  let selectedPlan = {months:1,price:350000};
  let selectedTrainer = null;
  let useTrainer = false;
  let selectedDates = [];
  let calendarCursor = new Date(new Date().getFullYear(), new Date().getMonth(), 1);

  const rupiah = value => new Intl.NumberFormat('id-ID',{style:'currency',currency:'IDR',maximumFractionDigits:0}).format(value);
  const trainerButtons = document.querySelectorAll('.trainer');
  const noTrainerButton = document.getElementById('noTrainer');
  const sessionPicker = document.getElementById('sessionPicker');

  const startDate = () => {
    const now = new Date();
    return new Date(now.getFullYear(), now.getMonth(), now.getDate());
  };
  const membershipEndDate = () => {
    const start = startDate();
    const end = new Date(start);
    end.setMonth(end.getMonth() + selectedPlan.months);
    return end;
  };
  const dateKey = date => {
    const y = date.getFullYear();
    const m = String(date.getMonth()+1).padStart(2,'0');
    const d = String(date.getDate()).padStart(2,'0');
    return `${y}-${m}-${d}`;
  };
  const parseDateKey = key => {
    const [y,m,d] = key.split('-').map(Number);
    return new Date(y,m-1,d);
  };
  const formatDate = key => new Intl.DateTimeFormat('id-ID',{weekday:'short',day:'numeric',month:'short',year:'numeric'}).format(parseDateKey(key));
  const monthName = date => new Intl.DateTimeFormat('id-ID',{month:'long',year:'numeric'}).format(date);

  document.querySelectorAll('.plan').forEach(button => button.addEventListener('click', () => {
    document.querySelectorAll('.plan').forEach(item => item.classList.remove('selected'));
    button.classList.add('selected');
    selectedPlan = {months:Number(button.dataset.months),price:Number(button.dataset.price)};
    // Keep only sessions that remain inside the newly selected membership period.
    const endKey = dateKey(membershipEndDate());
    selectedDates = selectedDates.filter(key => key >= dateKey(startDate()) && key < endKey);
    renderCalendar();
    updateSummary();
  }));

  trainerButtons.forEach(button => button.addEventListener('click', () => {
    trainerButtons.forEach(item => item.classList.remove('selected'));
    button.classList.add('selected');
    noTrainerButton.classList.remove('selected');
    selectedTrainer = {name:button.dataset.trainer,fee:Number(button.dataset.fee)};
    useTrainer = true;
    sessionPicker.classList.remove('disabled');
    renderCalendar();
    updateSummary();
  }));

  noTrainerButton.addEventListener('click', () => {
    trainerButtons.forEach(item => item.classList.remove('selected'));
    noTrainerButton.classList.add('selected');
    selectedTrainer = null;
    useTrainer = false;
    selectedDates = [];
    sessionPicker.classList.add('disabled');
    renderCalendar();
    updateSummary();
  });

  function renderCalendar(){
    const calendar = document.getElementById('sessionCalendar');
    const cursor = calendarCursor;
    const year = cursor.getFullYear();
    const month = cursor.getMonth();
    const firstDay = new Date(year,month,1).getDay();
    const daysInMonth = new Date(year,month+1,0).getDate();
    const minKey = dateKey(startDate());
    const maxKey = dateKey(membershipEndDate());

    document.getElementById('calendarMonthLabel').textContent = monthName(cursor);
    document.getElementById('calendarRangeText').textContent =
      `Masa berlaku pilihan: ${formatDate(minKey)} sampai ${formatDate(dateKey(new Date(membershipEndDate().getFullYear(),membershipEndDate().getMonth(),membershipEndDate().getDate()-1)))}.`;
    document.getElementById('prevMonth').disabled =
      new Date(year,month,1) <= new Date(startDate().getFullYear(),startDate().getMonth(),1);
    document.getElementById('nextMonth').disabled =
      new Date(year,month+1,1) >= new Date(membershipEndDate().getFullYear(),membershipEndDate().getMonth(),1);

    let markup = ['Min','Sen','Sel','Rab','Kam','Jum','Sab'].map(day=>`<div class="calendar-weekday">${day}</div>`).join('');
    for(let i=0;i<firstDay;i++) markup += '<div class="calendar-day empty-day"></div>';
    for(let day=1;day<=daysInMonth;day++){
      const date = new Date(year,month,day);
      const key = dateKey(date);
      const unavailable = key < minKey || key >= maxKey || !useTrainer;
      const selected = selectedDates.includes(key);
      markup += `<button type="button" class="calendar-day${selected?' selected':''}" data-date="${key}" ${unavailable?'disabled':''} aria-pressed="${selected}">${day}</button>`;
    }
    calendar.innerHTML = markup;
    calendar.querySelectorAll('[data-date]').forEach(button=>button.addEventListener('click',()=>{
      const key = button.dataset.date;
      if(selectedDates.includes(key)) selectedDates = selectedDates.filter(item=>item!==key);
      else selectedDates.push(key);
      selectedDates.sort();
      renderCalendar();
      updateSummary();
    }));

    const list = document.getElementById('selectedDatesList');
    list.innerHTML = selectedDates.length
      ? selectedDates.map(key=>`<span class="date-chip">${formatDate(key)}</span>`).join('')
      : 'Belum ada tanggal yang dipilih.';
    document.getElementById('sessionCountLabel').textContent = `${selectedDates.length} sesi`;
  }

  document.getElementById('prevMonth').addEventListener('click',()=>{
    calendarCursor = new Date(calendarCursor.getFullYear(),calendarCursor.getMonth()-1,1);
    renderCalendar();
  });
  document.getElementById('nextMonth').addEventListener('click',()=>{
    calendarCursor = new Date(calendarCursor.getFullYear(),calendarCursor.getMonth()+1,1);
    renderCalendar();
  });

  function updateSummary(){
    const sessionCount = useTrainer ? selectedDates.length : 0;
    const trainerFee = useTrainer && selectedTrainer ? selectedTrainer.fee * sessionCount : 0;
    document.getElementById('membershipLabel').textContent = selectedPlan.months===12?'1 Tahun':selectedPlan.months+' Bulan';
    document.getElementById('membershipCost').textContent = rupiah(selectedPlan.price);
    document.getElementById('trainerLabel').textContent = useTrainer && selectedTrainer ? selectedTrainer.name : 'Tanpa PT';
    document.getElementById('sessionLabel').textContent = sessionCount+' sesi';
    document.getElementById('trainerCost').textContent = rupiah(trainerFee);
    document.getElementById('totalCost').textContent = rupiah(selectedPlan.price + trainerFee);
    document.getElementById('payButton').disabled = useTrainer && (!selectedTrainer || selectedDates.length===0);
  }

  document.getElementById('payButton').addEventListener('click',()=>{
    const sessionCount = useTrainer ? selectedDates.length : 0;
    const trainerFee = useTrainer && selectedTrainer ? selectedTrainer.fee * sessionCount : 0;
    const total = selectedPlan.price + trainerFee;
    const sessionText = selectedDates.map(formatDate).join(', ');
    const message = `Pesanan IRONHUB\nMembership: ${selectedPlan.months} bulan\nPT: ${useTrainer && selectedTrainer ? selectedTrainer.name : 'Tanpa PT'}\nTanggal sesi PT: ${useTrainer ? sessionText : 'Tidak memilih PT'}\nJumlah sesi PT: ${sessionCount}\nTotal: ${rupiah(total)}`;
    const toast = document.getElementById('toast');
    toast.textContent = 'Pilihan berhasil disiapkan. Pada aplikasi sebenarnya, lanjutkan ke halaman payment gateway. Total: '+rupiah(total)+'.';
    toast.classList.add('show');
    console.log(message);
  });

  renderCalendar();
  updateSummary();
</script>
</body>
</html>
