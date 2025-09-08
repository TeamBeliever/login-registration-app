<?php
include "db.php";
session_start();

// agar login nahi hai to redirect
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

// delete
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM users WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    header("Location: dashboard.php");
    exit();
}

// update
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $mobile = $_POST['mobile'];
    $email = $_POST['email'];
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];
    $username = $_POST['username'];
    $password = !empty($_POST['password']) ? password_hash($_POST['password'], PASSWORD_BCRYPT) : $_POST['old_password'];

    // profile pic
    if (!empty($_FILES['profile_pic']['name'])) {
        $profile_pic = "uploads/" . time() . "_" . $_FILES['profile_pic']['name'];
        move_uploaded_file($_FILES['profile_pic']['tmp_name'], $profile_pic);
    } else {
        $profile_pic = $_POST['old_profile'];
    }

    // id card
    if (!empty($_FILES['id_card']['name'])) {
        $id_card = "uploads/" . time() . "_" . $_FILES['id_card']['name'];
        move_uploaded_file($_FILES['id_card']['tmp_name'], $id_card);
    } else {
        $id_card = $_POST['old_id_card'];
    }

    $stmt = $conn->prepare("UPDATE users SET name=?, mobile=?, email=?, dob=?, gender=?, username=?, password=?, id_card=?, profile_pic=? WHERE id=?");
    $stmt->bind_param("sssssssssi", $name, $mobile, $email, $dob, $gender, $username, $password, $id_card, $profile_pic, $id);
    $stmt->execute();
    header("Location: dashboard.php");
    exit();
}

$result = $conn->query("SELECT * FROM users");
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

<!-- logout -->
<div class="d-flex justify-content-between align-items-center mb-3">
    <h3>Users Dashboard</h3>
    <a href="logout.php" class="btn btn-danger">Logout</a>
</div>

<table class="table table-bordered text-center align-middle">
<tr class="table-primary">
    <th>ID</th><th>Name</th><th>Mobile</th><th>Email</th><th>DOB</th><th>Gender</th>
    <th>Username</th><th>Password</th><th>ID Card</th><th>Profile Pic</th><th>Actions</th>
</tr>

<?php while ($row = $result->fetch_assoc()) { ?>
<tr>
    <td><?= $row['id']; ?></td>
    <td><?= $row['name']; ?></td>
    <td><?= $row['mobile']; ?></td>
    <td><?= $row['email']; ?></td>
    <td><?= $row['dob']; ?></td>
    <td><?= $row['gender']; ?></td>
    <td><?= $row['username']; ?></td>
    <td>********</td>
    <td><img src="<?= $row['id_card']; ?>" width="70" height="70"></td>
    <td><img src="<?= $row['profile_pic']; ?>" width="70" height="70"></td>
    <td>
        <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#edit<?= $row['id']; ?>">Edit</button>
        <a href="dashboard.php?delete=<?= $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Delete this record?')">Delete</a>
    </td>
</tr>

<!-- edit modal -->
<div class="modal fade" id="edit<?= $row['id']; ?>" tabindex="-1">
<div class="modal-dialog">
<div class="modal-content">
<form method="post" enctype="multipart/form-data">
<div class="modal-header">
    <h5 class="modal-title">Edit User</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
</div>
<div class="modal-body">
    <input type="hidden" name="id" value="<?= $row['id']; ?>">
    <input type="hidden" name="old_profile" value="<?= $row['profile_pic']; ?>">
    <input type="hidden" name="old_id_card" value="<?= $row['id_card']; ?>">
    <input type="hidden" name="old_password" value="<?= $row['password']; ?>">

    <div class="mb-2"><label>Name</label><input class="form-control" name="name" value="<?= $row['name']; ?>" required></div>
    <div class="mb-2"><label>Mobile</label><input class="form-control" name="mobile" pattern="\d{10}" maxlength="10" value="<?= $row['mobile']; ?>" required></div>
    <div class="mb-2"><label>Email</label><input class="form-control" name="email" value="<?= $row['email']; ?>" required></div>
    <div class="mb-2"><label>DOB</label><input class="form-control" name="dob" type="date" value="<?= $row['dob']; ?>" required></div>
    <div class="mb-2"><label>Gender</label>
        <select class="form-control" name="gender" required>
            <option <?= $row['gender']=='Male'?'selected':''; ?>>Male</option>
            <option <?= $row['gender']=='Female'?'selected':''; ?>>Female</option>
            <option <?= $row['gender']=='Other'?'selected':''; ?>>Other</option>
        </select>
    </div>
    <div class="mb-2"><label>Username</label><input class="form-control" name="username" value="<?= $row['username']; ?>" required></div>
    <div class="mb-2"><label>Change Password</label><input class="form-control" name="password" type="password" placeholder="New password (optional)"></div>
    <div class="mb-2"><label>ID Card</label><input class="form-control" type="file" name="id_card"></div>
    <div class="mb-2"><label>Profile Pic</label><input class="form-control" type="file" name="profile_pic"></div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
    <button type="submit" name="update" class="btn btn-success">Update</button>
</div>
</form>
</div>
</div>
</div>

<?php } ?>
</table>
</div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>



