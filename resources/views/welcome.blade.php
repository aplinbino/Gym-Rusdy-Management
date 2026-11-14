<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="theme-color" content="#101510">
  <meta name="description" content="Mulai perjalanan fitness kamu bersama IRONHUB. Latihan lebih fokus, lebih kuat, dan lebih sehat.">
  <title>IRONHUB — Train Beyond Limits</title>
  <style>
    :root {
      --bg: #101510;
      --panel: #171e18;
      --text: #f4f6ef;
      --muted: #aab4a7;
      --accent: #c8f169;
      --line: rgba(255,255,255,.13);
    }
    * { box-sizing: border-box; }
    html { scroll-behavior: smooth; }
    body {
      margin: 0;
      min-height: 100vh;
      color: var(--text);
      background: var(--bg);
      font-family: Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
    }
    a { color: inherit; text-decoration: none; }
    .page {
      min-height: 100vh;
      overflow: hidden;
      position: relative;
      isolation: isolate;
      background:
        radial-gradient(ellipse at 78% 42%, rgba(121,157,75,.18), transparent 34%),
        linear-gradient(115deg, #101510 0%, #111912 52%, #172018 100%);
    }
    .page::before {
      content: "";
      position: absolute;
      inset: 0;
      z-index: -1;
      opacity: .12;
      background-image: linear-gradient(rgba(255,255,255,.08) 1px, transparent 1px),
                        linear-gradient(90deg, rgba(255,255,255,.08) 1px, transparent 1px);
      background-size: 58px 58px;
      mask-image: linear-gradient(to bottom, black, transparent 85%);
    }
    .container { width: min(1160px, calc(100% - 48px)); margin: auto; }
    header {
      height: 88px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      border-bottom: 1px solid var(--line);
    }
    .brand { display: inline-flex; align-items: center; gap: 11px; font-weight: 900; letter-spacing: .12em; }
    .brand-mark {
      width: 34px; height: 34px; display: grid; place-items: center;
      color: #101510; background: var(--accent); border-radius: 10px;
      font-size: 20px; font-weight: 1000; transform: skew(-8deg);
    }
    .brand span:last-child { font-size: 17px; }
    nav { display: flex; align-items: center; gap: 32px; color: var(--muted); font-size: 14px; }
    nav a:hover { color: var(--accent); }
    .nav-actions { display: flex; align-items: center; gap: 12px; }
    .btn {
      min-height: 46px; padding: 0 21px; display: inline-flex; align-items: center;
      justify-content: center; border-radius: 8px; font-size: 14px; font-weight: 800;
      transition: transform .2s ease, background .2s ease, border-color .2s ease;
    }
    .btn:hover { transform: translateY(-2px); }
    .btn-outline { border: 1px solid var(--line); color: var(--text); }
    .btn-outline:hover { border-color: var(--accent); }
    .btn-primary { color: #11170d; background: var(--accent); box-shadow: 0 8px 30px rgba(200,241,105,.12); }
    .btn-primary:hover { background: #d8ff85; }
    main {
      min-height: calc(100vh - 88px);
      display: grid; grid-template-columns: 1.02fr .98fr;
      align-items: center; gap: 42px; padding-top: 54px; padding-bottom: 78px;
    }
    .eyebrow {
      display: inline-flex; align-items: center; gap: 10px; color: var(--accent);
      font-size: 11px; font-weight: 900; letter-spacing: .2em; text-transform: uppercase;
    }
    .eyebrow::before { content: ""; width: 28px; height: 1px; background: var(--accent); }
    h1 {
      max-width: 650px; margin: 22px 0 20px; font-size: clamp(48px, 6.4vw, 82px);
      line-height: .98; letter-spacing: -.065em; font-weight: 950;
    }
    h1 span { color: var(--accent); }
    .intro { max-width: 490px; color: var(--muted); font-size: 16px; line-height: 1.8; margin: 0 0 30px; }
    .hero-actions { display: flex; flex-wrap: wrap; gap: 13px; }
    .hero-actions .btn { min-height: 54px; padding: 0 27px; }
    .proof { display: flex; align-items: center; gap: 18px; margin-top: 42px; color: var(--muted); font-size: 12px; }
    .avatars { display: flex; padding-left: 5px; }
    .avatar {
      width: 31px; height: 31px; margin-left: -5px; border: 2px solid var(--bg);
      border-radius: 50%; display: grid; place-items: center; background: #71836b;
      color: white; font-size: 10px; font-weight: 800;
    }
    .avatar:nth-child(2) { background: #a76f4f; }
    .avatar:nth-child(3) { background: #667e91; }
    .avatar:nth-child(4) { background: #8c795d; }
    .proof strong { color: var(--text); }
    .visual { position: relative; min-height: 520px; display: grid; place-items: center; }
    .visual-glow {
      position: absolute; width: 78%; aspect-ratio: 1; border-radius: 50%;
      background: rgba(200,241,105,.12); filter: blur(70px);
    }
    .photo-frame {
      position: relative; width: min(100%, 480px); height: 510px; overflow: hidden;
      border: 1px solid rgba(255,255,255,.18); border-radius: 18px;
      background: linear-gradient(145deg, #344035, #141b15 60%, #080b08);
      box-shadow: 0 28px 80px rgba(0,0,0,.38);
    }
    .photo-frame::before {
      content: ""; position: absolute; inset: 0;
      background:
        linear-gradient(180deg, transparent 35%, rgba(8,12,8,.85) 100%),
        radial-gradient(ellipse at 50% 30%, rgba(200,241,105,.2), transparent 40%);
      z-index: 1;
    }
    .gym-art { position: absolute; inset: 0; width: 100%; height: 100%; }
    .photo-caption { position: absolute; z-index: 2; left: 28px; right: 28px; bottom: 27px; }
    .photo-caption small { color: var(--accent); font-size: 10px; letter-spacing: .2em; font-weight: 900; }
    .photo-caption h2 { margin: 8px 0 0; font-size: 28px; letter-spacing: -.04em; }
    .floating-card {
      position: absolute; z-index: 3; left: -28px; top: 70px; padding: 16px 19px;
      background: rgba(23,30,24,.92); border: 1px solid var(--line);
      border-radius: 12px; box-shadow: 0 15px 35px rgba(0,0,0,.25); backdrop-filter: blur(12px);
    }
    .floating-card strong { display: block; color: var(--accent); font-size: 23px; }
    .floating-card span { color: var(--muted); font-size: 10px; letter-spacing: .08em; }
    .side-note {
      position: absolute; right: -18px; bottom: 100px; z-index: 3;
      padding: 13px 16px; border-radius: 10px; background: var(--accent); color: #11170d;
      font-size: 11px; font-weight: 900; letter-spacing: .08em; transform: rotate(-4deg);
    }
    .bottom-line {
      display: flex; justify-content: space-between; gap: 20px; padding: 20px 0;
      border-top: 1px solid var(--line); color: #7f8a7c; font-size: 10px;
      text-transform: uppercase; letter-spacing: .17em;
    }
    @media (max-width: 820px) {
      nav { display: none; }
      main { grid-template-columns: 1fr; gap: 20px; padding-top: 64px; }
      .visual { min-height: 450px; }
      .photo-frame { height: 440px; }
      .floating-card { left: 0; }
      .side-note { right: 0; }
    }
    @media (max-width: 520px) {
      .container { width: min(100% - 32px, 1160px); }
      header { height: 74px; }
      .brand span:last-child { font-size: 14px; }
      .nav-actions { gap: 7px; }
      .nav-actions .btn { min-height: 40px; padding: 0 12px; font-size: 12px; }
      main { min-height: auto; padding-top: 58px; padding-bottom: 42px; }
      h1 { font-size: clamp(46px, 13vw, 65px); }
      .intro { font-size: 14px; }
      .proof { margin-top: 30px; }
      .visual { min-height: 390px; }
      .photo-frame { height: 380px; }
      .photo-caption h2 { font-size: 23px; }
      .floating-card { top: 35px; }
      .side-note { bottom: 70px; }
      .bottom-line { flex-direction: column; gap: 8px; font-size: 9px; }
    }
  </style>
</head>
<body>
  <div class="page">
    <div class="container">
      <header>
        <a class="brand" href="/" aria-label="IRONHUB home">
          <span class="brand-mark">I</span><span>IRONHUB</span>
        </a>
        <nav aria-label="Navigasi utama">
          <a href="#keunggulan">Keunggulan</a>
          <a href="#komunitas">Komunitas</a>
          <a href="#mulai">Mulai latihan</a>
        </nav>
        <div class="nav-actions">
          <a class="btn btn-outline" href="/login">Login</a>
          <a class="btn btn-primary" href="/sign_up">Daftar</a>
        </div>
      </header>

      <main>
        <section id="mulai">
          <div class="eyebrow">Your strength starts here</div>
          <h1>JADILAH<br>VERSI <span>TERKUAT</span><br>DIRIMU.</h1>
          <p class="intro">
            Bukan sekadar tempat untuk berolahraga. IRONHUB adalah ruang untuk
            membangun kekuatan, disiplin, dan versi terbaik dari dirimu—satu
            repetisi dalam satu waktu.
          </p>
          <div class="hero-actions">
            <a class="btn btn-primary" href="/sign_up">Mulai Sekarang <span aria-hidden="true">&nbsp;↗</span></a>
            <a class="btn btn-outline" href="/login">Login Member</a>
          </div>
          <div class="proof" id="komunitas">
            <div class="avatars" aria-hidden="true">
              <span class="avatar">A</span><span class="avatar">D</span><span class="avatar">R</span><span class="avatar">M</span>
            </div>
            <span><strong>Komunitas yang terus bertumbuh</strong><br>Latihan bareng, berkembang bareng.</span>
          </div>
        </section>

        <section class="visual" id="keunggulan" aria-label="Suasana gym IRONHUB">
          <div class="visual-glow"></div>
          <div class="floating-card"><strong>01 / 100</strong><span>EVERY REP COUNTS</span></div>
          <div class="photo-frame">
            <svg class="gym-art" viewBox="0 0 480 560" preserveAspectRatio="xMidYMid slice" role="img" aria-label="Ilustrasi atlet sedang berlatih angkat beban di gym">
              <defs>
                <linearGradient id="wall" x1="0" y1="0" x2="1" y2="1"><stop stop-color="#48564a"/><stop offset="1" stop-color="#101710"/></linearGradient>
                <linearGradient id="floor" x1="0" y1="0" x2="0" y2="1"><stop stop-color="#29352a"/><stop offset="1" stop-color="#090d09"/></linearGradient>
                <linearGradient id="shirt" x1="0" y1="0" x2="1" y2="1"><stop stop-color="#c8f169"/><stop offset="1" stop-color="#728d3c"/></linearGradient>
              </defs>
              <rect width="480" height="560" fill="url(#wall)"/>
              <path d="M0 390 L480 350 L480 560 L0 560Z" fill="url(#floor)"/>
              <g opacity=".25" stroke="#b5c4a9" stroke-width="3">
                <path d="M35 0V390 M445 0V360 M0 120H480 M0 230H480"/>
                <path d="M70 0L70 390 M410 0L410 370" stroke-width="1"/>
              </g>
              <g fill="#111811" stroke="#64735e" stroke-width="5">
                <path d="M55 100V405 M425 90V380 M45 115H435"/>
                <path d="M80 180H400 M80 300H400" stroke-width="8"/>
              </g>
              <g transform="translate(0 8)">
                <path d="M194 206 Q166 230 162 294 L150 382 L204 391 L239 299 L270 385 L323 370 L292 250 Q282 211 250 197Z" fill="url(#shirt)"/>
                <path d="M190 218 Q153 224 136 265 L105 318 L128 334 L181 285Z" fill="#b67b55"/>
                <path d="M282 218 Q316 216 339 252 L369 298 L347 317 L292 279Z" fill="#b67b55"/>
                <path d="M199 382 L188 470 L167 526 L208 534 L245 456 L258 389Z" fill="#202a20"/>
                <path d="M258 389 L279 464 L309 525 L348 511 L321 446 L311 376Z" fill="#303d30"/>
                <path d="M166 519 Q187 511 211 528 L219 548 L150 548Z" fill="#101510"/>
                <path d="M309 514 Q333 501 350 513 L373 544 L319 547Z" fill="#101510"/>
                <circle cx="239" cy="155" r="48" fill="#b67b55"/>
                <path d="M191 155 Q188 102 238 103 Q285 104 286 153 Q266 130 243 128 Q222 149 191 155Z" fill="#171a16"/>
                <path d="M207 168 Q238 187 267 166" fill="none" stroke="#71452f" stroke-width="4" stroke-linecap="round"/>
              </g>
              <g transform="translate(0 0)" stroke="#b8c4ad" stroke-width="9" stroke-linecap="round">
                <path d="M73 95H407"/>
                <path d="M83 75V115 M397 75V115"/>
              </g>
              <g fill="#c8f169">
                <rect x="58" y="57" width="26" height="76" rx="5"/>
                <rect x="396" y="57" width="26" height="76" rx="5"/>
              </g>
              <g fill="#111711" opacity=".7">
                <rect x="20" y="420" width="440" height="8" rx="4"/>
                <rect x="35" y="445" width="410" height="4" rx="2"/>
              </g>
            </svg>
            <div class="photo-caption">
              <small>BUILT BY DISCIPLINE</small>
              <h2>Stronger every day.</h2>
            </div>
          </div>
          <div class="side-note">NO EXCUSES. JUST PROGRESS.</div>
        </section>
      </main>

      <footer class="bottom-line">
        <span>© 2025 IRONHUB FITNESS CLUB</span>
        <span>Train hard · Stay humble · Keep growing</span>
      </footer>
    </div>
  </div>
</body>
</html>
