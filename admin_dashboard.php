<?php
include "db.php";
session_start();

if(!isset($_SESSION['admin_id'])){
    header("Location: login.php");
    exit();
}

// Approve / Reject action
if(isset($_GET['action']) && isset($_GET['uid'])){
    $uid = intval($_GET['uid']);
    $action = $_GET['action'];

    if($action === 'approve'){
        $conn->query("UPDATE users SET status='Approved' WHERE id=$uid");
    } elseif($action === 'reject'){
        $conn->query("UPDATE users SET status='Rejected' WHERE id=$uid");
    }
}

// Fetch all normal users (admin not included)
$result = $conn->query("SELECT * FROM users WHERE username!='mad' ORDER BY id ASC");
?>
<!DOCTYPE html>
<html>
<head>
<title>Admin Dashboard</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
<div class="d-flex justify-content-between mb-3">
    <h3>Welcome Admin: <?= $_SESSION['admin_name'] ?></h3>
    <a href="logout.php" class="btn btn-danger">Logout</a>
</div>

<div class="card p-3 shadow-lg">
<h4>All Registered Users</h4>
<table class="table table-bordered table-striped mt-3">
<tr>
<th>ID</th><th>Name</th><th>Mobile</th><th>Email</th><th>DOB</th>
<th>Gender</th><th>Username</th><th>ID Card</th><th>Profile Pic</th><th>Status</th><th>Action</th>
</tr>
<?php while($row = $result->fetch_assoc()){ ?>
<tr>
<td><?= $row['id'] ?></td>
<td><?= $row['name'] ?></td>
<td><?= $row['mobile'] ?></td>
<td><?= $row['email'] ?></td>
<td><?= $row['dob'] ?></td>
<td><?= $row['gender'] ?></td>
<td><?= $row['username'] ?></td>
<td><img src="<?= $row['id_card'] ?>" width="60"></td>
<td><img src="<?= $row['profile_pic'] ?>" width="60"></td>
<td><?= $row['status'] ?></td>
<td>
<?php if($row['status'] === 'Pending'){ ?>
    <a href="admin_dashboard.php?action=approve&uid=<?= $row['id'] ?>" class="btn btn-success btn-sm">Approve</a>
    <a href="admin_dashboard.php?action=reject&uid=<?= $row['id'] ?>" class="btn btn-danger btn-sm">Reject</a>
<?php } else { echo '-'; } ?>
</td>
</tr>
<?php } ?>
</table>
</div>
</div>
</body>
</html>
