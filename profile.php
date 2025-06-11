<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>

<html lang="zh-Hant">
<head>
<meta charset="utf-8"/>
<title>個人設定</title>
<link href="style.css" rel="stylesheet"/>
<style>
@media (min-width: 768px) {
  .container {
    max-width: 720px;
    margin: auto;
  }
}

@media screen and (max-width: 768px) {
  .container {
    margin: 0 auto;
    padding: 30px 15px 20px;
  }

  .card {
    margin-top: 30px;
    padding: 24px;
  }

  button {
    width: 100%;
    font-size: 18px;
    padding: 14px;
    margin-top: 10px;
  }

  input, select {
    font-size: 16px;
    padding: 12px;
  }
}
</style><style><style>
.fab {
  position: fixed;
  bottom: 20px;
  width: 48px;
  height: 48px;
  border-radius: 50%;
  font-size: 20px;
  color: white;
  border: none;
  cursor: pointer;
  box-shadow: 0 4px 8px rgba(0,0,0,0.3);
  z-index: 999;
}
.fab-left {
  left: 20px;
  background: #ffa726;
}
.fab-right {
  right: 20px;
  background: #1976d2;
}
</style></style></head>
<body>
<div style="position:fixed; top:15px; right:15px; z-index:1000;">
<button onclick="location.href='logout.php'" style="background:#005757; color:#fff; border:none; padding:8px 12px; border-radius:15px; cursor:pointer;">登出</button>
</div>


<header>個人設定</header>
<div class="container">
<div class="card">
<label>使用者名稱</label><input type="text"/>
<label>電子信箱</label><input type="email"/>
<label>變更密碼</label><input type="password"/>
<button>更新</button>
</div>
</div>
<button class="fab fab-left" onclick="location.href='index.php'" title="返回主頁">←</button>
</body>
</html>
