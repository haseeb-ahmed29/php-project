<?php
include('../config/db.php');

if($_SERVER['REQUEST_METHOD'] == 'POST')
{
    $id = $_POST['id'];//1
    $name = $_POST['name'];
    $email = $_POST['email'];
    $role = $_POST['role'];
    $password = $_POST['password'];
     $hashpass= password_hash($pass,PASSWORD_DEFAULT);
    // Get current user
    $update_query ="UPDATE users set name='$name',email='$email',role='$role',password='$hashpass' where id='$id'";

    }

    mysqli_query($conn, $update_query);
    header("Location: users.php");
    exit;

?>