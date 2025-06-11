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
<title>財務系統首頁</title>
<link href="style.css" rel="stylesheet"/>
<style>
    .grid-cards {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
      gap: 24px;
      justify-content: center;
      padding-top: 30px;
    }

    .card-tile {
      display: flex;
      flex-direction: column;
      align-items: center;
      padding: 28px 20px;
      border-radius: 20px;
      color: white;
      font-size: 20px;
      font-weight: bold;
      text-align: center;
      box-shadow: 0 4px 16px rgba(0, 0, 0, 0.15);
      cursor: pointer;
      transition: transform 0.2s;
    }

    .card-tile:hover {
      transform: scale(1.05);
    }

    .tile-icon {
      font-size: 56px;
      margin-bottom: 16px;
    }

    .tile-orange { background-color: #FFA726; }
    .tile-blue { background-color: #42A5F5; }
    .tile-green { background-color: #66BB6A; }
    .tile-purple { background-color: #AB47BC; }

    @media (min-width: 992px) {
      .container {
        max-width: 960px;
      }
    }

    @media screen and (max-width: 768px) {
      .grid-cards {
        grid-template-columns: 1fr;
        padding: 20px 12px;
      }

      .card-tile {
        width: 90%;
        margin: 0 auto;
        font-size: 22px;
        padding: 28px 16px;
      }

      .tile-icon {
        font-size: 64px;
      }
    }
  </style>
<style><style>
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

<header>財務系統首頁</header>
<div class="container">
<div class="grid-cards">
<div class="card-tile tile-orange" onclick="location.href='records.php'">
<div class="tile-icon">💰</div>
      財務紀錄
    </div>
<div class="card-tile tile-blue" onclick="location.href='savings.php'">
<div class="tile-icon">🏦</div>
      儲蓄計畫
    </div>
<div class="card-tile tile-green" onclick="location.href='dashboard.php'">
<div class="tile-icon">📊</div>
      統計報表
    </div>
<div class="card-tile tile-purple" onclick="location.href='profile.php'">
<div class="tile-icon">👤</div>
      個人設定
    </div>
</div>
</div>
<button class="fab fab-right" onclick="alert('這裡可整合對話機器人或幫助系統')" title="訊息">💬</button>
</body>
</html>
