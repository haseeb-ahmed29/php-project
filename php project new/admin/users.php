<?php
session_start();
include('../config/db.php');

if (!isset($_SESSION['username']) || $_SESSION['role'] != "admin") {
    header("Location: ../admin/adminlogin.php");
    exit;
}

//get users
$users = mysqli_query($conn, "SELECT * FROM users");
?>
<?php include('../includes/adminheader.php'); ?>
<div class="container mt-5">
    <h2>Manage users</h2>
    <a href="add_user.php" class="btn btn-success mb-2 mt-2">ADD USER</a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Image</th>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($user = mysqli_fetch_assoc($users)): ?>
            <tr>
                <td>
                    <?php if (!empty($user['image'])): ?>
                        <img src="../assets/img/<?php echo htmlspecialchars($user['image']); ?>"
                             alt="user image" height="40px" width="40px">
                    <?php else: ?>
                        no image
                    <?php endif; ?>
                </td>
                <td><?php echo htmlspecialchars($user['name']); ?></td>
                <td><?php echo htmlspecialchars($user['email']); ?></td>
                <td><?php echo htmlspecialchars($user['role']); ?></td>
                <td>
                    <a href="edit_user.php?id=<?php echo $user['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                    <a href="delete_user.php?id=<?php echo $user['id']; ?>" class="btn btn-danger btn-sm">Delete</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
<?php include('../includes/footer.php'); ?>
