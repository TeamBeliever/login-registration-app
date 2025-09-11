<?php
include "db.php";
session_start();

if(isset($_POST['login'])){
    $username = $_POST['username'];
    $password = $_POST['password'];

    // prepared statement safe select
    $stmt = $conn->prepare("SELECT * FROM users WHERE username=? LIMIT 1");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $stmt->close();

    if($user && password_verify($password, $user['password'])){
        // normalized status
        $status = isset($user['status']) ? strtolower($user['status']) : 'pending';

        if($status === 'rejected'){
            // agar DB me reason hai use lo, nahi to default reason (maine diya)
            $reason = !empty($user['reject_reason']) ? $user['reject_reason'] : 'Documents not clear - please re-upload clear ID and profile picture.';
            $js_reason = addslashes($reason);
            echo "<script>alert('Login rejected: {$js_reason}');window.location='login.php';</script>";
            exit;
        }

        if($status === 'pending'){
            echo "<script>alert('Login pending: Your account is waiting admin approval');window.location='login.php';</script>";
            exit;
        }

        // approved ya admin login
        if(isset($user['role']) && $user['role'] === 'admin'){
            $_SESSION['admin_id'] = $user['id'];
            $_SESSION['admin_name'] = $user['name'];
            header("Location: admin_dashboard.php");
            exit;
        } else {
            // normal approved user
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            header("Location: dashboard.php");
            exit;
        }
    } else {
        echo "<script>alert('Invalid username or password');window.location='login.php';</script>";
        exit;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<title>User Login</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
<div class="card p-4 shadow-lg">
<h3 class="text-center mb-3">User Login</h3>
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
    <button class="btn btn-primary w-100" name="login">Login</button>
</form>
<p class="mt-3 text-center"><a href="register.php">New User? Register</a></p>
<script>
function togglePass(){
    var x = document.getElementById("password");
    if(x.type==="password"){x.type="text";}else{x.type="password";}
}
</script>
</div>
</div>
</body>
</html>
