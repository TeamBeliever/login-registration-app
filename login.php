<?php
include "db.php";
session_start();

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE username=?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if ($row && password_verify($password, $row['password'])) {
        $_SESSION['id'] = $row['id'];  // session set
        header("Location: dashboard.php");
        exit();
    } else {
        echo "<script>alert('Invalid username or password');</script>";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Login</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
<div class="card p-4 shadow-lg">
<h3 class="text-center">Login</h3>
<form method="post">
    <div class="mb-3">
        <label class="form-label">Username</label>
        <input class="form-control" name="username" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Password</label>
        <input class="form-control" type="password" name="password" id="password" required>
        <div class="form-check mt-2">
            <input class="form-check-input" type="checkbox" id="showPassword">
            <label class="form-check-label" for="showPassword">Show Password</label>
        </div>
    </div>
    <button class="btn btn-primary w-100" name="login">Login</button>
</form>
<p class="mt-3 text-center"><a href="register.php">New user? Register</a></p>
</div>
</div>

<script>
document.getElementById('showPassword').addEventListener('change', function() {
    let passField = document.getElementById('password');
    if (this.checked) {
        passField.type = 'text';
    } else {
        passField.type = 'password';
    }
});
</script>
</body>
</html>





