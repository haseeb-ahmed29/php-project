<?php

include ('../config/db.php');
if($_SERVER['REQUEST_METHOD']=='POST'){
    $name= $_POST['username']; //john
    $email= $_POST['email']; //john
    $pass= $_POST['pass']; //123
    //hashpassword
    $hashpass= password_hash($pass,PASSWORD_DEFAULT);
     $role= $_POST['role'] ;//admin
    $insertquery= "INSERT INTO users(name,email,password,role) values ('$name','$email','$hashpass','$role')";
    mysqli_query($conn,$insertquery);
    header("Location: users.php");
}
?>
<?php include('../includes/adminheader.php'); ?>
<div class="container mt-5">

<h2>ADD USER</h2>
<form method="POST" class="" >
<input type="text" name="username" required placeholder="enter your name" class="form-control mb-2">
<input type="email" name="email" required placeholder="enter your email" class="form-control mb-2">
<input type="password" name="pass" required placeholder="enter your pass" class="form-control mb-2">
<select name="role" id="" required class="form-control mb-2">

<option value="user">user</option>
<option value="admin">admin</option>
</select>
<!-- <input type="file" name="img" class="form-control mb-2"> -->
<button type="submit" class="btn btn-success">Add user</button>
</form>
</div>
<?php include('../includes/footer.php'); ?>
