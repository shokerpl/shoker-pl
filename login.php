<?php
require_once __DIR__ . '/includes/auth.php';
if (!headers_sent()) {
    header('Content-Type: text/html; charset=UTF-8');
}

if (current_user()) {
    redirect_to('dashboard/index.php');
}

$error = '';
$identifier = 'admin@example.com';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $identifier = trim((string)($_POST['identifier'] ?? ''));
    $password = (string)($_POST['password'] ?? '');

    $user = find_user_by_identifier($identifier);
    if ($user && verify_user_password($user, $password)) {
        login_user($user);
        redirect_to('dashboard/index.php');
    }
    $error = 'Nieprawidlowe dane logowania.';
}
?>
<!doctype html>
<html lang="pl">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Logowanie</title>
  <link rel="stylesheet" href="<?= h(app_url('assets/style.css')) ?>">
</head>
<body>
<div class="login">
  <form method="post" class="login-card">
    <h2>Panel admina (PHP)</h2>
    <p style="margin:0;color:#9fb0cc;">Zaloguj sie, aby edytowac pliki JSON.</p>

    <label>Email lub login</label>
    <input class="input" type="text" name="identifier" value="<?= h($identifier) ?>" required>

    <label>Haslo</label>
    <input class="input" type="password" name="password" required>

    <?php if ($error !== ''): ?><div class="err"><?= h($error) ?></div><?php endif; ?>

    <button class="btn primary" type="submit">Zaloguj</button>
    <a class="btn" href="<?= h(app_url('index.php')) ?>">Wroc na strone</a>
  </form>
</div>
</body>
</html>



