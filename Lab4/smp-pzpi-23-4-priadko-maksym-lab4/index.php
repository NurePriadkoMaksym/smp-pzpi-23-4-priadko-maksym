<?php include 'session.php'; ?>
<!DOCTYPE html>
<html lang="uk">
<head>
  <meta charset="UTF-8">
  <title>Продовольчий магазин "Весна"</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css" rel="stylesheet">
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
      display: flex;
      align-items: center;
      justify-content: center;
      text-align: center;
      padding: 3rem 1rem;
    }
  </style>
</head>
<body>
<?php include 'header.php'; ?>
<main class="bg-light">
  <div>
    <h1 class="display-4 fw-bold mb-4">
      <i class="bi bi-shop-window text-success me-2"></i>
      Продовольчий магазин <span class="text-success">«Весна»</span>
    </h1>
    <p class="lead mb-5">Ласкаво просимо! Тут ви знайдете найсвіжіші продукти за приємними цінами.</p>
    
    <div class="d-flex justify-content-center gap-3">
      <a href="login.php" class="btn btn-outline-primary btn-lg">
        <i class="bi bi-box-arrow-in-right me-2"></i>Увійти
      </a>
      <a href="register.php" class="btn btn-primary btn-lg">
        <i class="bi bi-person-plus-fill me-2"></i>Зареєструватися
      </a>
    </div>
  </div>
</main>
<?php include 'footer.php'; ?>
</body>
</html>
