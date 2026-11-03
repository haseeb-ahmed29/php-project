<?php
include('../config/db.php');

$error = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name  = trim($_POST['username']);
    $email = trim($_POST['email']);
    $pass  = $_POST['pass'];
    $role  = $_POST['role'];

    // role sirf user ya admin ho sakta hai
    if (!in_array($role, ['user', 'admin'])) {
        $role = 'user';
    }

    // email pehle se to nahi hai?
    $check = mysqli_prepare($conn, "SELECT id FROM users WHERE email = ?");
    mysqli_stmt_bind_param($check, "s", $email);
    mysqli_stmt_execute($check);
    mysqli_stmt_store_result($check);

    if (mysqli_stmt_num_rows($check) > 0) {
        $error = "This Email Already Exist";
    } else {
        $hashed = password_hash($pass, PASSWORD_DEFAULT);

        $stmt = mysqli_prepare($conn, "INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "ssss", $name, $email, $hashed, $role);
        mysqli_stmt_execute($stmt);

        header("Location: users.php");
        exit;
    }
}
?>
<?php include('../includes/adminheader.php'); ?>

<div class="container mt-5">
    <h2>ADD USER</h2>

    <?php if ($error): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>

    <form method="POST" action="">
        <input type="text" name="username" required placeholder="enter your name" class="form-control mb-2">
        <input type="email" name="email" required placeholder="enter your email" class="form-control mb-2">
        <input type="password" name="pass" required placeholder="enter your pass" class="form-control mb-2">

        <select name="role" required class="form-control mb-2">
            <option value="user">user</option>
            <option value="admin">admin</option>
        </select>

        <button type="submit" class="btn btn-success">Add user</button>
        <a href="users.php" class="btn btn-secondary">Back</a>
    </form>
</div>