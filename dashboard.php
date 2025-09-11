<?php
include "db.php";
session_start();

// Session check for user
if(isset($_SESSION['user_id'])){
    $uid = $_SESSION['user_id'];
} else {
    header("Location: login.php");
    exit;
}

// Fetch user data
$row = $conn->query("SELECT * FROM users WHERE id=$uid")->fetch_assoc();

// Status check alert
if($row['status']=="pending"){
    echo "<script>alert('Your account is still pending approval by admin');</script>";
} elseif($row['status']=="rejected"){
    // agar reason diya hai to dikhayenge, warna default reason dikhayenge
    $reason = !empty($row['reject_reason']) ? $row['reject_reason'] : 'Documents not clear, please upload again';
    echo "<script>alert('Your account has been rejected by admin. Reason: $reason');</script>";
} elseif($row['status']=="approved"){
    echo "<script>alert('Your account is approved');</script>";
}

// Update user data
if(isset($_POST['update'])){
    $name = $_POST['name'];
    $mobile = $_POST['mobile'];
    $email = $_POST['email'];
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];
    $username = $_POST['username'];

    // Password update
    if(!empty($_POST['password'])){
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
        $conn->query("UPDATE users SET password='$password' WHERE id=$uid");
    }

    // ID Card upload
    if(isset($_FILES['id_card']) && $_FILES['id_card']['tmp_name'] != ""){
        $id_card_name = time()."_".$_FILES['id_card']['name'];
        $id_card_path = "uploads/".$id_card_name;
        move_uploaded_file($_FILES['id_card']['tmp_name'], $id_card_path);
        $conn->query("UPDATE users SET id_card='$id_card_path' WHERE id=$uid");
        $row['id_card'] = $id_card_path;
    }

    // Profile pic upload
    if(isset($_FILES['profile_pic']) && $_FILES['profile_pic']['tmp_name'] != ""){
        $profile_name = time()."_".$_FILES['profile_pic']['name'];
        $profile_path = "uploads/".$profile_name;
        move_uploaded_file($_FILES['profile_pic']['tmp_name'], $profile_path);
        $conn->query("UPDATE users SET profile_pic='$profile_path' WHERE id=$uid");
        $row['profile_pic'] = $profile_path;
    }

    // Update other fields
    $stmt = $conn->prepare("UPDATE users SET name=?, mobile=?, email=?, dob=?, gender=?, username=? WHERE id=?");
    $stmt->bind_param("ssssssi",$name,$mobile,$email,$dob,$gender,$username,$uid);
    $stmt->execute();

    echo "<script>alert('Updated Successfully');window.location='dashboard.php';</script>";
}

// Delete account
if(isset($_POST['delete'])){
    $conn->query("DELETE FROM users WHERE id=$uid");
    session_destroy();
    echo "<script>alert('Account Deleted Successfully');window.location='register.php';</script>";
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Dashboard</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
<div class="card p-4 shadow-lg">
<h3 class="text-center mb-4">Dashboard</h3>

<form method="post" enctype="multipart/form-data">
    <div class="mb-3">
        <label class="form-label">Full Name</label>
        <input class="form-control" name="name" value="<?= $row['name'] ?>" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Mobile Number</label>
        <input class="form-control" name="mobile" value="<?= $row['mobile'] ?>" pattern="[0-9]{10}" maxlength="10" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Email</label>
        <input class="form-control" name="email" type="email" value="<?= $row['email'] ?>" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Date of Birth</label>
        <input class="form-control" name="dob" type="date" value="<?= $row['dob'] ?>" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Gender</label>
        <select class="form-control" name="gender" required>
            <option value="Male" <?= $row['gender']=="Male"?"selected":"" ?>>Male</option>
            <option value="Female" <?= $row['gender']=="Female"?"selected":"" ?>>Female</option>
            <option value="Other" <?= $row['gender']=="Other"?"selected":"" ?>>Other</option>
        </select>
    </div>

    <div class="mb-3">
        <label class="form-label">Username</label>
        <input class="form-control" name="username" value="<?= $row['username'] ?>" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Password (Change)</label>
        <input class="form-control" name="password" type="password" placeholder="Enter new password">
    </div>

    <!-- ID Card -->
    <div class="mb-3">
        <label class="form-label">Upload ID Card</label>
        <input class="form-control" name="id_card" type="file" accept="image/*">
        <br>
        <?php if(!empty($row['id_card'])): ?>
            <img src="<?= $row['id_card'] ?>" width="100" class="rounded">
        <?php endif; ?>
    </div>

    <!-- Profile Picture -->
    <div class="mb-3">
        <label class="form-label">Upload Profile Picture</label>
        <input class="form-control" name="profile_pic" type="file" accept="image/*">
        <br>
        <?php if(!empty($row['profile_pic'])): ?>
            <img src="<?= $row['profile_pic'] ?>" width="100" class="rounded">
        <?php endif; ?>
    </div>

    <button class="btn btn-primary w-100" name="update">Update</button>
    <button class="btn btn-danger w-100 mt-2" name="delete" onclick="return confirm('Are you sure you want to delete your account?');">Delete Account</button>
    <a href="logout.php" class="btn btn-secondary w-100 mt-2">Logout</a>
</form>
</div>
</div>
</body>
</html>
