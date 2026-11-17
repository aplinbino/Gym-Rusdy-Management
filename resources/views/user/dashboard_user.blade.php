
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="theme-color" content="#101510">
<title>Dashboard Member — IRONHUB</title>

<style>
* {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
}

body {
    min-height: 100vh;
    font-family: Arial, Helvetica, sans-serif;
    color: #f4f6ef;
    background: #101510;
}

.container {
    width: min(1100px, calc(100% - 40px));
    margin: auto;
}

/* HEADER */
header {
    border-bottom: 1px solid #303b30;
    padding: 22px 0;
}

.navbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.brand {
    display: flex;
    align-items: center;
    gap: 10px;
    font-weight: 900;
    letter-spacing: 2px;
}

.mark {
    width: 36px;
    height: 36px;
    display: grid;
    place-items: center;
    color: #101510;
    background: #c8f169;
    border-radius: 9px;
    font-size: 20px;
}

.profile {
    color: #c8f169;
    font-size: 13px;
    font-weight: bold;
}

/* MAIN */
main {
    padding: 45px 0;
}

.welcome {
    margin-bottom: 35px;
}

.welcome small {
    color: #c8f169;
    font-weight: bold;
    letter-spacing: 2px;
    font-size: 11px;
}

.welcome h1 {
    font-size: clamp(26px, 5vw, 36px);
    margin: 12px 0;
}

.welcome p {
    color: #aab4a7;
    font-size: 14px;
}

/* CARD */
.card {
    background: #192119;
    border: 1px solid #344233;
    border-radius: 14px;
    padding: 25px;
    margin-bottom: 22px;
}

.card-title {
    font-size: 17px;
    margin-bottom: 20px;
}

/* MEMBERSHIP */
.membership {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 20px;
    background: linear-gradient(120deg, #263622, #192119);
}

.membership-label {
    color: #aab4a7;
    font-size: 12px;
    margin-bottom: 9px;
}

.membership-days {
    font-size: 38px;
    font-weight: 900;
    color: #c8f169;
}

.membership-info {
    color: #aab4a7;
    font-size: 12px;
    margin-top: 8px;
}

.status {
    background: #c8f169;
    color: #101510;
    padding: 8px 13px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: bold;
    white-space: nowrap;
}

/* SCHEDULE */
.schedule-list {
    display: grid;
    gap: 13px;
}

.schedule-item {
    display: grid;
    grid-template-columns: 90px 1fr auto;
    align-items: center;
    gap: 18px;
    padding: 17px;
    background: #101710;
    border: 1px solid #303b30;
    border-radius: 10px;
}

.schedule-day {
    color: #c8f169;
    font-weight: bold;
    font-size: 13px;
}

.schedule-day small {
    display: block;
    color: #82907e;
    font-size: 11px;
    margin-top: 5px;
}

.trainer-name {
    font-weight: bold;
    font-size: 14px;
}

.workout {
    color: #aab4a7;
    font-size: 12px;
    margin-top: 6px;
}

.schedule-time {
    text-align: right;
    font-size: 13px;
    color: #c8f169;
    font-weight: bold;
}

/* INACTIVE MEMBERSHIP */
.inactive {
    text-align: center;
    padding: 55px 25px;
}

.inactive-icon {
    width: 65px;
    height: 65px;
    display: grid;
    place-items: center;
    margin: 0 auto 20px;
    background: #293622;
    color: #c8f169;
    border-radius: 50%;
    font-size: 27px;
}

.inactive h2 {
    font-size: 23px;
    margin-bottom: 12px;
}

.inactive p {
    color: #aab4a7;
    font-size: 14px;
    line-height: 1.7;
    margin-bottom: 25px;
}

.btn {
    display: inline-flex;
    justify-content: center;
    align-items: center;
    min-height: 48px;
    padding: 0 25px;
    background: #c8f169;
    color: #11170d;
    border-radius: 8px;
    text-decoration: none;
    font-size: 13px;
    font-weight: 800;
    transition: .2s;
}

.btn:hover {
    background: #d8ff85;
    transform: translateY(-2px);
}

/* FOOTER */
footer {
    border-top: 1px solid #303b30;
    padding: 22px 0;
    color: #82907e;
    font-size: 11px;
    text-align: center;
}

/* RESPONSIVE */
@media (max-width: 600px) {
    main {
        padding: 32px 0;
    }

    .card {
        padding: 20px;
    }

    .schedule-item {
        grid-template-columns: 1fr;
        gap: 10px;
    }

    .schedule-time {
        text-align: left;
    }

    .membership {
        align-items: flex-start;
        flex-direction: column;
    }

    .status {
        align-self: flex-start;
    }
}
</style>
</head>

<body>

<header>
    <div class="container navbar">
        <div class="brand">
            <span class="mark">I</span>
            <span>IRONHUB</span>
        </div>

        <div class="profile" id="profileName">
            MEMBER
        </div>
    </div>
</header>

<main class="container">

    <!-- SAPAAN USER -->
    <section class="welcome">
        <small>MEMBER DASHBOARD</small>
        <h1 id="welcomeMessage">Selamat datang!</h1>
        <p>Senang melihatmu kembali. Siap untuk latihan hari ini?</p>
    </section>

    <!-- AREA DASHBOARD DINAMIS -->
    <div id="dashboardContent"></div>

</main>

<footer>
    © 2026 IRONHUB FITNESS CLUB
    <br><br>
    Train Hard. Stay Humble. Keep Growing.
</footer>


<script>

/*
=========================================
DATA DUMMY USER
Nantinya bagian ini bisa diganti dengan
data dari API / database.
=========================================
*/

const userData = {

    name: "Budi",

    membership: {
        active: true,
        remainingDays: 25,
        expiredDate: "11 Desember 2026"
    },

    schedules: [

        {
            trainer: "Andi Pratama",
            day: "Senin",
            date: "23 Nov 2026",
            time: "10.00 - 12.00",
            workout: "Upperbody Workout"
        },

        {
            trainer: "Andi Pratama",
            day: "Rabu",
            date: "25 Nov 2026",
            time: "13.00 - 15.00",
            workout: "Lowerbody Workout"
        },

        {
            trainer: "Andi Pratama",
            day: "Jumat",
            date: "27 Nov 2026",
            time: "10.00 - 12.00",
            workout: "Fullbody Workout"
        }

    ]

};


/*
=========================================
RENDER DASHBOARD
=========================================
*/

function renderDashboard() {

    const welcome = document.getElementById("welcomeMessage");
    const profile = document.getElementById("profileName");
    const content = document.getElementById("dashboardContent");

    welcome.textContent = `Selamat datang, ${userData.name}!`;
    profile.textContent = userData.name.toUpperCase();

    // JIKA MEMBERSHIP BELUM AKTIF
    if (!userData.membership.active) {

        content.innerHTML = `
            <section class="card inactive">

                <div class="inactive-icon">!</div>

                <h2>Membership Belum Aktif</h2>

                <p>
                    Kamu belum mengaktifkan membership.
                    Aktifkan membership sekarang dan mulai
                    perjalanan fitness-mu bersama IRONHUB!
                </p>

                <a href="/membership" class="btn">
                    Aktifkan Membership
                </a>

            </section>
        `;

        return;
    }


    // JIKA MEMBERSHIP AKTIF

    const membership = userData.membership;

    let scheduleHTML = "";

    userData.schedules.forEach(schedule => {

        scheduleHTML += `
            <div class="schedule-item">

                <div class="schedule-day">
                    ${schedule.day}
                    <small>${schedule.date}</small>
                </div>

                <div>
                    <div class="trainer-name">
                        ${schedule.trainer}
                    </div>

                    <div class="workout">
                        ${schedule.workout}
                    </div>
                </div>

                <div class="schedule-time">
                    ${schedule.time}
                </div>

            </div>
        `;

    });


    content.innerHTML = `

        <!-- MEMBERSHIP CARD -->

        <section class="card membership">

            <div>
                <div class="membership-label">
                    SISA MASA MEMBERSHIP
                </div>

                <div class="membership-days">
                    ${membership.remainingDays}
                    <span style="font-size:17px">Hari</span>
                </div>

                <div class="membership-info">
                    Berlaku sampai ${membership.expiredDate}
                </div>
            </div>

            <div class="status">
                MEMBERSHIP AKTIF
            </div>

        </section>


        <!-- JADWAL LATIHAN -->

        <section class="card">

            <h2 class="card-title">
                Jadwal Latihan Personal Trainer
            </h2>

            <div class="schedule-list">
                ${scheduleHTML}
            </div>

        </section>

    `;

}


// JALANKAN DASHBOARD
renderDashboard();

</script>

</body>
</html>
