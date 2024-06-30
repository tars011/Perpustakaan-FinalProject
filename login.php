<?php
session_start(); // Start the session

include 'koneksi.php';

//cek cookie
if( isset($_COOKIE['login']) ) {
    if ( $_COOKIE['login'] == 'true' ) {
        $stmt = $conn->prepare("SELECT username, nama, email FROM user WHERE id_user = ?");
        $stmt->bind_param("s", $_COOKIE['id_user'],);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        $_SESSION['login'] = true;
        $_SESSION['id_user'] = $_COOKIE['id_user'];
        $_SESSION['username'] = $row['username'];
        $_SESSION['name'] = $row['nama'];
        $_SESSION['email'] = $row['email'];
    }
}

//cek session
if( isset($_SESSION["login"]) ) {
    header("Location: index.php");
    exit;
}

// autentifikasi login
if (isset($_POST['login'])) {
    include 'koneksi.php';

    $useroremail = $_POST['useroremail'];
    $password = $_POST['password'];

    // Prepared statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT * FROM user WHERE email = ? OR username = ?");
    $stmt->bind_param("ss", $useroremail, $useroremail);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if ($password === $row['password']) {
            $_SESSION['login'] = true;
            $_SESSION['id_user'] = $row['id_user'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['name'] = $row['nama'];
            $_SESSION['email'] = $row['email'];

            // cek remember me
            if( isset($_POST['remember']) ) {
                // buat cookie
                $cookie_expire = time() + (1 * 24 * 60 * 60); // 1 hari dalam detik
                setcookie('login', 'true', $cookie_expire);
                setcookie('id_user', $row['id_user'], $cookie_expire);
            }

            if ($row['email'] === 'admin64nteng@gmail.com' || $row['username'] === 'admin') {
                header("Location: admin-page/admin.php");
            } else {
                header("Location: index.php");
            }
            exit(); // Ensure no further code is executed
        } else {
            $_SESSION['error'] = "Password Salah.";
            header("Location: login.php");
            exit();
        }
    } else {
        $_SESSION['error'] = "No user found with that email.";
        header("Location: login.php");
    }

    $stmt->close();
    $conn->close();
}

// register akun
if (isset($_POST['register'])) {
    include 'config.php';

    $username = $_POST['username'];
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $no_telepon = $_POST['no_telepon'];
    $password = $_POST['password'];

    // Check if username or email already exists
    $stmt = $conn->prepare("SELECT * FROM user WHERE email = ? OR username = ?");
    $stmt->bind_param("ss", $email, $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $_SESSION['error'] = "Username or email already used.";
        header("Location: login.php");
    } else {
        // Prepared statement to prevent SQL injection
        $stmt = $conn->prepare("INSERT INTO user (username, nama, email, no_telepon, password) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $username, $nama, $email, $no_telepon, $password);
    
        if ($stmt->execute()) {
            $_SESSION['success'] = "Account created successfully.";
            header("Location: login.php");
        } else {
            $_SESSION['error'] = "Failed to create account.";
            header("Location: login.php");
        }
    }

    $stmt->close();
    $conn->close();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="icon" type="image/png" href="images/books.png">
    <title>Login</title>
</head>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap');

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Montserrat', sans-serif;
    }

    body {
        background-color: #c9d6ff;
        background: linear-gradient(to right, #e2e2e2, #c9d6ff);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        height: 100vh;
    }

    .container {
        background-color: #fff;
        border-radius: 30px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.35);
        position: relative;
        overflow: hidden;
        width: 768px;
        max-width: 100%;
        min-height: 480px;
    }

    .container p {
        font-size: 14px;
        line-height: 20px;
        letter-spacing: 0.3px;
        margin: 20px 0;
    }

    .container span {
        margin-bottom: 8px;
        font-size: 12px;
    }

    .container a {
        color: #333;
        font-size: 13px;
        text-decoration: none;
        margin: 15px 0 10px;
    }

    .container button.submit {
        background-color: #4481eb;
        color: #fff;
        font-size: 12px;
        padding: 10px 45px;
        border: 1px solid transparent;
        border-radius: 8px;
        font-weight: 600;
        letter-spacing: 0.5px;
        text-transform: uppercase;
        margin-top: 10px;
        cursor: pointer;
        transition: background-color 0.3s, transform 0.3s; /* New */
    }

    .container button.submit:hover { /* New */
        background-color: #6a1b9a;
    }

    .container button.submit:active { /* New */
        transform: scale(0.95);
    }

    .container button.hidden {
        background-color: transparent;
        border-color: #fff;
    }

    .container button.hidden:hover { /* New */
        background-color: rgba(255, 255, 255, 0.1);
    }

    .container form {
        background-color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        padding: 0 40px;
        height: 100%;
    }

    .container input {
        background-color: #eee;
        border: none;
        margin: 8px 0;
        padding: 10px 15px;
        font-size: 13px;
        border-radius: 8px;
        width: 100%;
        outline: none;
    }
    
    .container input:focus {
        outline: 2px solid #c9d6ff;
    }

    .form-container {
        position: absolute;
        top: 0;
        height: 100%;
        transition: all 0.6s ease-in-out;
    }

    .sign-in {
        left: 0;
        width: 50%;
        z-index: 2;
    }

    .sign-in h1 {
        border: 1px solid;
        border-radius: 3px;
        padding: 2px 10px;
        margin-right: auto;
    }

    .sign-in h1 span {
        font-size: inherit;
        color: #8e44ad;
    }

    .container.active .sign-in {
        transform: translateX(100%);
    }

    .sign-up {
        left: 0;
        width: 50%;
        opacity: 0;
        z-index: 1;
    }

    .sign-up h1 {
        width: 100%;
        text-align: center;
        border: 1px solid;
        border-radius: 3px;
        padding: 2px 10px;
        margin-left: auto;
    }

    .sign-up h1 span {
        font-size: inherit;
        color: #8e44ad;
    }

    .sign-up span{
        margin-top: 16px;
    }

    .container.active .sign-up {
        transform: translateX(100%);
        opacity: 1;
        z-index: 5;
        animation: move 0.6s;
    }

    @keyframes move {
        0%,
        49.99% {
            opacity: 0;
            z-index: 1;
        }

        50%,
        100% {
            opacity: 1;
            z-index: 5;
        }
    }
    
    .white-gap {
    <?php if (isset($_SESSION['error'])) {
        echo 'margin: 10px 0;';
    } else {
        echo 'margin: 20px 0;';
    } ?>
        
    }

    .white-gap a {
        border: 1px solid #ccc;
        border-radius: 20%;
        display: inline-flex;
        justify-content: center;
        align-items: center;
        margin: 0 3px;
        width: 100%;
        height: 40px;
    }

    .toggle-container {
        position: absolute;
        top: 0;
        left: 50%;
        width: 50%;
        height: 100%;
        overflow: hidden;
        transition: all 0.6s ease-in-out;
        /* border-radius: 150px 0 0 100px; */
        border-radius: 120px 30px 30px 80px;
        border-left: 3px solid aquamarine;
        border-right: 0;
        border-top: 0;
        border-bottom: 0;
        z-index: 1000;
    }

    .container.active .toggle-container {
        transform: translateX(-100%);
        border-radius: 30px 120px 80px 30px;
        border-right: 3px solid cadetblue;
        border-left: 0;
    }

    .toggle {
        background-color: #4481eb;
        height: 100%;
        background: linear-gradient(to right, #386ad5, #4481eb);
        color: #fff;
        position: relative;
        left: -100%;
        height: 100%;
        width: 200%;
        transform: translateX(0);
        transition: all 0.6s ease-in-out;
    }

    .container.active .toggle {
        transform: translateX(50%);
    }

    .toggle-panel {
        position: absolute;
        width: 50%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        padding: 0 30px;
        text-align: center;
        top: 0;
        transform: translateX(0);
        transition: all 0.6s ease-in-out;
    }

    .toggle-left {
        transform: translateX(-200%);
    }

    .container.active .toggle-left {
        transform: translateX(0);
    }

    .toggle-right {
        right: 0;
        transform: translateX(0);
    }

    .container.active .toggle-right {
        transform: translateX(200%);
    }

    /* Styles for Remember Me section */
    .remember-me-container {
        display: flex;
        align-items: center;
        margin: 0 0 20px;
        width: 100%;
        justify-content: center;
    }

    .remember-me-container input {
        margin-right: 10px;
        width: auto;
    }

    .remember-me-container label {
        font-size: 12px;
        color: #333;
    }

    /* Styles for show password button */
    .show-password-btn {
        position: absolute;
        right: 10px;
        top: 50%;
        transform: translateY(-50%);
        cursor: pointer;
        font-size: 12px;
        background: none;
        border: none;
        color: #333;
        padding: 0;
        outline: none;
        transition: color 0.3s;  /* New */
    }

    .show-password-btn:hover { /* New */
        color: #512da8;
    }

    /* media queries  */

    @media (max-width:768px){
    h1 {
        font-size: 1.7rem;
    }

    .sign-up h1 {
        width: 100%;
        text-align: center;
        border: 1px solid;
        border-radius: 3px;
        padding: 2px 10px;
        margin-left: auto;
    }
    }

    @media (max-width:450px){
    h1 {
        font-size: 1.4rem;
    }

    .sign-up h1 {
        width: 100%;
        text-align: center;
        border: 1px solid;
        border-radius: 3px;
        padding: 2px 10px;
        margin-left: auto;
    }
    }

</style>

<body>
    <div class="container" id="container">
        <div class="form-container sign-up" id="signup">
            <form method="post" action="login.php">
                <h1>Create <span>Account</span></h1>
                <span>Gunakan email untuk registrasi</span>
                <input type="text" name="username" placeholder="Username" required>
                <input type="text" name="nama" placeholder="Name" required>
                <input type="email" name="email" placeholder="Email" required>
                <input type="text" name="no_telepon" placeholder="Phone Number" required>
                <div style="position: relative; width: 100%;">
                    <input type="password" name="password" placeholder="Password" required>
                    <button type="button" class="show-password-btn" onclick="togglePassword(this)">Show</button>
                </div>
                <button class="submit" type="submit" name="register">Sign up</button>
            </form>
        </div>
        <div class="form-container sign-in">
            <form method="post" action="login.php">
                <h1>Sign In to <span>Library</span></h1>
                <div class="white-gap">
                    <!--  -->
                    <?php if( isset($_SESSION['error'] )): ?>
                    <div style="color: red; font-style: italic; font-weight: lighter;"><?= $_SESSION['error']; ?></div>
                    <?php unset($_SESSION['error']); endif; ?>
                </div>
                <span>Gunakan email and password</span>
                <input type="text" id="useroremail" name="useroremail" placeholder="E-mail or username" required>
                <div style="position: relative; width: 100%;">
                    <input type="password" name="password" placeholder="Password" required>
                    <button type="button" class="show-password-btn" onclick="togglePassword(this)">Show</button>
                </div>
                <div class="remember-me-container">
                    <input type="checkbox" id="remember" name="remember">
                    <label for="remember">Remember Me</label>
                </div>
                <button class="submit" type="submit" name="login">Sign In</button>
            </form>
        </div>
        <div class="toggle-container">
            <div class="toggle">
                <div class="toggle-panel toggle-left">
                    <h1>Sudah punya akun?</h1>
                    <p>Silahkan masuk dengan mengklik tombol di bawah.</p>
                    <button class="submit hidden" id="login">Sign in</button>
                </div>
                <div class="toggle-panel toggle-right">
                    <h1>Belum punya akun?</h1>
                    <p>Daftarkan akun barumu dengan mengklik tombol di bawah.</p>
                    <button class="submit hidden" id="register">Sign up</button>
                </div>
            </div>
        </div>
    </div>

    <script src="js/login_script.js"></script>
    <script>
        function togglePassword(element) {
            const input = element.previousElementSibling;
            if (input.type === 'password') {
                input.type = 'text';
                element.textContent = 'Hide';
            } else {
                input.type = 'password';
                element.textContent = 'Show';
            }
        }

        <?php if (isset($_SESSION['error'])): ?>
            alert("<?php echo $_SESSION['error']; unset($_SESSION['error']); ?>");
        <?php endif; ?>

        <?php if (isset($_SESSION['success'])): ?>
            alert("<?php echo $_SESSION['success']; unset($_SESSION['success']); ?>");
        <?php endif; ?>
    </script>
</body>

</html>
