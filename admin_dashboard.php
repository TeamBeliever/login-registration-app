<?php
include "db.php";
session_start();

if(!isset($_SESSION['admin_id'])){
    header("Location: login.php");
    exit();
}

// Approve action
if(isset($_GET['action']) && $_GET['action']=='approve' && isset($_GET['uid'])){
    $uid = intval($_GET['uid']);
    $conn->query("UPDATE users SET status='Approved' WHERE id=$uid");
    header("Location: admin_dashboard.php");
    exit();
}

// Reject action with reason
if(isset($_GET['action']) && $_GET['action']=='reject' && isset($_GET['uid']) && isset($_POST['reject_reason'])){
    $uid = intval($_GET['uid']);
    $reason = $conn->real_escape_string($_POST['reject_reason']);
    $conn->query("UPDATE users SET status='Rejected', Reject_Reason='$reason' WHERE id=$uid");
    header("Location: admin_dashboard.php");
    exit();
}

// Update user inline (admin)
if(isset($_POST['update_user']) && isset($_POST['uid'])){
    $uid = intval($_POST['uid']);
    $name = $_POST['name'];
    $mobile = $_POST['mobile'];
    $email = $_POST['email'];
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];
    $username = $_POST['username'];

    if(!empty($_POST['password'])){
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
        $conn->query("UPDATE users SET password='$password' WHERE id=$uid");
    }

    // ID Card upload
    if(isset($_FILES['id_card']) && $_FILES['id_card']['tmp_name'] != ""){
        $id_card_path = "uploads/".time()."_".$_FILES['id_card']['name'];
        move_uploaded_file($_FILES['id_card']['tmp_name'], $id_card_path);
        $conn->query("UPDATE users SET id_card='$id_card_path' WHERE id=$uid");
    }

    // Profile pic upload
    if(isset($_FILES['profile_pic']) && $_FILES['profile_pic']['tmp_name'] != ""){
        $profile_path = "uploads/".time()."_".$_FILES['profile_pic']['name'];
        move_uploaded_file($_FILES['profile_pic']['tmp_name'], $profile_path);
        $conn->query("UPDATE users SET profile_pic='$profile_path' WHERE id=$uid");
    }

    // Update other fields
    $stmt = $conn->prepare("UPDATE users SET name=?, mobile=?, email=?, dob=?, gender=?, username=? WHERE id=?");
    $stmt->bind_param("ssssssi",$name,$mobile,$email,$dob,$gender,$username,$uid);
    $stmt->execute();
    header("Location: admin_dashboard.php");
    exit();
}

// Delete user
if(isset($_GET['action']) && $_GET['action']=='delete' && isset($_GET['uid'])){
    $uid = intval($_GET['uid']);
    $conn->query("DELETE FROM users WHERE id=$uid");
    header("Location: admin_dashboard.php");
    exit();
}

?>
<!DOCTYPE html>
<html>
<head>
<title>Admin Dashboard</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
input[type=text], input[type=email], input[type=date], input[type=password], select{
    width: 120px;
    height: 30px;
    font-size: 12px;
    padding: 2px 5px;
}
input[type=file]{width: 120px;}
img{max-width: 40px; max-height: 40px; display:block;}
form.inline-form{display: flex; flex-wrap: wrap; align-items: center; gap: 5px;}
form.inline-form input, form.inline-form select, form.inline-form button{margin: 0; padding: 2px 5px; font-size: 12px;}
</style>
</head>
<body class="bg-light">
<div class="container mt-3">
<div class="d-flex justify-content-between mb-3">
    <h4>Welcome Admin: <?= $_SESSION['admin_name'] ?></h4>
    <a href="logout.php" class="btn btn-danger btn-sm">Logout</a>
</div>

<h5>All Registered Users</h5>
<table class="table table-bordered table-striped">
<tr>
<th>ID</th><th>Name</th><th>Mobile</th><th>Email</th><th>DOB</th>
<th>Gender</th><th>Username</th><th>Password</th><th>ID Card</th><th>Profile Pic</th><th>Status</th><th>Reject Reason</th><th>Action</th>
</tr>
<?php
$result = $conn->query("SELECT * FROM users WHERE username!='mad' ORDER BY id ASC");
while($row = $result->fetch_assoc()){ ?>
<tr>
<td><?= $row['id'] ?></td>
<td>
<form class="inline-form" method="post" enctype="multipart/form-data">
<input type="hidden" name="uid" value="<?= $row['id'] ?>">
<input type="text" name="name" value="<?= $row['name'] ?>">
</td>
<td><input type="text" name="mobile" value="<?= $row['mobile'] ?>"></td>
<td><input type="email" name="email" value="<?= $row['email'] ?>"></td>
<td><input type="date" name="dob" value="<?= $row['dob'] ?>"></td>
<td>
<select name="gender">
<option value="Male" <?= $row['gender']=='Male'?'selected':'' ?>>M</option>
<option value="Female" <?= $row['gender']=='Female'?'selected':'' ?>>F</option>
<option value="Other" <?= $row['gender']=='Other'?'selected':'' ?>>O</option>
</select>
</td>
<td><input type="text" name="username" value="<?= $row['username'] ?>"></td>
<td>
<input type="password" name="password" id="pass<?= $row['id'] ?>" placeholder="Change">
<input type="checkbox" onclick="togglePass('pass<?= $row['id'] ?>')"> Show
</td>
<td><input type="file" name="id_card">
<?php if(!empty($row['id_card'])): ?><img src="<?= $row['id_card'] ?>"><?php endif; ?></td>
<td><input type="file" name="profile_pic">
<?php if(!empty($row['profile_pic'])): ?><img src="<?= $row['profile_pic'] ?>"><?php endif; ?></td>
<td><?= $row['status'] ?></td>
<td>
<input type="text" name="reject_reason" value="<?= $row['Reject_Reason'] ?>" placeholder="Enter reason">
</td>
<td>
<button type="submit" name="update_user" class="btn btn-primary btn-sm">Update</button>
<?php if($row['status']=='Pending'){ ?>
<a href="admin_dashboard.php?action=approve&uid=<?= $row['id'] ?>" class="btn btn-success btn-sm">Approve</a>
<button type="button" onclick="rejectUser(<?= $row['id'] ?>)" class="btn btn-danger btn-sm">Reject</button>
<?php } ?>
<a href="admin_dashboard.php?action=delete&uid=<?= $row['id'] ?>" class="btn btn-warning btn-sm" onclick="return confirm('Are you sure you want to delete this user?');">Delete</a>
</form>
</td>
</tr>
<?php } ?>
</table>
</div>
<script>
function togglePass(id){
    var x = document.getElementById(id);
    if(x.type==="password"){x.type="text";}else{x.type="password";}
}

function rejectUser(uid){
    var reason = prompt("Enter rejection reason for this user:");
    if(reason !== null && reason.trim() !== ""){
        var form = document.createElement("form");
        form.method = "post";
        form.action = "admin_dashboard.php?action=reject&uid="+uid;
        var input = document.createElement("input");
        input.type = "hidden";
        input.name = "reject_reason";
        input.value = reason;
        form.appendChild(input);
        document.body.appendChild(form);
        form.submit();
    } else {
        alert("Rejection reason is required!");
    }
}
</script>
</body>
</html>
