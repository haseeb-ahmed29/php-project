<?php
session_start();
include('../config/db.php');

if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header("Location: ../admin/adminlogin.php");
    exit;
}

if (isset($_POST['submit'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = mysqli_real_escape_string($conn, $_POST['role']);

    //image uploading
    $filename = '';
    if (!empty($_FILES['image']['name'])) {
        $img = $_FILES['image'];
        $filename = basename($img['name']);
        $tempname = $img['tmp_name'];

        // path to store image
        $imagepath = __DIR__ . '/../assets/img/' . $filename;
        move_uploaded_file($tempname, $imagepath);
    }

    $query = "INSERT INTO users (name, email, password, role, image)
              VALUES ('$name', '$email', '$password', '$role', '$filename')";
    mysqli_query($conn, $query);

    header("Location: users.php");
    exit;
}
?>
<?php include('../includes/adminheader.php'); ?>
<div class="container mt-5">
    <h2>Add User</h2>
    <form method="POST" enctype="multipart/form-data" class="p-3 border bg-light">
        <input type="text" name="name" class="form-control mb-2" placeholder="Name" required>
        <input type="email" name="email" class="form-control mb-2" placeholder="Email" required>
        <input type="password" name="password" class="form-control mb-2" placeholder="Password" required>
        <select name="role" class="form-control mb-2" required>
            <option value="user">User</option>
            <option value="admin">Admin</option>
        </select>
        <input type="file" name="image" class="form-control mb-2">
        <br>
        <button type="submit" name="submit" class="btn btn-success">Add User</button>
    </form>
</div>
<?php include('../includes/footer.php'); ?>
