<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>UniVerse | Login Portal</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: "Poppins", sans-serif;
    }

    body {
      background: linear-gradient(120deg, #004080, #0055b8);
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 20px;
      color: #333;
    }

    .container {
      display: flex;
      width: 90%;
      max-width: 1000px;
      background: #ffffffee;
      border-radius: 20px;
      overflow: hidden;
      box-shadow: 0 15px 35px rgba(0, 0, 0, 0.3);
      animation: slideUp 0.6s ease;
    }

    @keyframes slideUp {
      from {transform: translateY(40px); opacity: 0;}
      to {transform: translateY(0); opacity: 1;}
    }

    /* Left Panel */
    .left-panel {
      flex: 1;
      background: linear-gradient(180deg, #004080, #0055b8);
      color: white;
      padding: 50px 40px;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      text-align: center;
    }

    .university-logo {
      width: 180px;
      height: 180px;
      border-radius: 50%;
      background: rgba(255, 255, 255, 0.15);
      display: flex;
      justify-content: center;
      align-items: center;
      overflow: hidden;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
      border: 2px solid #ffffff55;
      margin-bottom: 25px;
    }

    .university-logo img {
      width: 60%;            /* adjust size inside circle */
      height: auto;
      object-fit: contain;   /* prevents stretching */
      filter: drop-shadow(0 2px 4px rgba(0,0,0,0.3));
    }

    .left-panel h2 { font-size: 28px; font-weight: 600; margin-bottom: 15px; }
    .left-panel p { font-size: 15px; opacity: 0.9; }

    /* Right Panel */
    .right-panel {
      flex: 1;
      padding: 50px 55px;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
    }

    .login-header {
      text-align: center;
      margin-bottom: 25px;
      transition: 0.4s ease;
    }

    .login-header h1 {
      color: #004080;
      font-size: 32px;
      font-weight: 700;
      margin-bottom: 10px;
    }

    .login-header p { color: #7f8c8d; font-size: 15px; }

    .input-group {
      margin-bottom: 25px;
      position: relative;
    }

    .input-group label {
      margin-bottom: 8px;
      display: block;
      font-weight: 500;
      color: #004080;
    }

    .input-group input, .input-group select {
      width: 100%;
      padding: 15px 15px 15px 45px;
      border: 2px solid #dfe6f3;
      border-radius: 10px;
      font-size: 16px;
      background: #fff;
      transition: all 0.3s;
    }

    .input-group i {
      position: absolute;
      left: 15px;
      top: 45px;
      color: #7f8c8d;
      font-size: 18px;
    }

    .input-group input:focus, .input-group select:focus {
      border-color: #004080;
      box-shadow: 0 0 0 3px rgba(0, 64, 128, 0.2);
    }

    .login-btn {
      width: 100%;
      padding: 15px;
      background: #004080;
      color: #fff;
      border: none;
      border-radius: 10px;
      font-size: 18px;
      font-weight: 600;
      margin-top: 10px;
      cursor: pointer;
      transition: 0.3s;
    }

    .login-btn:hover { transform: translateY(-2px); }

    .login-footer {
      text-align: center;
      color: #7f8c8d;
      margin-top: 10px;
      font-size: 13px;
    }

    @media (max-width: 900px) {
      .container { flex-direction: column; max-width: 500px; }
    }
  </style>
</head>

<body>
  <div class="container">

    <!-- Left -->
    <div class="left-panel">
      <div class="university-logo">
        <img src="{{ asset('images/logo.png') }}" alt="UniVerse Logo" />
      </div>
      <h2>UniVerse Portal</h2>
      <p>Access Admin, Teacher & Student Services</p>
    </div>

    <!-- Right -->
    <div class="right-panel">
      <div class="login-content">
        <div class="login-header">
          <h1 id="loginTitle">Login</h1>
          <p id="loginSubtitle">Select your role and enter credentials</p>
        </div>

      <form method="POST" action="{{ route('login.submit') }}">
    @csrf

    <div class="input-group">
        <label for="role">Login As</label>
        <i class="fas fa-user-shield"></i>
        <select id="role" name="role">
            <option value="">Select Role</option>
            <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
            <option value="teacher" {{ old('role') == 'teacher' ? 'selected' : '' }}>Teacher</option>
            <option value="student" {{ old('role') == 'student' ? 'selected' : '' }}>Student</option>
        </select>
        @error('role')

            <span class="error" style="color: red">{{ $message }}</span>
        @enderror
    </div>

    <div class="input-group">
        <label for="email">Email</label>
        <i class="fas fa-envelope"></i>
        <input type="email" id="email" name="email" value="{{ old('email') }}" />
        @error('email')
            <span class="error" style="color: red">{{ $message }}</span>
        @enderror
    </div>

    <div class="input-group">
        <label for="password">Password</label>
        <i class="fas fa-lock"></i>
        <input type="password" id="password" name="password" />
        @error('password')
            <span class="error" style="color: red">{{ $message }}</span>
        @enderror
    </div>

    <button type="submit" class="login-btn">Log In</button>
</form>

      </div>

      </div>

      <div class="login-footer">© 2025 UniVerse Portal</div>
    </div>

  </div>

  <script>
    const roleSelect = document.getElementById("role");
    const title = document.getElementById("loginTitle");
    const subtitle = document.getElementById("loginSubtitle");

    roleSelect.addEventListener("change", () => {
      const role = roleSelect.value;

      if (role === "admin") {
        title.textContent = "Admin Login";
        subtitle.textContent = "Enter your admin credentials";
      }
      else if (role === "teacher") {
        title.textContent = "Teacher Login";
        subtitle.textContent = "Enter your teacher account details";
      }
      else if (role === "student") {
        title.textContent = "Student Login";
        subtitle.textContent = "Access your student portal securely";
      }
      else {
        title.textContent = "Login";
        subtitle.textContent = "Select your role and enter credentials";
      }
    });
    
  </script>
</body>
</html>