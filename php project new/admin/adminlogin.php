<?php
session_start();
include ('../config/db.php');
$email=$_POST['email']; //john@
$password=$_POST['password']; //123
$error='';
$result= mysqli_query($conn,"SELECT * FROM users where email='$email'");

if($result && mysqli_num_rows($result)==1){
$admindata= mysqli_fetch_assoc($result);
// print_r($admindata);
$dbpass=$admindata['password'];
$verifypass=password_verify($password,$dbpass);
// echo $verifypass;
$dbpass = $admindata['password'];

// echo "Entered Password: ";
// var_dump($password);

// echo "<br>Database Password: ";
// var_dump($dbpass);

// $verifypass = password_verify($password, $dbpass);

// echo "<br>Password Verification: ";
// var_dump($verifypass);
if( $verifypass && $admindata['role']==='admin'){

$_SESSION['username']=$admindata['name'];
$_SESSION['email']=$admindata['email'];
$_SESSION['role']='admin';
header("Location: dashboard.php");
exit;
}
else{
    $error= 'invalid pass';
}
}
else{
   $error='admin not found'; 
}
?>
<?php include('../includes/adminheader.php'); ?>
<div class="container mt-5">
<h2>admin login</h2>
<form action="" method="POST">
<div class="mb-3">
    <label for="">Email</label>
<input type="Email" class="form-control" name="email" required>
</div>            
<div class="mb-3">
    <label for="">password</label>   
 <input type="password" class="form-control" name="password"   required>
</div>
<?php echo "<p class='text-danger'>$error</p>"?>
<button type="submit" class="btn btn-primary">Login</button>
</form>
</div>
<?php include('../includes/footer.php'); ?>