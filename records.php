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

// CRUD 實作
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['create'])) {
        $record_id = uniqid('rec_');
        $amount = $_POST['amount'];
        $date = $_POST['date'];
        $desc = $_POST['description'];
        $cat = $_POST['category'];

        if ($date < date('Y-m-d')) {
            $error = "日期不能早於今天";
        } else {
            $stmt = $conn->prepare("INSERT INTO financial_records (record_id, amount, date, description, category, user_id) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sdssss", $record_id, $amount, $date, $desc, $cat, $uid);
            $stmt->execute();
        }
    } elseif (isset($_POST['delete'])) {
        $stmt = $conn->prepare("DELETE FROM financial_records WHERE record_id = ? AND user_id = ?");
        $stmt->bind_param("ss", $_POST['record_id'], $uid);
        $stmt->execute();
    } elseif (isset($_POST['update'])) {
        $stmt = $conn->prepare("UPDATE financial_records SET category = ?, amount = ?, description = ?, date = ? WHERE record_id = ? AND user_id = ?");
        $stmt->bind_param("sdssss", $_POST['category'], $_POST['amount'], $_POST['description'], $_POST['date'], $_POST['record_id'], $uid);
        $stmt->execute();
    }
}

$result = $conn->query("SELECT * FROM financial_records WHERE user_id = '$uid' ORDER BY date DESC");
?>
<!DOCTYPE html>
<html lang="zh-Hant">
<head><meta charset="UTF-8"><title>財務紀錄</title><link rel="stylesheet" href="style.css"></head>
<body>
<div style="position:fixed; top:15px; right:15px; z-index:1000;">
<button onclick="location.href='logout.php'" style="background:#005757; color:#fff; border:none; padding:8px 12px; border-radius:15px; cursor:pointer;">登出</button>
</div>


<header>財務紀錄</header>
<div class="container">
<div class="card">
<form method="post">
    <label>類別</label>
    <select name="category"><option>收入</option><option>支出</option></select>
    <label>金額</label>
    <input name="amount" type="number" step="0.01" required>
    <label>說明</label>
    <input name="description" type="text">
    <label>日期</label>
    <input name="date" type="date" required>
    <input type="hidden" name="create" value="1">
    <button type="submit">新增</button>
</form>
<?php if ($error): ?><div style="color:red"><?php echo $error; ?></div><?php endif; ?>
</div>
<div class="card">
<?php while($row = $result->fetch_assoc()): ?>
<form method="post" style="margin-bottom: 15px;">
    <input type="hidden" name="record_id" value="<?php echo $row['record_id']; ?>">
    <label>類別</label>
    <select name="category">
        <option <?php if($row['category']=='收入') echo 'selected'; ?>>收入</option>
        <option <?php if($row['category']=='支出') echo 'selected'; ?>>支出</option>
    </select>
    <label>金額</label>
    <input name="amount" type="number" value="<?php echo $row['amount']; ?>" step="0.01" required>
    <label>說明</label>
    <input name="description" type="text" value="<?php echo $row['description']; ?>">
    <label>日期</label>
    <input name="date" type="date" value="<?php echo $row['date']; ?>" required>
    <button name="update" value="1">更新</button>
    <button name="delete" value="1" onclick="return confirm('確認刪除這筆紀錄？')">刪除</button>
</form>
<?php endwhile; ?>
</div>
</div>
<button class="fab fab-left" onclick="location.href='index.php'">←</button>
</body>
</html>