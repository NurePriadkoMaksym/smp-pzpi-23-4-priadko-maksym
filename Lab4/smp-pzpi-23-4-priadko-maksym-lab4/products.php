<?php
include 'session.php';
require_login();
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart'])) {
    foreach ($_POST['qty'] as $id => $qty) {
        $qty = (int)$qty;
        if (isset($products[$id]) && $qty > 0) {
            $currentQty = $cart[$id] ?? 0;
            $newQty = $currentQty + $qty;
            if ($newQty > 100) {
                $cart[$id] = 100;
            } else {
                $cart[$id] = $newQty;
            }
        }
    }

    $_SESSION['cart'] = $cart;

    header("Location: cart.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="uk">
<head>
  <meta charset="UTF-8">
  <title>Каталог — Весна</title>
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
    .form-control[type=number] {
      width: 80px;
      margin: auto;
      text-align: center;
    }
  </style>
</head>
<body>
<?php include 'header.php'; ?>
<main class="container my-5">
  <h2 class="text-center mb-4"><i class="bi bi-basket-fill text-primary me-2"></i>Доступні товари</h2>

  <form method="post">
    <div class="table-responsive">
      <table class="table table-hover align-middle text-center shadow-sm">
        <thead class="table-light">
          <tr>
            <th>ID</th>
            <th>Назва</th>
            <th>Ціна</th>
            <th>Кількість</th>
          </tr>
        </thead>
        <tbody>
        <?php foreach ($products as $id => $p): ?>
          <tr>
            <td><?= $id ?></td>
            <td><?= htmlspecialchars($p['name']) ?></td>
            <td><?= $p['price'] ?> грн</td>
            <td>
              <input type="number" name="qty[<?= $id ?>]" value="0" min="0"  class="form-control" />
            </td>
          </tr>
        <?php endforeach; ?>
        </tbody>
      </table>
    </div>

    <div class="text-center mt-4">
      <button type="submit" name="add_to_cart" class="btn btn-success btn-lg">
        <i class="bi bi-cart-plus"></i> Додати до кошика
      </button>
    </div>
  </form>
</main>
<?php include 'footer.php'; ?>
</body>
</html>
