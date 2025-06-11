<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>
<?php
require_once 'config.php';
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$uid = $_SESSION['user_id'];
// 收入
$stmt = $conn->prepare("SELECT SUM(amount) AS total_income FROM financial_records WHERE user_id = ? AND category = '收入'");
$stmt->bind_param("s", $uid);
$stmt->execute();
$stmt->bind_result($income);
$stmt->fetch();
$stmt->close();

// 支出
$stmt = $conn->prepare("SELECT SUM(amount) AS total_expense FROM financial_records WHERE user_id = ? AND category = '支出'");
$stmt->bind_param("s", $uid);
$stmt->execute();
$stmt->bind_result($expense);
$stmt->fetch();
$stmt->close();

$income = $income ?? 0;
$expense = $expense ?? 0;
$saving = $income - $expense;
$rate = $income > 0 ? round(($saving / $income) * 100, 2) : 0;
?>
<!DOCTYPE html>
<html lang="zh-Hant">
<head>
  <meta charset="UTF-8">
  <title>統計報表</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
<div style="position:fixed; top:15px; right:15px; z-index:1000;">
<button onclick="location.href='logout.php'" style="background:#005757; color:#fff; border:none; padding:8px 12px; border-radius:15px; cursor:pointer;">登出</button>
</div>


<header>統計報表</header>
<div class="container">
  <div class="card">
    <p><strong>總收入：</strong>$<?php echo $income; ?></p>
    <p><strong>總支出：</strong>$<?php echo $expense; ?></p>
    <p><strong>儲蓄金額：</strong>$<?php echo $saving; ?></p>
    <p><strong>儲蓄率：</strong><?php echo $rate; ?>%</p>
  </div>
</div>
<button class="fab fab-left" onclick="location.href='index.php'">←</button>
</body>
</html>