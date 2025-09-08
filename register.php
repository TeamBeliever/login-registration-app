<?php include "db.php"; ?>
<?php
if(isset($_POST['register'])){
    $name = $_POST['name'];
    $mobile = $_POST['mobile'];
    $email = $_POST['email'];
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    // ID Card upload
    $id_card = "uploads/".time()."_".$_FILES['id_card']['name'];
    move_uploaded_file($_FILES['id_card']['tmp_name'], $id_card);

    // Profile pic upload
    $profile_pic = "uploads/".time()."_".$_FILES['profile_pic']['name'];
    move_uploaded_file($_FILES['profile_pic']['tmp_name'], $profile_pic);
    
    $stmt = $conn->prepare("INSERT INTO users(name,mobile,email,dob,gender,username,password,id_card,profile_pic) VALUES(?,?,?,?,?,?,?,?,?)");
    $stmt->bind_param("sssssssss",$name,$mobile,$email,$dob,$gender,$username,$password,$id_card,$profile_pic);
    $stmt->execute();
    echo "<script>alert('Registered Successfully');window.location='login.php';</script>";
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Register</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
<div class="card p-4 shadow-lg">
<h3 class="text-center mb-4">Registration Form</h3>
<form method="post" enctype="multipart/form-data">
<div class="mb-3">
  <label class="form-label">Full Name</label>
  <input class="form-control" name="name" placeholder="Enter your full name" required>
</div>
<div class="mb-3">
  <label class="form-label">Mobile Number</label>
  <input class="form-control" name="mobile" type="tel" pattern="[0-9]{10}" maxlength="10" placeholder="Enter 10-digit mobile number" required>
</div>
<div class="mb-3">
  <label class="form-label">Email</label>
  <input class="form-control" name="email" type="email" placeholder="Enter email" required>
</div>
<div class="mb-3">
  <label class="form-label">Date of Birth</label>
  <input class="form-control" name="dob" type="date" required>
</div>
<div class="mb-3">
  <label class="form-label">Gender</label>
  <select class="form-control" name="gender" required>
    <option value="">Select Gender</option>
    <option value="Male">Male</option>
    <option value="Female">Female</option>
    <option value="Other">Other</option>
  </select>
</div>
<div class="mb-3">
  <label class="form-label">Username</label>
  <input class="form-control" name="username" placeholder="Choose a username" required>
</div>
<div class="mb-3">
  <label class="form-label">Password</label>
  <div class="input-group">
    <input class="form-control" name="password" id="password" type="password" placeholder="Enter password" required>
    <button type="button" class="btn btn-outline-secondary" onclick="togglePassword()">Show</button>
  </div>
</div>
<div class="mb-3">
  <label class="form-label">Upload ID Card</label>
  <input class="form-control" name="id_card" type="file" accept="image/*" required>
</div>
<div class="mb-3">
  <label class="form-label">Upload Profile Picture</label>
  <input class="form-control" name="profile_pic" type="file" accept="image/*" required>
</div>
<button class="btn btn-primary w-100" name="register">Register</button>
</form>
<p class="mt-3 text-center"><a href="login.php">Already Registered? Login</a></p>
</div>
</div>

<script>
function togglePassword(){
  var x = document.getElementById("password");
  if(x.type === "password"){ 
    x.type = "text"; 
  } else { 
    x.type = "password"; 
  }
}
</script>
</body>
</html>


