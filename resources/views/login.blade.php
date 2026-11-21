<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="theme-color" content="#111811">
  <title>Login Member — IRONHUB</title>
  <style>
    * { box-sizing: border-box; }
    body {
      margin: 0; min-height: 100vh; padding: 32px 18px;
      display: grid; place-items: center;
      font-family: Arial, Helvetica, sans-serif; color: #f4f6ef;
      background: radial-gradient(circle at top right, #293b27 0, transparent 38%), #101510;
    }
    .card {
      width: min(100%, 440px); padding: 38px;
      background: #192119; border: 1px solid #344233;
      border-radius: 18px; box-shadow: 0 24px 70px #0008;
    }
    .brand { display: flex; align-items: center; gap: 10px; margin-bottom: 30px; font-weight: 900; letter-spacing: .13em; }
    .mark {
      width: 36px; height: 36px; display: grid; place-items: center;
      color: #101510; background: #c8f169; border-radius: 9px; font-size: 20px;
    }
    .eyebrow { color: #c8f169; font-size: 11px; font-weight: 800; letter-spacing: .18em; text-transform: uppercase; }
    h1 { margin: 10px 0 9px; font-size: 32px; letter-spacing: -.04em; }
    .subtitle { margin: 0 0 27px; color: #aab4a7; font-size: 14px; line-height: 1.6; }
    form { display: grid; gap: 16px; }
    label { display: block; margin-bottom: 7px; color: #e6ebdf; font-size: 13px; font-weight: 700; }
    input {
      width: 100%; height: 48px; padding: 0 14px;
      color: #f4f6ef; background: #101710; border: 1px solid #3a4938;
      border-radius: 8px; outline: none; font-size: 14px;
    }
    input::placeholder { color: #758071; }
    input:focus { border-color: #c8f169; box-shadow: 0 0 0 3px #c8f16922; }
    button {
      width: 100%; min-height: 50px; margin-top: 5px; border: 0; border-radius: 8px;
      color: #11170d; background: #c8f169; font-size: 14px; font-weight: 800;
      cursor: pointer; transition: background .2s, transform .2s;
    }
    button:hover { background: #d8ff85; transform: translateY(-1px); }
    .register { margin: 22px 0 0; color: #aab4a7; text-align: center; font-size: 13px; }
    .register a { color: #c8f169; font-weight: 700; text-decoration: none; }
    .register a:hover { text-decoration: underline; }
    @media (max-width: 480px) { .card { padding: 28px 22px; } h1 { font-size: 28px; } }
  </style>
</head>
<body>
  <main class="card">
    <div class="brand"><span class="mark">I</span><span>IRONHUB</span></div>
    <div class="eyebrow">Selamat datang kembali</div>
    <h1>Login Member</h1>
    <p class="subtitle">Masuk ke akun IRONHUB kamu untuk mengakses dashboard dan jadwal latihan.</p>

    <!-- Menggunakan action="/user_dashboard" agar langsung berpindah halaman saat disubmit -->
    

    <form action="{{ route('sign_up.store') }}" method="POST">
        @csrf

        <div>
            <label for="name">Nama lengkap</label>
            <input
                id="name"
                name="name"
                type="text"
                placeholder="Masukkan nama lengkap"
                autocomplete="name"
                value="{{ old('name') }}"
                required
            >

            @error('name')
                <small style="color: red;">{{ $message }}</small>
            @enderror
        </div>

        <div>
            <label for="email">Email</label>
            <input
                id="email"
                name="email"
                type="email"
                placeholder="nama@email.com"
                autocomplete="email"
                value="{{ old('email') }}"
                required
            >

            @error('email')
                <small style="color: red;">{{ $message }}</small>
            @enderror
        </div>

        <div>
            <label for="phone">Nomor telepon</label>
            <input
                id="phone"
                name="phone"
                type="tel"
                placeholder="Contoh: 081234567890"
                autocomplete="tel"
                value="{{ old('phone') }}"
            >

            @error('phone')
                <small style="color: red;">{{ $message }}</small>
            @enderror
        </div>

        <div>
            <label for="password">Password</label>
            <input
                id="password"
                name="password"
                type="password"
                placeholder="Minimal 8 karakter"
                minlength="8"
                autocomplete="new-password"
                required
            >

            @error('password')
                <small style="color: red;">{{ $message }}</small>
            @enderror
        </div>

        <div>
            <label for="password_confirmation">
                Konfirmasi password
            </label>
            <input
                id="password_confirmation"
                name="password_confirmation"
                type="password"
                placeholder="Masukkan ulang password"
                minlength="8"
                autocomplete="new-password"
                required
            >
        </div>

        <button type="submit">Daftar Sekarang</button>
    </form>



    <p class="register">Belum punya akun? <a href="/sign_up">Daftar sekarang</a></p>
  </main>
</body>
</html>
