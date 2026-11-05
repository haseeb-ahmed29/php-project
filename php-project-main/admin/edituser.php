<?php
include('../config/db.php');

if(!isset($_GET['id'])){
    header("Location:users.php");
    exit;
}

$id = $_GET['id']; //1
// echo $id;

$query = mysqli_query($conn, "select * from users where id='$id'");
$userdata=mysqli_fetch_assoc($query);
print_r($userdata);

if(!$userdata){
    echo "user not found";
    exit;
}

?>
<?php include('../includes/adminheader.php'); ?>

<div class="container mt-5">
    <h2>EDIT USER</h2>
    <form action="updateuser.php" method="POST">
        <input type="hidden" name="id" value="<?php echo $userdata['id'] ?>" class="form-control mb-2">
        <input type="text" name="name" value="<?php echo $userdata['name'] ?>" class="form-control mb-2">
        <input type="email" name="email" value="<?php echo $userdata['email'] ?>" class="form-control mb-2">
        <input type="password" name="password" value="<?php echo $userdata['password'] ?>" class="form-control mb-2">
        <select name="role" class="form-control mb-2">
            <option value="user" <?php if($userdata['role']=='user') echo 'selected'; ?>>user</option>
            <option value="admin" <?php if($userdata['role']=='admin') echo 'selected'; ?>>Admin</option>
        </select>
        <input type="file" name="image" class="form-control mb-2">
        <button type="submit" class="btn btn-success">
            UPDATE USER
        </button>
    </form>
</div>