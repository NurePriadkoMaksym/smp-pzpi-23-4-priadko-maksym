<?php
include 'session.php';

$error = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST["username"]);
    $password = $_POST["password"];

    $stmt = $pdo->prepare("SELECT id, password FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user["password"])) {
        $_SESSION["user"] = $user["id"];
        header("Location: index.php");
        exit;
    } else {
        $error = "Невірне ім’я користувача або пароль!";
    }
}
?>
<!DOCTYPE html>
<html lang="uk">
<head>
  <meta charset="UTF-8">
  <title>Вхід</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
</head>
<body>
<?php include 'header.php'; ?>
<main class="container my-5">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <h2 class="text-center mb-4"><i class="bi bi-box-arrow-in-right me-2"></i>Вхід</h2>
      <?php if (!empty($error)): ?>
        <div class="alert alert-danger text-center"><?= $error ?></div>
      <?php endif; ?>
      <form method="post" class="card shadow-sm p-4">
        <div class="mb-3">
          <label for="username" class="form-label">Логін</label>
          <input type="text" class="form-control" name="username" required>
        </div>
        <div class="mb-3">
          <label for="password" class="form-label">Пароль</label>
          <input type="password" class="form-control" name="password" required>
        </div>
        <button type="submit" class="btn btn-primary w-100">Увійти</button>
        <p class="mt-3 text-center">Немає облікового запису? <a href="register.php">Зареєструйтесь</a></p>
      </form>
    </div>
  </div>
</main>
<?php include 'footer.php'; ?>
</body>
</html>
