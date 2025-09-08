<?php
include "db.php";
session_start();

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // sirf admin role wale users login karenge
    $stmt = $conn->prepare("SELECT * FROM users WHERE username=? AND role='admin'");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if ($row && password_verify($password, $row['password'])) {
        $_SESSION['admin_id'] = $row['id'];  
        $_SESSION['admin_name'] = $row['name'];  
        header("Location: admin_dashboard.php");
        exit();
    } else {
        echo "<script>alert('Invalid Admin username or password');</script>";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Admin Login</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
<div class="card p-4 shadow-lg">
<h3 class="text-center mb-3">Admin Login</h3>
<form method="post">
    <div class="mb-3">
        <label class="form-label">Username</label>
        <input class="form-control" name="username" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Password</label>
        <input class="form-control" type="password" name="password" id="password" required>
        <input type="checkbox" onclick="togglePass()"> Show Password
    </div>
    <button class="btn btn-dark w-100" name="login">Login as Admin</button>
</form>
<p class="mt-3 text-center"><a href="login.php">Back to User Login</a></p>
</div>
</div>

<script>
function togglePass(){
    var x = document.getElementById("password");
    if (x.type === "password") {
        x.type = "text";
    } else {
        x.type = "password";
    }
}
</script>
</body>
</html>
