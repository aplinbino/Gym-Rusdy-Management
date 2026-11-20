
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="theme-color" content="#101510">
<title>Rating Personal Trainer — IRONHUB</title>

<style>
* {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
}

body {
    min-height: 100vh;
    display: grid;
    place-items: center;
    padding: 25px 16px;
    font-family: Arial, Helvetica, sans-serif;
    color: #f4f6ef;
    background:
        radial-gradient(circle at top right, #293b27 0, transparent 38%),
        #101510;
}

.container {
    width: 100%;
    max-width: 480px;
    background: #192119;
    border: 1px solid #344233;
    border-radius: 18px;
    padding: 32px;
    box-shadow: 0 24px 70px #0008;
}

/* BRAND */
.brand {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 30px;
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

/* HEADER */
.eyebrow {
    color: #c8f169;
    font-size: 11px;
    font-weight: 800;
    letter-spacing: 2px;
    text-transform: uppercase;
}

h1 {
    margin: 12px 0;
    font-size: 30px;
}

.subtitle {
    color: #aab4a7;
    font-size: 14px;
    line-height: 1.6;
    margin-bottom: 27px;
}

/* TRAINER PROFILE */
.trainer {
    display: flex;
    align-items: center;
    gap: 15px;
    padding: 17px;
    background: #101710;
    border: 1px solid #303b30;
    border-radius: 10px;
    margin-bottom: 28px;
}

.trainer-avatar {
    width: 52px;
    height: 52px;
    display: grid;
    place-items: center;
    border-radius: 50%;
    background: #344b2d;
    color: #c8f169;
    font-size: 20px;
    font-weight: 900;
}

.trainer-info h3 {
    font-size: 15px;
    margin-bottom: 5px;
}

.trainer-info p {
    font-size: 12px;
    color: #aab4a7;
}

/* RATING */
.rating-section {
    text-align: center;
    margin-bottom: 28px;
}

.rating-section h3 {
    font-size: 15px;
    margin-bottom: 15px;
}

.stars {
    display: flex;
    justify-content: center;
    gap: 8px;
    margin-bottom: 12px;
}

.star {
    border: none;
    background: none;
    color: #465143;
    font-size: 38px;
    cursor: pointer;
    transition: .2s;
    padding: 2px;
}

.star.active {
    color: #c8f169;
}

.star:hover {
    transform: scale(1.15);
}

.rating-text {
    color: #aab4a7;
    font-size: 13px;
    min-height: 18px;
}

/* REVIEW */
.review-section {
    margin-bottom: 22px;
}

.review-section label {
    display: block;
    font-size: 13px;
    font-weight: bold;
    margin-bottom: 10px;
}

textarea {
    width: 100%;
    min-height: 125px;
    resize: vertical;
    padding: 14px;
    background: #101710;
    border: 1px solid #3a4938;
    border-radius: 8px;
    color: #f4f6ef;
    outline: none;
    font-family: inherit;
    font-size: 14px;
    line-height: 1.6;
}

textarea::placeholder {
    color: #758071;
}

textarea:focus {
    border-color: #c8f169;
    box-shadow: 0 0 0 3px #c8f16922;
}

.character-count {
    text-align: right;
    color: #82907e;
    font-size: 11px;
    margin-top: 8px;
}

/* BUTTON */
.btn-submit {
    width: 100%;
    min-height: 50px;
    border: none;
    border-radius: 8px;
    background: #c8f169;
    color: #11170d;
    font-size: 14px;
    font-weight: 800;
    cursor: pointer;
    transition: .2s;
}

.btn-submit:hover {
    background: #d8ff85;
    transform: translateY(-2px);
}

.btn-submit:disabled {
    opacity: .5;
    cursor: not-allowed;
    transform: none;
}

.back-link {
    display: block;
    text-align: center;
    margin-top: 20px;
    color: #aab4a7;
    text-decoration: none;
    font-size: 13px;
}

.back-link:hover {
    color: #c8f169;
}

@media(max-width: 480px) {
    .container {
        padding: 25px 20px;
    }

    h1 {
        font-size: 26px;
    }

    .star {
        font-size: 34px;
    }
}
</style>
</head>

<body>

<main class="container">

    <div class="brand">
        <span class="mark">I</span>
        <span>IRONHUB</span>
    </div>

    <div class="eyebrow">Member Feedback</div>

    <h1>Beri Rating PT</h1>

    <p class="subtitle">
        Bagaimana pengalaman latihanmu?
        Berikan penilaian dan ulasan untuk Personal Trainer
        yang telah membantumu berlatih.
    </p>

    <!-- PROFIL PERSONAL TRAINER -->
    <div class="trainer">

        <div class="trainer-avatar">
            A
        </div>

        <div class="trainer-info">
            <h3 id="trainerName">Andi Pratama</h3>
            <p>Personal Trainer IRONHUB</p>
        </div>

    </div>


    <!-- FORM RATING -->
    <form action="/dashboard_user" method="POST" id="ratingForm">

        <!-- ID PT -->
        <input type="hidden" name="trainer_id" value="PT001">

        <!-- NILAI BINTANG -->
        <input type="hidden" name="rating" id="ratingValue" value="">

        <section class="rating-section">

            <h3>Berapa bintang untuk PT ini?</h3>

            <div class="stars">

                <button type="button" class="star"
                    data-value="1" aria-label="1 bintang">★</button>

                <button type="button" class="star"
                    data-value="2" aria-label="2 bintang">★</button>

                <button type="button" class="star"
                    data-value="3" aria-label="3 bintang">★</button>

                <button type="button" class="star"
                    data-value="4" aria-label="4 bintang">★</button>

                <button type="button" class="star"
                    data-value="5" aria-label="5 bintang">★</button>

            </div>

            <p class="rating-text" id="ratingText">
                Pilih rating bintangmu
            </p>

        </section>


        <!-- ULASAN -->
        <section class="review-section">

            <label for="review">
                Tulis Ulasan
            </label>

            <textarea
                id="review"
                name="review"
                maxlength="200"
                placeholder="Ceritakan pengalaman latihanmu bersama PT ini..."
                required
            ></textarea>

            <div class="character-count">
                <span id="charCount">0</span>/200 karakter
            </div>

        </section>


        <!-- SUBMIT -->
        <button type="submit" class="btn-submit">
            Kirim Rating
        </button>

    </form>

    <a href="/dashboard" class="back-link">
        ← Kembali ke Dashboard
    </a>

</main>


<script>

// PILIHAN RATING BINTANG

const stars = document.querySelectorAll(".star");
const ratingValue = document.getElementById("ratingValue");
const ratingText = document.getElementById("ratingText");

const ratingDescriptions = {
    1: "Sangat buruk",
    2: "Buruk",
    3: "Cukup baik",
    4: "Sangat baik",
    5: "Luar biasa!"
};

stars.forEach(star => {

    star.addEventListener("click", () => {

        const value = Number(star.dataset.value);

        ratingValue.value = value;

        stars.forEach(item => {

            const starValue = Number(item.dataset.value);

            item.classList.toggle(
                "active",
                starValue <= value
            );

        });

        ratingText.textContent = ratingDescriptions[value];

    });

});


// PENGHITUNG KARAKTER ULASAN

const review = document.getElementById("review");
const charCount = document.getElementById("charCount");

review.addEventListener("input", () => {

    charCount.textContent = review.value.length;

});


// VALIDASI SEBELUM KIRIM

const form = document.getElementById("ratingForm");

form.addEventListener("submit", (event) => {

    if (!ratingValue.value) {

        event.preventDefault();

        alert("Silakan pilih rating bintang terlebih dahulu!");

        return;

    }

    if (!review.value.trim()) {

        event.preventDefault();

        alert("Silakan tulis ulasan terlebih dahulu!");

        return;

    }

});

</script>

</body>
</html>
