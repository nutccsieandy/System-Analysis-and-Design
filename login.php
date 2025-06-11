<?php
session_start();
require_once 'config.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($username) || empty($password)) {
        $error = "請輸入帳號與密碼。";
    } else {
        $stmt = $conn->prepare("SELECT user_id, password_hash FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->bind_result($user_id, $password_hash);
        if ($stmt->fetch()) {
            if (password_verify($password, $password_hash)) {
                $_SESSION['user_id'] = $user_id;
                header("Location: index.php");
                exit();
            } else {
                $error = "密碼錯誤。";
            }
        } else {
            $error = "帳號不存在。";
        }
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="utf-8">
    <title>使用者登入</title>
    <link href="style.css" rel="stylesheet" />
</head>
<body>
<header>使用者登入</header>
<div class="container">
    <div class="card">
        <?php if ($error): ?>
            <div class="error-msg"><?php echo $error; ?></div>
        <?php endif; ?>
        <form method="post" action="login.php">
            <label>帳號</label>
            <input type="text" name="username" placeholder="請輸入帳號" required />
            <label>密碼</label>
            <input type="password" name="password" placeholder="請輸入密碼" required />
            <button type="submit" class="btn">登入</button>
        </form>
        <button type="button" class="btn btn-green" onclick="location.href='register.php'">尚未註冊？</button>
    </div>
</div>
</body>
</html>
