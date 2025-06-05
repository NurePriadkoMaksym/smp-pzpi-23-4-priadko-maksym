<?php
include 'session.php';

$error = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST["username"]);
    $password = $_POST["password"];
    $confirm = $_POST["confirm"];

    if ($password !== $confirm) {
        $error = "Паролі не збігаються!";
    } elseif (empty($username) || empty($password)) {
        $error = "Заповніть усі поля!";
    } else {
        $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ?");
        $stmt->execute([$username]);
        if ($stmt->fetch()) {
            $error = "Користувач із таким ім'ям уже існує!";
        } else {
            $hashed = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
            $stmt->execute([$username, $hashed]);

            $_SESSION['user'] = $pdo->lastInsertId();
            header("Location: index.php");
            exit;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="uk">
<head>
  <meta charset="UTF-8">
  <title>Реєстрація</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
</head>
<body>
<?php include 'header.php'; ?>
<main class="container my-5">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <h2 class="text-center mb-4"><i class="bi bi-person-plus-fill me-2"></i>Реєстрація</h2>
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
        <div class="mb-3">
          <label for="confirm" class="form-label">Підтвердження пароля</label>
          <input type="password" class="form-control" name="confirm" required>
        </div>
        <button type="submit" class="btn btn-success w-100">Зареєструватись</button>
        <p class="mt-3 text-center">Вже маєте акаунт? <a href="login.php">Увійдіть</a></p>
      </form>
    </div>
  </div>
</main>
<?php include 'footer.php'; ?>
</body>
</html>
