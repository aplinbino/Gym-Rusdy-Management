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
    .trainers{display:grid;grid-template-columns:repeat(3,1fr);gap:15px}.trainer{padding:0;overflow:hidden;text-align:left;color:var(--text);background:var(--panel);border:1px solid var(--line);border-radius:13px;cursor:pointer;transition:.2s}.trainer img{width:100%;height:190px;display:block;object-fit:cover;filter:saturate(.8)}.trainer-info{padding:16px}.trainer-top{display:flex;align-items:center;justify-content:space-between;gap:8px}.trainer h3{font-size:17px;margin:0}.tag{font-size:10px;color:var(--accent);border:1px solid rgba(200,241,105,.35);border-radius:20px;padding:5px 8px;white-space:nowrap}.trainer p{color:var(--muted);font-size:12px;line-height:1.6;margin:10px 0 12px;min-height:58px}.trainer-meta{display:flex;justify-content:space-between;color:var(--muted);font-size:11px}.trainer-meta strong{color:var(--text)}
    .schedule-wrap{background:rgba(23,30,24,.72);border:1px solid var(--line);border-radius:13px;padding:20px}.schedule-note{color:var(--muted);font-size:12px;margin:7px 0 16px}.slots{display:grid;grid-template-columns:repeat(2,1fr);gap:10px}.slot{display:flex;align-items:center;justify-content:space-between;gap:14px;text-align:left;color:var(--text);background:#121912;border:1px solid var(--line);border-radius:10px;padding:14px;cursor:pointer;transition:.2s}.slot-day{font-weight:800;font-size:13px}.slot-time{font-size:11px;color:var(--muted);margin-top:4px}.slot-workout{text-align:right;font-size:12px;color:var(--accent);font-weight:750}.empty{padding:26px;text-align:center;color:var(--muted);font-size:13px;border:1px dashed var(--line);border-radius:10px}
    .summary{display:grid;grid-template-columns:1fr 330px;gap:20px;align-items:start;margin:36px 0 60px}.summary-info,.summary-card{background:rgba(23,30,24,.9);border:1px solid var(--line);border-radius:13px;padding:21px}.summary-info h2{font-size:20px;margin:0 0 8px}.summary-info p{color:var(--muted);font-size:12px;line-height:1.7;margin:0}.summary-card h3{font-size:15px;margin:0 0 17px}.line-item{display:flex;justify-content:space-between;gap:12px;color:var(--muted);font-size:12px;margin:12px 0}.line-item strong{color:var(--text);text-align:right}.total{border-top:1px solid var(--line);padding-top:15px;margin-top:16px;font-size:14px;color:var(--text);font-weight:850}.total strong{font-size:23px;color:var(--accent)}.pay{width:100%;border:0;border-radius:8px;background:var(--accent);color:#11170d;font-weight:950;padding:15px;margin-top:17px;cursor:pointer;transition:.2s}.pay:hover{background:#d8ff85;transform:translateY(-1px)}.pay:disabled{opacity:.4;cursor:not-allowed;transform:none}.fineprint{font-size:10px;color:var(--muted);line-height:1.5;margin:10px 0 0}.toast{display:none;margin-top:12px;padding:11px;border-radius:8px;background:rgba(200,241,105,.12);border:1px solid rgba(200,241,105,.3);color:var(--accent);font-size:12px}.toast.show{display:block}footer{border-top:1px solid var(--line);padding:20px 0 28px;color:#7f8a7c;font-size:10px;letter-spacing:.13em;display:flex;justify-content:space-between;gap:12px}
    @media(max-width:800px){.plans{grid-template-columns:repeat(2,1fr)}.trainers{grid-template-columns:1fr 1fr}.summary{grid-template-columns:1fr}.summary-card{max-width:none}}
    @media(max-width:560px){.container{width:calc(100% - 30px)}header{height:70px}nav{display:none}.intro{padding-top:35px}.trainers{grid-template-columns:1fr}.trainer img{height:220px}.slots{grid-template-columns:1fr}.section-head{align-items:start;flex-direction:column}.plan{padding:15px;min-height:115px}.plan .price{font-size:19px}footer{flex-direction:column}}
  </style>
</head>
<body>
<div class="page">
  <div class="container">
    <header>
      <a class="brand" href="#top"><span class="brand-mark">I</span><span>IRONHUB</span></a>
      <nav><a href="#membership">Membership</a><a href="#trainer">Personal Trainer</a><a href="#jadwal">Jadwal</a></nav>
      <div class="header-right">MEMBER AREA&nbsp; / &nbsp;CHECKOUT</div>
    </header>

    <main id="top">
      <section class="intro">
        <div class="eyebrow">Build your strength</div>
        <h1>PILIH PROGRAM.<br><span>MULAI PROGRES.</span></h1>
        <p>Tentukan durasi membership, pilih personal trainer yang sesuai dengan tujuan latihanmu, lalu amankan jadwal latihan yang tersedia.</p>
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
        <div class="section-head"><div><div class="step">02 / PERSONAL TRAINER</div><h2>Pilih personal trainer</h2><div class="section-sub">Pilih trainer untuk mendapatkan pendampingan dan program latihan.</div></div></div>
        <div class="trainers" id="trainers">
          <button class="trainer" data-trainer="Rizky Pratama" data-fee="500000">
            <img src="https://images.unsplash.com/photo-1567013127542-490d757e51fc?auto=format&fit=crop&w=900&q=85" alt="Personal trainer Rizky sedang berlatih" />
            <div class="trainer-info"><div class="trainer-top"><h3>Rizky Pratama</h3><span class="tag">PPL</span></div><p>Fokus pada pembentukan otot dan progressive overload. Membantu member membangun rutinitas latihan yang konsisten.</p><div class="trainer-meta"><span>Pengalaman</span><strong>5 Tahun</strong></div><div class="trainer-meta" style="margin-top:7px"><span>Biaya PT</span><strong>Rp500.000 / bulan</strong></div></div>
          </button>
          <button class="trainer" data-trainer="Andi Saputra" data-fee="450000">
            <img src="https://images.unsplash.com/photo-1583454110551-21f2fa2afe61?auto=format&fit=crop&w=900&q=85" alt="Personal trainer Andi" />
            <div class="trainer-info"><div class="trainer-top"><h3>Andi Saputra</h3><span class="tag">UL</span></div><p>Berpengalaman mendampingi program upper-lower split, peningkatan kekuatan, dan perbaikan teknik gerakan.</p><div class="trainer-meta"><span>Pengalaman</span><strong>4 Tahun</strong></div><div class="trainer-meta" style="margin-top:7px"><span>Biaya PT</span><strong>Rp450.000 / bulan</strong></div></div>
          </button>
          <button class="trainer" data-trainer="Dimas Alvaro" data-fee="550000">
            <img src="https://images.unsplash.com/photo-1534438327276-14e5300c3a48?auto=format&fit=crop&w=900&q=85" alt="Personal trainer Dimas di gym" />
            <div class="trainer-info"><div class="trainer-top"><h3>Dimas Alvaro</h3><span class="tag">PPL / UL</span></div><p>Membantu member menyusun program latihan sesuai target, mulai dari membangun massa otot hingga kebugaran umum.</p><div class="trainer-meta"><span>Pengalaman</span><strong>6 Tahun</strong></div><div class="trainer-meta" style="margin-top:7px"><span>Biaya PT</span><strong>Rp550.000 / bulan</strong></div></div>
          </button>
        </div>
      </section>

      <section class="section" id="jadwal">
        <div class="section-head"><div><div class="step">03 / TRAINING SCHEDULE</div><h2>Pilih jadwal latihan</h2><div class="section-sub">Jadwal akan ditampilkan setelah kamu memilih personal trainer.</div></div></div>
        <div class="schedule-wrap">
          <div id="scheduleContent"><div class="empty">Pilih personal trainer terlebih dahulu untuk melihat jadwal yang tersedia.</div></div>
        </div>
      </section>

      <section class="summary">
        <div class="summary-info"><div class="step">04 / ORDER SUMMARY</div><h2>Satu langkah lagi menuju progresmu.</h2><p>Periksa kembali pilihan membership, personal trainer, dan jadwal latihan sebelum melanjutkan pembayaran. Total biaya akan diperbarui otomatis sesuai pilihanmu.</p></div>
        <div class="summary-card">
          <h3>Rincian pembayaran</h3>
          <div class="line-item"><span>Membership</span><strong id="membershipLabel">1 Bulan</strong></div>
          <div class="line-item"><span>Biaya membership</span><strong id="membershipCost">Rp350.000</strong></div>
          <div class="line-item"><span>Personal trainer</span><strong id="trainerLabel">Belum dipilih</strong></div>
          <div class="line-item"><span>Biaya PT</span><strong id="trainerCost">Rp0</strong></div>
          <div class="line-item"><span>Jadwal latihan</span><strong id="scheduleLabel">Belum dipilih</strong></div>
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
  const schedules = {
    'Rizky Pratama': [
      {day:'Senin',time:'10.00 – 12.00',workout:'Upper Body'},
      {day:'Selasa',time:'13.00 – 15.00',workout:'Lower Body'},
      {day:'Rabu',time:'09.00 – 11.00',workout:'Push Day'},
      {day:'Jumat',time:'15.00 – 17.00',workout:'Pull Day'}
    ],
    'Andi Saputra': [
      {day:'Senin',time:'08.00 – 10.00',workout:'Upper Body'},
      {day:'Rabu',time:'13.00 – 15.00',workout:'Lower Body'},
      {day:'Kamis',time:'10.00 – 12.00',workout:'Upper Body'},
      {day:'Sabtu',time:'09.00 – 11.00',workout:'Lower Body'}
    ],
    'Dimas Alvaro': [
      {day:'Selasa',time:'09.00 – 11.00',workout:'Push Day'},
      {day:'Kamis',time:'13.00 – 15.00',workout:'Pull Day'},
      {day:'Jumat',time:'10.00 – 12.00',workout:'Leg Day'},
      {day:'Minggu',time:'08.00 – 10.00',workout:'Full Body'}
    ]
  };
  let selectedPlan = {months:1,price:350000};
  let selectedTrainer = null;
  let selectedSchedule = null;
  const rupiah = value => new Intl.NumberFormat('id-ID',{style:'currency',currency:'IDR',maximumFractionDigits:0}).format(value);

  document.querySelectorAll('.plan').forEach(button => button.addEventListener('click', () => {
    document.querySelectorAll('.plan').forEach(item => item.classList.remove('selected'));
    button.classList.add('selected');
    selectedPlan = {months:Number(button.dataset.months),price:Number(button.dataset.price)};
    updateSummary();
  }));

  document.querySelectorAll('.trainer').forEach(button => button.addEventListener('click', () => {
    document.querySelectorAll('.trainer').forEach(item => item.classList.remove('selected'));
    button.classList.add('selected');
    selectedTrainer = {name:button.dataset.trainer,fee:Number(button.dataset.fee)};
    selectedSchedule = null;
    renderSchedules();
    updateSummary();
    document.getElementById('jadwal').scrollIntoView({behavior:'smooth',block:'nearest'});
  }));

  function renderSchedules(){
    const target = document.getElementById('scheduleContent');
    target.innerHTML = '<p class="schedule-note">Jadwal tersedia untuk <strong style="color:var(--text)">'+selectedTrainer.name+'</strong>. Pilih salah satu jadwal berikut.</p><div class="slots">'+
      schedules[selectedTrainer.name].map((item,index)=>`<button class="slot" data-index="${index}"><div><div class="slot-day">${item.day}</div><div class="slot-time">${item.time}</div></div><div class="slot-workout">${item.workout}</div></button>`).join('')+'</div>';
    target.querySelectorAll('.slot').forEach(button=>button.addEventListener('click',()=>{
      target.querySelectorAll('.slot').forEach(item=>item.classList.remove('selected'));
      button.classList.add('selected');
      selectedSchedule=schedules[selectedTrainer.name][Number(button.dataset.index)];
      updateSummary();
    }));
  }

  function updateSummary(){
    const trainerFee=selectedTrainer?selectedTrainer.fee*selectedPlan.months:0;
    document.getElementById('membershipLabel').textContent=selectedPlan.months===12?'1 Tahun':selectedPlan.months+' Bulan';
    document.getElementById('membershipCost').textContent=rupiah(selectedPlan.price);
    document.getElementById('trainerLabel').textContent=selectedTrainer?selectedTrainer.name:'Belum dipilih';
    document.getElementById('trainerCost').textContent=rupiah(trainerFee);
    document.getElementById('scheduleLabel').textContent=selectedSchedule?selectedSchedule.day+', '+selectedSchedule.time:'Belum dipilih';
    document.getElementById('totalCost').textContent=rupiah(selectedPlan.price+trainerFee);
    document.getElementById('payButton').disabled=!(selectedTrainer&&selectedSchedule);
  }

  document.getElementById('payButton').addEventListener('click',()=>{
    if(!selectedTrainer||!selectedSchedule)return;
    const total=selectedPlan.price+(selectedTrainer.fee*selectedPlan.months);
    const message=`Pesanan IRONHUB\nMembership: ${selectedPlan.months} bulan\nPT: ${selectedTrainer.name}\nJadwal: ${selectedSchedule.day}, ${selectedSchedule.time} — ${selectedSchedule.workout}\nTotal: ${rupiah(total)}`;
    const toast=document.getElementById('toast');
    toast.textContent='Pilihan berhasil disiapkan. Pada aplikasi sebenarnya, lanjutkan ke halaman payment gateway. Total: '+rupiah(total)+'.';
    toast.classList.add('show');
    console.log(message);
  });
  updateSummary();
</script>
</body>
</html>
