
<?php
include('../config/db.php');

// Get user ID
$id = (int)($_GET['id'] ?? 0);

// Fetch user data
$stmt = mysqli_prepare($conn, "SELECT * FROM users WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$user = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

?>

<?php include('../includes/adminheader.php'); ?>

<div class="container mt-5" style="max-width: 600px;">

    <h2 class="mb-4">Edit User</h2>

    <?php if ($user) { ?>

        <div class="card shadow-sm">
            <div class="card-header">
                Edit User Details
            </div>

            <div class="card-body">

                <form action="updateuser.php"
                      method="POST"
                      enctype="multipart/form-data">

                    <input type="hidden"
                           name="id"
                           value="<?php echo (int)$user['id']; ?>">

                    <!-- Name -->
                    <div class="mb-3">
                        <label for="name" class="form-label">
                            Name
                        </label>

                        <input type="text"
                               class="form-control"
                               id="name"
                               name="name"
                               maxlength="100"
                               value="<?php echo htmlspecialchars($user['name'] ?? ''); ?>"
                               required>
                    </div>

                    <!-- Email -->
                    <div class="mb-3">
                        <label for="email" class="form-label">
                            Email
                        </label>

                        <input type="email"
                               class="form-control"
                               id="email"
                               name="email"
                               value="<?php echo htmlspecialchars($user['email'] ?? ''); ?>"
                               required>
                    </div>

                    <!-- Role -->
                    <div class="mb-3">
                        <label for="role" class="form-label">
                            Role
                        </label>

                        <select class="form-select"
                                id="role"
                                name="role"
                                required>

                            <option value="admin"
                                <?php echo (($user['role'] ?? '') === 'admin') ? 'selected' : ''; ?>>
                                Admin
                            </option>

                            <option value="user"
                                <?php echo (($user['role'] ?? '') === 'user') ? 'selected' : ''; ?>>
                                User
                            </option>

                        </select>
                    </div>

                    <!-- Current Image -->
                    <div class="mb-3">

                        <label class="form-label">
                            Current Image
                        </label>

                        <br>

                        <?php if (!empty($user['image'])) { ?>

                            <img
                                src="../upload/<?php echo rawurlencode(basename($user['image'])); ?>"
                                alt="User Image"
                                width="90"
                                height="90"
                                class="rounded mb-2"
                                style="object-fit: cover;">

                        <?php } else { ?>

                            <p>No image uploaded.</p>

                        <?php } ?>

                    </div>

                    <!-- Upload New Image -->
                    <div class="mb-3">

                        <label for="image" class="form-label">
                            Change Image (Optional)
                        </label>

                        <input type="file"
                               class="form-control"
                               id="image"
                               name="image"
                               accept="image/jpeg,image/png,image/webp">

                    </div>

                    <!-- Buttons -->
                    <button type="submit" class="btn btn-success">
                        Save Changes
                    </button>

                    <a href="users.php" class="btn btn-secondary">
                        Cancel
                    </a>

                </form>

            </div>
        </div>

    <?php } else { ?>

        <div class="alert alert-danger">
            User not found.

            <a href="users.php" class="alert-link">
                Back to Users
            </a>
        </div>

    <?php } ?>

</div>
