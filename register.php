<?php
require_once 'config.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($username) || empty($email) || empty($password)) {
        $error = "請完整填寫所有欄位。";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "電子信箱格式錯誤。";
    } elseif (strlen($password) < 6) {
        $error = "密碼長度至少6位元。";
    } else {
        // 檢查帳號是否重複
        $stmt = $conn->prepare("SELECT user_id FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $error = "帳號已被使用，請更換其他帳號。";
        } else {
            $password_hash = password_hash($password, PASSWORD_DEFAULT);
            $user_id = uniqid('user_');

            $stmt = $conn->prepare("INSERT INTO users (user_id, username, name, email, password_hash) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sssss", $user_id, $username, $username, $email, $password_hash);

            if ($stmt->execute()) {
                $success = "註冊成功，請<a href='login.php'>登入</a>。";
            } else {
                $error = "註冊失敗：" . $conn->error;
            }
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="zh-Hant">
<head>
<meta charset="utf-8"/>
<title>註冊新帳號</title>
<link href="style.css" rel="stylesheet"/>
</head>
<body>
<header>註冊新帳號</header>
<div class="container">
  <div class="card">
    <?php if ($error): ?>
      <div class="error-msg"><?php echo $error; ?></div>
    <?php elseif ($success): ?>
      <div class="success-msg"><?php echo $success; ?></div>
    <?php endif; ?>
    <form method="post" action="">
      <label>帳號</label>
      <input type="text" name="username" value="<?php echo htmlspecialchars($username ?? ''); ?>" required>
      <label>密碼</label>
      <input type="password" name="password" required>
      <label>電子郵件</label>
      <input type="email" name="email" value="<?php echo htmlspecialchars($email ?? ''); ?>" required>
      <button type="submit" class="btn">註冊</button>
    </form>
  </div>
</div>
</body>
</html>
