<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>

<h1>Login</h1>

<?php if (session()->getFlashdata('error')): ?>
    <p style="color: red;"><?php echo session()->getFlashdata('error'); ?></p>
<?php endif; ?>

<form method="POST" action="<?php echo getenv('APP_URL') . '/login'; ?>">
    <input type="text" name="username" placeholder="Username" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit">Login</button>
</form>
</body>
</html>