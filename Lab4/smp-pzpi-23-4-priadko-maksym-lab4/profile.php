<?php
include 'session.php';
require_login();

$userId = $_SESSION['user'];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstName = trim($_POST['first_name']);
    $lastName = trim($_POST['last_name']);
    $birthdate = trim($_POST['birthdate']);
    $description = trim($_POST['description']);
    if (!empty($_FILES['avatar']['name'])) {
        $uploadDir = 'avatars/';
        if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

        $ext = pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION);
        $filename = 'avatar_' . $userId . '.' . $ext;
        $filepath = $uploadDir . $filename;

        if (move_uploaded_file($_FILES['avatar']['tmp_name'], $filepath)) {
            $stmt = $pdo->prepare("UPDATE users SET avatar = ? WHERE id = ?");
            $stmt->execute([$filepath, $userId]);
        }
    }
    $stmt = $pdo->prepare("UPDATE users SET first_name = ?, last_name = ?, birthdate = ?, description = ? WHERE id = ?");
    $stmt->execute([$firstName, $lastName, $birthdate, $description, $userId]);

    $success = "Профіль оновлено!";
}
$stmt = $pdo->prepare("SELECT username, first_name, last_name, birthdate, description, avatar FROM users WHERE id = ?");
$stmt->execute([$userId]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="uk">
<head>
  <meta charset="UTF-8">
  <title>Профіль</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
</head>
<body>
<?php include 'header.php'; ?>

<main class="container my-5">
  <h2 class="mb-4 text-center"><i class="bi bi-person-circle me-2 text-primary"></i>Профіль користувача</h2>

  <?php if (!empty($success)): ?>
    <div class="alert alert-success"><?= $success ?></div>
  <?php endif; ?>

  <div class="mb-4 text-end">
    <a href="logout.php" class="btn btn-danger">
      <i class="bi bi-box-arrow-right"></i> Вийти
    </a>
  </div>

  <form method="post" enctype="multipart/form-data" class="row g-4">
    <div class="col-md-4 text-center">
      <img src="<?= htmlspecialchars($user['avatar'] ?? 'https://via.placeholder.com/150') ?>" class="rounded-circle shadow-sm mb-3" width="150" height="150" alt="Avatar">
      <input type="file" name="avatar" class="form-control mt-2">
    </div>

    <div class="col-md-8">
      <div class="mb-3">
        <label class="form-label">Ім’я користувача</label>
        <input type="text" class="form-control" value="<?= htmlspecialchars($user['username']) ?>" disabled>
      </div>
      <div class="mb-3">
        <label class="form-label">Ім’я</label>
        <input type="text" name="first_name" class="form-control" value="<?= htmlspecialchars($user['first_name']) ?>">
      </div>
      <div class="mb-3">
        <label class="form-label">Прізвище</label>
        <input type="text" name="last_name" class="form-control" value="<?= htmlspecialchars($user['last_name']) ?>">
      </div>
      <div class="mb-3">
        <label class="form-label">Дата народження</label>
        <input type="date" name="birthdate" class="form-control" value="<?= htmlspecialchars($user['birthdate']) ?>">
      </div>
      <div class="mb-3">
        <label class="form-label">Опис</label>
        <textarea name="description" class="form-control" rows="3"><?= htmlspecialchars($user['description']) ?></textarea>
      </div>
      <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Зберегти зміни</button>
    </div>
  </form>
</main>

<?php include 'footer.php'; ?>
</body>
</html>
