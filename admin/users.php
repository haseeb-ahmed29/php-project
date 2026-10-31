
<?php
include('../config/db.php');

// get users
$users = mysqli_query($conn, "select * from users");
?>

<?php include('../includes/adminheader.php'); ?>

<div class="container mt-5">
    <h2>Manage users</h2>

    <a href="adduser.php" class="btn btn-success mb-2 mt-2">ADD USER</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Image</th>
                <th>Actions</th>
            </tr>
        </thead>

        <tbody>
            <?php while($userdata = mysqli_fetch_assoc($users)): ?>
            <tr>
                <td><?php echo $userdata['name'] ?></td>
                <td><?php echo $userdata['email'] ?></td>
                <td><?php echo $userdata['role'] ?></td>
                <td>
                    <?php
                    $imagename = $userdata['image'];
                    echo "<img src='../upload/$imagename' height='50' width='50'>";
                    ?>
                </td>
                <td>
                    <a href="edituser.php?id=<?php echo $userdata['id'] ?>" class="btn btn-warning">EDIT</a>

                    <form method="POST" action="deleteuser.php" style="display: inline-block;">
                        <input type="hidden" name="user_id" value="<?php echo $userdata['id'] ?>">

                        <button type="submit" name="delete_user" class="btn btn-danger" onclick="return confirm('Are you sure?')">delete</button>
                    </form>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>  
    </table>
    
</div>
