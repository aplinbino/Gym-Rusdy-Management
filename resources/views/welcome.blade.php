
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="theme-color" content="#101510">
<title>IRONHUB — Train Beyond Limits</title>

<style>
:root {
    --bg: #101510;
    --panel: #171e18;
    --panel2: #202a20;
    --text: #f4f6ef;
    --muted: #aab4a7;
    --accent: #c8f169;
    --line: rgba(255,255,255,.12);
}

* {
    box-sizing: border-box;
}

html {
    scroll-behavior: smooth;
}

body {
    margin: 0;
    background: var(--bg);
    color: var(--text);
    font-family: Inter, ui-sans-serif, system-ui, -apple-system, "Segoe UI", sans-serif;
}

a {
    color: inherit;
    text-decoration: none;
}

.page {
    overflow: hidden;
    background:
        radial-gradient(ellipse at 78% 10%, rgba(121,157,75,.16), transparent 34%),
        linear-gradient(115deg, #101510, #111912 52%, #172018);
}

.container {
    width: min(1160px, calc(100% - 48px));
    margin: auto;
}

/* HEADER */

header {
    height: 88px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    border-bottom: 1px solid var(--line);
}

.brand {
    display: flex;
    align-items: center;
    gap: 11px;
    font-weight: 900;
    letter-spacing: .12em;
}

.brand-mark {
    width: 34px;
    height: 34px;
    display: grid;
    place-items: center;
    color: #101510;
    background: var(--accent);
    border-radius: 10px;
    font-size: 20px;
    font-weight: 1000;
    transform: skew(-8deg);
}

nav {
    display: flex;
    gap: 28px;
    color: var(--muted);
    font-size: 14px;
}

nav a:hover {
    color: var(--accent);
}

.nav-actions {
    display: flex;
    gap: 10px;
}

/* BUTTON */

.btn {
    min-height: 46px;
    padding: 0 21px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-radius: 8px;
    font-size: 14px;
    font-weight: 800;
    transition: .2s;
}

.btn:hover {
    transform: translateY(-2px);
}

.outline {
    border: 1px solid var(--line);
}

.outline:hover {
    border-color: var(--accent);
}

.primary {
    color: #11170d;
    background: var(--accent);
    box-shadow: 0 8px 30px rgba(200,241,105,.12);
}

.primary:hover {
    background: #d8ff85;
}

/* HERO */

.hero {
    min-height: 650px;
    display: grid;
    grid-template-columns: 1.02fr .98fr;
    align-items: center;
    gap: 42px;
    padding: 64px 0 86px;
}

.eyebrow {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    color: var(--accent);
    font-size: 11px;
    font-weight: 900;
    letter-spacing: .2em;
    text-transform: uppercase;
}

.eyebrow:before {
    content: "";
    width: 28px;
    height: 1px;
    background: var(--accent);
}

h1 {
    max-width: 650px;
    margin: 22px 0 20px;
    font-size: clamp(48px, 6.4vw, 82px);
    line-height: .98;
    letter-spacing: -.065em;
    font-weight: 950;
}

h1 span {
    color: var(--accent);
}

.intro {
    max-width: 490px;
    color: var(--muted);
    font-size: 16px;
    line-height: 1.8;
    margin: 0 0 30px;
}

.hero-actions {
    display: flex;
    flex-wrap: wrap;
    gap: 13px;
}

.hero-actions .btn {
    min-height: 54px;
    padding: 0 27px;
}

/* HERO VISUAL */

.visual {
    position: relative;
    min-height: 520px;
    display: grid;
    place-items: center;
}

.glow {
    position: absolute;
    width: 78%;
    aspect-ratio: 1;
    border-radius: 50%;
    background: rgba(200,241,105,.12);
    filter: blur(70px);
}

.photo {
    position: relative;
    width: min(100%, 480px);
    height: 510px;
    overflow: hidden;
    border: 1px solid rgba(255,255,255,.18);
    border-radius: 18px;
    background: radial-gradient(ellipse at 50% 25%, #65735c 0, #29372a 35%, #101710 76%);
    box-shadow: 0 28px 80px rgba(0,0,0,.38);
}

.photo:before {
    content: "";
    position: absolute;
    inset: 0;
    background:
        linear-gradient(180deg, transparent 35%, rgba(8,12,8,.9)),
        repeating-linear-gradient(90deg, transparent 0 70px, rgba(255,255,255,.08) 71px 73px);
}

.lifter {
    position: absolute;
    left: 50%;
    top: 18%;
    width: 190px;
    height: 330px;
    transform: translateX(-50%);
    filter: drop-shadow(0 20px 20px rgba(0,0,0,.35));
}

.head {
    position: absolute;
    left: 71px;
    top: 0;
    width: 52px;
    height: 58px;
    border-radius: 48% 48% 45% 45%;
    background: #b67b55;
}

.body-shape {
    position: absolute;
    left: 40px;
    top: 55px;
    width: 115px;
    height: 145px;
    background: linear-gradient(135deg, #d7fa83, #728d3c);
    clip-path: polygon(25% 0,75% 0,100% 30%,83% 100%,17% 100%,0 30%);
}

.arm {
    position: absolute;
    top: 72px;
    width: 32px;
    height: 130px;
    border-radius: 22px;
    background: #b67b55;
}

.arm.left {
    left: 20px;
    transform: rotate(28deg);
}

.arm.right {
    right: 18px;
    transform: rotate(-28deg);
}

.leg {
    position: absolute;
    top: 185px;
    width: 47px;
    height: 145px;
    background: #263126;
    clip-path: polygon(5% 0,95% 0,80% 100%,0 100%);
}

.leg.left {
    left: 48px;
    transform: rotate(5deg);
}

.leg.right {
    right: 43px;
    transform: rotate(-5deg);
}

.bar {
    position: absolute;
    top: 75px;
    left: 6%;
    width: 88%;
    height: 8px;
    background: #c7d0c1;
    border-radius: 9px;
}

.weight {
    position: absolute;
    top: 54px;
    width: 24px;
    height: 52px;
    background: var(--accent);
    border-radius: 5px;
}

.weight.left {
    left: 5%;
}

.weight.right {
    right: 5%;
}

.caption {
    position: absolute;
    z-index: 2;
    left: 28px;
    right: 28px;
    bottom: 27px;
}

.caption small {
    color: var(--accent);
    font-size: 10px;
    letter-spacing: .2em;
    font-weight: 900;
}

.caption h2 {
    margin: 8px 0 0;
    font-size: 28px;
    letter-spacing: -.04em;
}

.float {
    position: absolute;
    z-index: 3;
    left: -20px;
    top: 70px;
    padding: 16px 19px;
    background: rgba(23,30,24,.94);
    border: 1px solid var(--line);
    border-radius: 12px;
}

.float strong {
    display: block;
    color: var(--accent);
    font-size: 23px;
}

.float span {
    color: var(--muted);
    font-size: 10px;
    letter-spacing: .08em;
}

.sticker {
    position: absolute;
    right: -12px;
    bottom: 90px;
    z-index: 3;
    padding: 13px 16px;
    border-radius: 10px;
    background: var(--accent);
    color: #11170d;
    font-size: 11px;
    font-weight: 900;
    letter-spacing: .08em;
    transform: rotate(-4deg);
}

/* GENERAL SECTION */

section.content-section {
    padding: 100px 0;
    scroll-margin-top: 24px;
}

.section-head {
    max-width: 680px;
    margin-bottom: 38px;
}

.section-head.center {
    text-align: center;
    margin: 0 auto 42px;
}

.section-head .eyebrow {
    justify-content: center;
}

.section-head h2 {
    font-size: clamp(32px, 4vw, 48px);
    line-height: 1.05;
    letter-spacing: -.045em;
    margin: 16px 0;
}

.section-head p {
    color: var(--muted);
    line-height: 1.8;
    margin: 0;
}

/* MEMBERSHIP */

.pricing {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 16px;
}

.price-card {
    position: relative;
    padding: 25px 22px;
    background: linear-gradient(160deg, #1b241c, #141a15);
    border: 1px solid var(--line);
    border-radius: 14px;
    transition: .2s;
}

.price-card:hover {
    transform: translateY(-5px);
    border-color: rgba(200,241,105,.6);
}

.duration {
    font-size: 13px;
    color: var(--muted);
    font-weight: 700;
}

.price {
    font-size: 29px;
    font-weight: 900;
    letter-spacing: -.05em;
    margin: 18px 0 4px;
}

.per {
    font-size: 12px;
    color: var(--muted);
}

.price-card ul {
    padding: 18px 0 0;
    margin: 18px 0;
    border-top: 1px solid var(--line);
    list-style: none;
    color: var(--muted);
    font-size: 12px;
    line-height: 2.2;
}

.price-card li:before {
    content: "✓";
    color: var(--accent);
    margin-right: 8px;
}

/* PERSONAL TRAINER */

.pt-section {
    background: linear-gradient(180deg, rgba(255,255,255,.015), rgba(255,255,255,.035));
    border-top: 1px solid rgba(255,255,255,.04);
    border-bottom: 1px solid rgba(255,255,255,.04);
}

.pt-top {
    display: flex;
    justify-content: space-between;
    align-items: end;
    gap: 20px;
    margin-bottom: 32px;
}

.pt-top .section-head {
    margin: 0;
}

.scroll-hint {
    color: var(--muted);
    font-size: 12px;
    white-space: nowrap;
}

/* HORIZONTAL SCROLL PT */

.pt-track {
    display: grid;
    grid-auto-columns: 260px;
    grid-auto-flow: column;
    gap: 18px;

    overflow-x: auto;
    overflow-y: hidden;

    padding: 4px 2px 20px;

    scroll-snap-type: x mandatory;
    scroll-behavior: smooth;

    scrollbar-color: #647b3d #1a211b;
    scrollbar-width: thin;

    -webkit-overflow-scrolling: touch;
}

.pt-track::-webkit-scrollbar {
    height: 7px;
}

.pt-track::-webkit-scrollbar-track {
    background: #1a211b;
    border-radius: 10px;
}

.pt-track::-webkit-scrollbar-thumb {
    background: #647b3d;
    border-radius: 10px;
}

.pt-card {
    scroll-snap-align: start;
    background: #171e18;
    border: 1px solid var(--line);
    border-radius: 14px;
    overflow: hidden;
    min-width: 0;
}

.pt-photo {
    height: 260px;
    position: relative;
    display: flex;
    align-items: end;
    justify-content: center;
    background: radial-gradient(ellipse at 50% 25%, #64735b, #29352a 65%, #151b15);
}

.pt-photo:after {
    content: "";
    position: absolute;
    inset: 0;
    background: linear-gradient(180deg, transparent 55%, rgba(10,14,10,.72));
}

.person {
    position: relative;
    width: 130px;
    height: 205px;
    z-index: 1;
    background: linear-gradient(145deg, #c8f169, #617a39);
    clip-path: polygon(35% 0,65% 0,78% 12%,100% 42%,83% 55%,77% 100%,23% 100%,17% 55%,0 42%,22% 12%);
    border-radius: 30px 30px 0 0;
}

.person.p2 {
    background: linear-gradient(145deg, #c28d68, #634532);
}

.person.p3 {
    background: linear-gradient(145deg, #9bb6c7, #405968);
}

.person.p4 {
    background: linear-gradient(145deg, #c7a77b, #66513b);
}

.pt-info {
    padding: 18px;
}

.pt-info h3 {
    margin: 0 0 5px;
    font-size: 18px;
}

.pt-info p {
    margin: 0;
    color: var(--muted);
    font-size: 12px;
}

.tags {
    display: flex;
    gap: 7px;
    margin: 14px 0 16px;
}

.tag {
    padding: 5px 8px;
    border: 1px solid var(--line);
    border-radius: 5px;
    color: var(--accent);
    font-size: 10px;
    font-weight: 800;
}

/* WHY CHOOSE US */

.why-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 16px;
}

.why-card {
    padding: 25px 22px;
    background: var(--panel);
    border: 1px solid var(--line);
    border-radius: 12px;
}

.why-icon {
    width: 42px;
    height: 42px;
    border-radius: 10px;
    background: rgba(200,241,105,.12);
    color: var(--accent);
    display: grid;
    place-items: center;
    font-size: 20px;
}

.why-card h3 {
    font-size: 16px;
    margin: 18px 0 8px;
}

.why-card p {
    font-size: 12px;
    color: var(--muted);
    line-height: 1.8;
    margin: 0;
}

/* JOIN CTA */

.join {
    padding: 80px 28px;
    border: 1px solid rgba(200,241,105,.2);
    border-radius: 20px;
    text-align: center;
    background: radial-gradient(ellipse at 50% 0, rgba(200,241,105,.16), transparent 60%), #171f17;
}

.join h2 {
    font-size: clamp(32px, 5vw, 54px);
    line-height: 1;
    letter-spacing: -.05em;
    margin: 18px 0;
}

.join p {
    max-width: 600px;
    margin: 0 auto 28px;
    color: var(--muted);
    line-height: 1.8;
}

/* FOOTER */

footer {
    display: flex;
    justify-content: space-between;
    gap: 20px;
    padding: 25px 0;
    border-top: 1px solid var(--line);
    color: #7f8a7c;
    font-size: 10px;
    text-transform: uppercase;
    letter-spacing: .14em;
}

/* RESPONSIVE */

@media (max-width: 900px) {
    nav {
        display: none;
    }

    .hero {
        grid-template-columns: 1fr;
        gap: 20px;
        padding-top: 60px;
    }

    .visual {
        min-height: 470px;
    }

    .photo {
        height: 450px;
    }

    .pricing {
        grid-template-columns: repeat(2, 1fr);
    }

    .why-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 560px) {
    .container {
        width: calc(100% - 32px);
    }

    header {
        height: 74px;
    }

    .brand {
        font-size: 14px;
    }

    .nav-actions {
        gap: 6px;
    }

    .nav-actions .btn {
        min-height: 39px;
        padding: 0 11px;
        font-size: 11px;
    }

    .hero {
        padding: 55px 0 45px;
    }

    .hero h1 {
        font-size: clamp(45px, 13vw, 64px);
    }

    .intro {
        font-size: 14px;
    }

    .visual {
        min-height: 390px;
    }

    .photo {
        height: 380px;
    }

    .float {
        left: 0;
        top: 35px;
    }

    .sticker {
        right: 0;
        bottom: 55px;
    }

    .caption h2 {
        font-size: 23px;
    }

    section.content-section {
        padding: 70px 0;
    }

    .pricing {
        grid-template-columns: 1fr;
    }

    .price-card {
        padding: 22px;
    }

    .pt-top {
        display: block;
    }

    .scroll-hint {
        display: block;
        margin-top: 15px;
    }

    .pt-track {
        grid-auto-columns: 78%;
    }

    .why-grid {
        grid-template-columns: 1fr;
    }

    .join {
        padding: 60px 20px;
    }

    footer {
        flex-direction: column;
        gap: 8px;
    }
}
</style>
</head>

<body>
<div class="page">
<div class="container">

<!-- HEADER -->

<header>
    <a class="brand" href="#">
        <span class="brand-mark">I</span>
        <span>IRONHUB</span>
    </a>

    <nav aria-label="Navigasi utama">
        <a href="#membership">Membership</a>
        <a href="#trainer">Personal Trainer</a>
        <a href="#why">Keunggulan</a>
        <a href="#join">Join Us</a>
    </nav>

    <div class="nav-actions">
        <a class="btn outline" href="/login">Login</a>
        <a class="btn primary" href="/sign_up">Daftar</a>
    </div>
</header>

<!-- HERO SECTION -->

<main class="hero" id="mulai">

    <section>
        <div class="eyebrow">Your strength starts here</div>

        <h1>
            JADILAH<br>
            VERSI <span>TERKUAT</span><br>
            DIRIMU.
        </h1>

        <p class="intro">
            Bukan sekadar tempat untuk berolahraga. IRONHUB adalah ruang
            untuk membangun kekuatan, disiplin, dan versi terbaik dari
            dirimu—satu repetisi dalam satu waktu.
        </p>

        <div class="hero-actions">
            <a class="btn primary" href="/sign_up">
                Mulai Sekarang&nbsp; ↗
            </a>

            <a class="btn outline" href="/login">
                Login Member
            </a>
        </div>
    </section>

    <section class="visual" aria-label="Suasana gym IRONHUB">
        <div class="glow"></div>

        <div class="float">
            <strong>01 / 100</strong>
            <span>EVERY REP COUNTS</span>
        </div>

        <div class="photo">
            <div class="bar"></div>
            <div class="weight left"></div>
            <div class="weight right"></div>

            <div class="lifter">
                <div class="head"></div>
                <div class="body-shape"></div>
                <div class="arm left"></div>
                <div class="arm right"></div>
                <div class="leg left"></div>
                <div class="leg right"></div>
            </div>

            <div class="caption">
                <small>BUILT BY DISCIPLINE</small>
                <h2>Stronger every day.</h2>
            </div>
        </div>

        <div class="sticker">
            NO EXCUSES. JUST PROGRESS.
        </div>
    </section>

</main>

<!-- MEMBERSHIP SECTION -->

<section class="content-section" id="membership">

    <div class="section-head center">
        <div class="eyebrow">Choose your commitment</div>

        <h2>
            INVEST IN YOUR
            <span style="color:var(--accent)">STRENGTH.</span>
        </h2>

        <p>
            Lihat pilihan durasi dan harga membership IRONHUB.
            Pendaftaran serta pemilihan paket dilakukan setelah kamu
            memiliki akun dan login.
        </p>
    </div>

    <div class="pricing">

        <article class="price-card">
            <div class="duration">01 BULAN</div>
            <div class="price">Rp150.000</div>
            <div class="per">per bulan</div>

            <ul>
                <li>Akses fasilitas gym</li>
                <li>Area latihan lengkap</li>
                <li>Locker room</li>
            </ul>
        </article>

        <article class="price-card">
            <div class="duration">03 BULAN</div>
            <div class="price">Rp400.000</div>
            <div class="per">hemat Rp50.000</div>

            <ul>
                <li>Akses fasilitas gym</li>
                <li>Area latihan lengkap</li>
                <li>Locker room</li>
            </ul>
        </article>

        <article class="price-card">
            <div class="duration">06 BULAN</div>
            <div class="price">Rp750.000</div>
            <div class="per">hemat Rp150.000</div>

            <ul>
                <li>Akses fasilitas gym</li>
                <li>Area latihan lengkap</li>
                <li>Locker room</li>
            </ul>
        </article>

        <article class="price-card">
            <div class="duration">12 BULAN</div>
            <div class="price">Rp1.400.000</div>
            <div class="per">hemat Rp400.000</div>

            <ul>
                <li>Akses fasilitas gym</li>
                <li>Area latihan lengkap</li>
                <li>Locker room</li>
            </ul>
        </article>

    </div>

    <p style="margin:22px 0 0;text-align:center;color:var(--muted);font-size:12px;line-height:1.7">
        Tertarik bergabung? Daftar atau login terlebih dahulu untuk memilih paket membership.
    </p>

</section>

<!-- PERSONAL TRAINER SECTION -->

<section class="content-section pt-section" id="trainer">

    <div class="pt-top">

        <div class="section-head">
            <div class="eyebrow">Train with the best</div>

            <h2>
                MEET YOUR
                <span style="color:var(--accent)">TRAINER.</span>
            </h2>

            <p>
                Temukan partner latihan yang siap membantu kamu menyusun
                strategi dan mencapai target fitness.
            </p>
        </div>

        <div class="scroll-hint">
            Geser ke samping untuk melihat trainer lainnya&nbsp; →
        </div>

    </div>

    <!-- KARTU PT BISA DIGESER HORIZONTAL -->

    <div class="pt-track">

        <article class="pt-card">
            <div class="pt-photo">
                <div class="person"></div>
            </div>

            <div class="pt-info">
                <h3>Rizky Pratama</h3>
                <p>Strength & Conditioning Coach</p>

                <div class="tags">
                    <span class="tag">PPL</span>
                    <span class="tag">Strength</span>
                </div>
            </div>
        </article>

        <article class="pt-card">
            <div class="pt-photo">
                <div class="person p2"></div>
            </div>

            <div class="pt-info">
                <h3>Andi Saputra</h3>
                <p>Fitness & Hypertrophy Coach</p>

                <div class="tags">
                    <span class="tag">UL</span>
                    <span class="tag">Hypertrophy</span>
                </div>
            </div>
        </article>

        <article class="pt-card">
            <div class="pt-photo">
                <div class="person p3"></div>
            </div>

            <div class="pt-info">
                <h3>Fajar Ramadhan</h3>
                <p>Personal Fitness Coach</p>

                <div class="tags">
                    <span class="tag">PPL</span>
                    <span class="tag">Beginner</span>
                </div>
            </div>
        </article>

        <article class="pt-card">
            <div class="pt-photo">
                <div class="person p4"></div>
            </div>

            <div class="pt-info">
                <h3>Reza Maulana</h3>
                <p>Strength Training Coach</p>

                <div class="tags">
                    <span class="tag">UL</span>
                    <span class="tag">Strength</span>
                </div>
            </div>
        </article>

        <article class="pt-card">
            <div class="pt-photo">
                <div class="person p2"></div>
            </div>

            <div class="pt-info">
                <h3>Arga Mahendra</h3>
                <p>Personal Fitness Coach</p>

                <div class="tags">
                    <span class="tag">UL</span>
                </div>
            </div>
        </article>

    </div>

</section>

<!-- WHY CHOOSE US SECTION -->

<section class="content-section" id="why">

    <div class="section-head center">
        <div class="eyebrow">Why choose ironhub</div>

        <h2>
            BUKAN CUMA GYM. INI TEMPATMU
            <span style="color:var(--accent)">BERTUMBUH.</span>
        </h2>

        <p>
            Setiap orang punya titik awal dan tujuan yang berbeda.
            Di IRONHUB, kami menyediakan ruang dan dukungan agar kamu
            bisa terus berkembang.
        </p>
    </div>

    <div class="why-grid">

        <article class="why-card">
            <div class="why-icon">✦</div>
            <h3>Professional Guidance</h3>
            <p>
                Dapatkan arahan latihan dari personal trainer untuk
                membantu perjalanan fitness kamu lebih terarah.
            </p>
        </article>

        <article class="why-card">
            <div class="why-icon">↗</div>
            <h3>Flexible Membership</h3>
            <p>
                Pilih durasi membership yang sesuai dengan kebutuhan
                dan komitmen latihanmu.
            </p>
        </article>

        <article class="why-card">
            <div class="why-icon">◎</div>
            <h3>Supportive Community</h3>
            <p>
                Berlatih di lingkungan yang positif bersama orang-orang
                dengan semangat yang sama.
            </p>
        </article>

        <article class="why-card">
            <div class="why-icon">⚡</div>
            <h3>Your Own Progress</h3>
            <p>
                Bangun konsistensi, ukur perkembangan, dan rayakan
                setiap pencapaian kecilmu.
            </p>
        </article>

    </div>

</section>

<!-- JOIN CTA SECTION -->

<section class="content-section" id="join">

    <div class="join">

        <div class="eyebrow">Your journey begins today</div>

        <h2>
            READY TO GET
            <span style="color:var(--accent)">STRONGER?</span>
        </h2>

        <p>
            Jangan tunggu waktu yang tepat untuk memulai. Ambil langkah
            pertamamu, bangun kebiasaan yang lebih baik, dan temukan
            versi terkuat dirimu bersama IRONHUB.
        </p>

        <a class="btn primary" href="/sign_up">
            JOIN IRONHUB TODAY&nbsp; ↗
        </a>

    </div>

</section>

<!-- FOOTER -->

<footer>
    <span>© 2025 IRONHUB FITNESS CLUB</span>
    <span>Train hard · Stay humble · Keep growing</span>
</footer>

</div>
</div>
</body>
</html>
