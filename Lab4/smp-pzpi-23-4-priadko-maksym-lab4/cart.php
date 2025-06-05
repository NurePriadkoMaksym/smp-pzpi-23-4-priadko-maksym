<?php
include 'session.php';
require_login();
$showThankYou = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['remove'])) {
        $id = (int)$_POST['remove'];
        unset($cart[$id]);
        $_SESSION['cart'] = $cart;
        header("Location: cart.php");
        exit;
    }

    if (isset($_POST['purchase'])) {
        $cart = [];
        $_SESSION['cart'] = [];
        $showThankYou = true;
    }

    if (isset($_POST['cancel'])) {
        $cart = [];
        $_SESSION['cart'] = [];
    }
}
?>
<!DOCTYPE html>
<html lang="uk">
<head>
  <meta charset="UTF-8">
  <title>Кошик — Весна</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
  <style>
    html, body {
      height: 100%;
      margin: 0;
    }
    body {
      display: flex;
      flex-direction: column;
    }
    main {
      flex: 1;
    }
  </style>
</head>
<body>
<?php include 'header.php'; ?>
<main class="container my-5">
  <div class="text-center">
    <h2 class="mb-4"><i class="bi bi-cart-check-fill me-2 text-primary"></i>Ваш кошик</h2>
  </div>

  <?php if ($showThankYou): ?>
    <div class="alert alert-success text-center p-5 rounded shadow-sm">
      <h3 class="mb-3"><i class="bi bi-check2-circle me-2"></i>Дякуємо за покупку!</h3>
      <a href="products.php" class="btn btn-primary btn-lg mt-3">Продовжити покупки</a>
    </div>

  <?php elseif (empty($cart)): ?>
    <div class="text-center p-5">
      <h4 class="text-muted mb-3">Ваш кошик порожній</h4>
      <a href="products.php" class="btn btn-outline-primary btn-lg"><i class="bi bi-bag-plus"></i> Перейти до покупок</a>
    </div>

  <?php else: ?>
    <form method="post">
      <div class="table-responsive">
        <table class="table table-hover align-middle text-center shadow-sm">
          <thead class="table-light">
            <tr>
              <th>ID</th>
              <th>Назва</th>
              <th>Ціна</th>
              <th>Кількість</th>
              <th>Сума</th>
              <th>Дія</th>
            </tr>
          </thead>
          <tbody>
          <?php $total = 0; foreach ($cart as $id => $qty):
              $product = $products[$id];
              $sum = $qty * $product['price'];
              $total += $sum;
          ?>
          <tr>
            <td><?= $id ?></td>
            <td><?= htmlspecialchars($product['name']) ?></td>
            <td><?= $product['price'] ?> грн</td>
            <td><?= $qty ?></td>
            <td><?= $sum ?> грн</td>
            <td>
              <button name="remove" value="<?= $id ?>" class="btn btn-sm btn-outline-danger" title="Видалити">
                <i class="bi bi-x-lg"></i>
              </button>
            </td>
          </tr>
          <?php endforeach; ?>
          <tr class="fw-bold table-secondary">
            <td colspan="4" class="text-end">Всього:</td>
            <td><?= $total ?> грн</td>
            <td></td>
          </tr>
          </tbody>
        </table>
      </div>

      <div class="text-center mt-4">
        <button name="purchase" class="btn btn-success btn-lg me-3">
          <i class="bi bi-credit-card"></i> Сплатити
        </button>
        <button name="cancel" class="btn btn-outline-warning btn-lg">
          <i class="bi bi-trash3"></i> Очистити кошик
        </button>
      </div>
    </form>
  <?php endif; ?>
</main>
<?php include 'footer.php'; ?>
</body>
</html>
