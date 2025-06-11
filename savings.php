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
$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['create'])) {
        $plan_id = uniqid('plan_');
        $name = $_POST['name'];
        $target = $_POST['target_amount'];
        $end = $_POST['target_date'];
        $start = date('Y-m-d');

        if ($end < $start) {
            $error = "目標日期不得早於今天。";
        } else {
            $stmt = $conn->prepare("INSERT INTO savings_plans (plan_id, name, target_amount, start_date, target_date, user_id) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssddss", $plan_id, $name, $target, $start, $end, $uid);
            $stmt->execute();
        }
    } elseif (isset($_POST['delete'])) {
        $stmt = $conn->prepare("DELETE FROM savings_plans WHERE plan_id = ? AND user_id = ?");
        $stmt->bind_param("ss", $_POST['plan_id'], $uid);
        $stmt->execute();
    } elseif (isset($_POST['update'])) {
        $stmt = $conn->prepare("UPDATE savings_plans SET name = ?, target_amount = ?, target_date = ? WHERE plan_id = ? AND user_id = ?");
        $stmt->bind_param("sdsss", $_POST['name'], $_POST['target_amount'], $_POST['target_date'], $_POST['plan_id'], $uid);
        $stmt->execute();
    }
}

$result = $conn->query("SELECT * FROM savings_plans WHERE user_id = '$uid' ORDER BY target_date ASC");
?>
<!DOCTYPE html>
<html lang="zh-Hant">
<head><meta charset="UTF-8"><title>儲蓄計畫</title><link rel="stylesheet" href="style.css"></head>
<body>
<div style="position:fixed; top:15px; right:15px; z-index:1000;">
<button onclick="location.href='logout.php'" style="background:#005757; color:#fff; border:none; padding:8px 12px; border-radius:15px; cursor:pointer;">登出</button>
</div>


<header>儲蓄計畫</header>
<div class="container">
<div class="card">
<form method="post">
<label>計畫名稱</label><input name="name" type="text" required>
<label>目標金額</label><input name="target_amount" type="number" required>
<label>目標日期</label><input name="target_date" type="date" required min="<?php echo date('Y-m-d'); ?>">
<input type="hidden" name="create" value="1">
<button type="submit">建立</button>
</form>
<?php if ($error): ?><div style="color:red"><?php echo $error; ?></div><?php endif; ?>
</div>
<div class="card">
<?php while($row = $result->fetch_assoc()): ?>
<form method="post" style="margin-bottom: 20px;">
    <input type="hidden" name="plan_id" value="<?php echo $row['plan_id']; ?>">
    <label>計畫名稱</label><input name="name" value="<?php echo $row['name']; ?>" required>
    <label>目標金額</label><input name="target_amount" type="number" value="<?php echo $row['target_amount']; ?>" required>
    <label>目標日期</label><input name="target_date" type="date" value="<?php echo $row['target_date']; ?>" required min="<?php echo date('Y-m-d'); ?>">
    <button name="update" value="1">更新</button>
    <button name="delete" value="1" onclick="return confirm('確認刪除此筆計畫？')">刪除</button>
</form>
<?php endwhile; ?>
</div>
</div>
<button class="fab fab-left" onclick="location.href='index.php'">←</button>
</body>
</html>