<?php
include('../config/db.php');

if (!isset($_GET['id'])) {
    header("Location: users.php");
    exit;
}

$id = (int) $_GET['id'];
$error = "";

// user ka data nikalo
$stmt = mysqli_prepare($conn, "SELECT id, name, email, role FROM users WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$user = mysqli_fetch_assoc($result);

if (!$user) {
    header("Location: users.php");
    exit;
}

// form submit hua to update karo
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name  = trim($_POST['username']);
    $email = trim($_POST['email']);
    $pass  = $_POST['pass'];
    $role  = $_POST['role'];

    if (!in_array($role, ['user', 'admin'])) {
        $role = 'user';
    }

    // ye email kisi aur user ke paas to nahi?
    $check = mysqli_prepare($conn, "SELECT id FROM users WHERE email = ? AND id != ?");
    mysqli_stmt_bind_param($check, "si", $email, $id);
    mysqli_stmt_execute($check);
    mysqli_stmt_store_result($check);

    if (mysqli_stmt_num_rows($check) > 0) {
        $error = "This Email Already Exist";
    } else {
        if ($pass !== "") {
           
            $hashed = password_hash($pass, PASSWORD_DEFAULT);
            $update = mysqli_prepare($conn, "UPDATE users SET name = ?, email = ?, password = ?, role = ? WHERE id = ?");
            mysqli_stmt_bind_param($update, "ssssi", $name, $email, $hashed, $role, $id);
        } else {
            
            $update = mysqli_prepare($conn, "UPDATE users SET name = ?, email = ?, role = ? WHERE id = ?");
            mysqli_stmt_bind_param($update, "sssi", $name, $email, $role, $id);
        }

        mysqli_stmt_execute($update);
        header("Location: users.php");
        exit;
    }

    // error aaye to form me wahi values dikhao jo user ne likhi thi
    $user['name']  = $name;
    $user['email'] = $email;
    $user['role']  = $role;
}
?>
<?php include('../includes/adminheader.php'); ?>

<div class="container mt-5">
    <h2>EDIT USER</h2>

    <?php if ($error): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>

    <form method="POST" action="">
        <input type="text" name="username" required placeholder="enter your name"
               value="<?php echo htmlspecialchars($user['name']); ?>" class="form-control mb-2">

        <input type="email" name="email" required placeholder="enter your email"
               value="<?php echo htmlspecialchars($user['email']); ?>" class="form-control mb-2">

        <input type="password" name="pass" placeholder="new password"
               class="form-control mb-2">

        <select name="role" required class="form-control mb-2">
            <option value="user" <?php echo $user['role'] == 'user' ? 'selected' : ''; ?>>user</option>
            <option value="admin" <?php echo $user['role'] == 'admin' ? 'selected' : ''; ?>>admin</option>
        </select>

        <button type="submit" class="btn btn-success">Update user</button>
        <a href="users.php" class="btn btn-secondary">Back</a>
    </form>
</div>