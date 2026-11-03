<?php
include('../config/db.php');

$users = mysqli_query($conn, "SELECT id, name, email, role FROM users ORDER BY id DESC");
?>
<?php include('../includes/adminheader.php'); ?>

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>USERS</h2>
        <a href="adduser.php" class="btn btn-success">Add User</a>
    </div>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($userdata = mysqli_fetch_assoc($users)): ?>
            <tr>
                <td><?php echo htmlspecialchars($userdata['name']); ?></td>
                <td><?php echo htmlspecialchars($userdata['email']); ?></td>
                <td><?php echo htmlspecialchars($userdata['role']); ?></td>
                <td>
                    <a href="edituser.php?id=<?php echo $userdata['id']; ?>" class="btn btn-warning">EDIT</a>
                    <a href="deleteuser.php?id=<?php echo $userdata['id']; ?>" class="btn btn-danger"
                       onclick="return confirm('Are you sure?')">DELETE</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>