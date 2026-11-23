
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - GYMBRO</title>

  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: Arial, sans-serif;
    }

    body {
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      background: #101411;
      color: #fff;
      padding: 20px;
    }

    .login-container {
      width: 100%;
      max-width: 420px;
      background: #1a211c;
      padding: 40px 32px;
      border-radius: 14px;
      border: 1px solid #303b32;
    }

    .logo {
      text-align: center;
      font-size: 30px;
      font-weight: 800;
      color: #c8f169;
      letter-spacing: 2px;
      margin-bottom: 10px;
    }

    .subtitle {
      text-align: center;
      color: #a4ada5;
      font-size: 14px;
      margin-bottom: 32px;
    }

    .form-group {
      margin-bottom: 20px;
    }

    label {
      display: block;
      margin-bottom: 9px;
      font-size: 14px;
      font-weight: bold;
    }

    input, select {
      width: 100%;
      padding: 14px;
      background: #101411;
      border: 1px solid #3a463c;
      border-radius: 8px;
      color: #fff;
      font-size: 14px;
      outline: none;
    }

    input:focus, select:focus {
      border-color: #c8f169;
    }

    select option {
      background: #1a211c;
      color: #fff;
    }

    .login-button {
      width: 100%;
      padding: 15px;
      margin-top: 8px;
      border: none;
      border-radius: 8px;
      background: #c8f169;
      color: #101411;
      font-size: 15px;
      font-weight: bold;
      cursor: pointer;
      transition: 0.2s;
    }

    .login-button:hover {
      background: #d8ff7b;
      transform: translateY(-2px);
    }

    .footer-text {
      text-align: center;
      color: #879188;
      font-size: 12px;
      margin-top: 25px;
    }

    @media (max-width: 480px) {
      .login-container {
        padding: 32px 22px;
      }
    }
  </style>
</head>

<body>

  <div class="login-container">

    <div class="logo">GYMBRO</div>
    <p class="subtitle">Silakan login untuk melanjutkan</p>

    
<form action="{{ route('login.staff') }}" method="POST">
    @csrf

    <div class="form-group">
        <label for="email">Email</label>
        <input
            type="email"
            id="email"
            name="email"
            placeholder="Masukkan email"
            value="{{ old('email') }}"
            required
        >
    </div>

    <div class="form-group">
        <label for="password">Password</label>
        <input
            type="password"
            id="password"
            name="password"
            placeholder="Masukkan password"
            required
        >
    </div>

    <div class="form-group">
        <label for="role">Login Sebagai</label>
        <select id="role" name="role" required>
            <option value="" disabled selected>Pilih role</option>
            <option value="pt">Personal Trainer</option>
            <option value="admin">Admin</option>
        </select>
    </div>

    @if ($errors->any())
        <p style="color: #ff7777; margin-bottom: 15px;">
            {{ $errors->first() }}
        </p>
    @endif

    <button type="submit" class="login-button">
        Login
    </button>
</form>


    <p class="footer-text">
      GYMBRO &copy; 2026
    </p>

  </div>

</body>
</html>
