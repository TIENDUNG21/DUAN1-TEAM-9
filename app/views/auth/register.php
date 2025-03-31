<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Register</title>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
    <link rel="stylesheet" href="/public/css/login.css" />
</head>
<body>
<?php include __DIR__ . '/../share/header.php'; ?>
    <?php include __DIR__ . '/../share/nav.php'; ?>

    <main>
        <div class="login-container">
            <form class="login-form" id="registerForm" method="POST">
                <h2>Register</h2>
                <?php if (isset($error)): ?>
                    <p id="error-message" class="error-message"><?php echo htmlspecialchars($error); ?></p>
                <?php endif; ?>
                <div class="input-box">
                    <input type="text" id="username" name="username" value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>" required />
                    <label>Username</label>
                </div>
                <div class="input-box">
                    <input type="email" id="email" name="email" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" required />
                    <label>Email</label>
                </div>
                <div class="input-box">
                    <input type="text" id="phone" name="phone" value="<?php echo isset($_POST['phone']) ? htmlspecialchars($_POST['phone']) : ''; ?>" required />
                    <label>Phone number</label>
                </div>
                <div class="input-box">
                    <input type="password" id="password" name="password" required />
                    <label>Password</label>
                </div>
                <button type="submit" class="login-btn">Register</button>
                <p class="text-center mt-3">Đã có tài khoản? <a href="/index.php?action=login">Đăng nhập ngay</a></p>
            </form>
        </div>
    </main>
    <?php include __DIR__ . '/../share/footer.php'; ?>

</body>
</html>