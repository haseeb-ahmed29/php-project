<?php
include ('../config/db.php');
//delete user

$id= $_GET['id']; //1
mysqli_query($conn, "DELETE FROM users where id='$id' ");

 header("Location: users.php");
   

?>
