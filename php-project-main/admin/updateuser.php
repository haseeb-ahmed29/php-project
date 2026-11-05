
<?php
include('../config/db.php');

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    header("Location: users.php");
    exit;
}

// Get form data
$id = (int)($_POST['id'] ?? 0);
$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';
$role = $_POST['role'] ?? '';

// Validation
if ($id <= 0 || empty($name) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    die("Invalid input data");
}

if (!in_array($role, ['user', 'admin'])) {
    die("Invalid role");
}

// Get existing user
$stmt = mysqli_prepare($conn, "SELECT image FROM users WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);
$userdata = mysqli_fetch_assoc($result);

if (!$userdata) {
    die("User not found");
}

// Keep existing image
$image = $userdata['image'];

// Image upload
if (isset($_FILES['image']) && $_FILES['image']['error'] !== UPLOAD_ERR_NO_FILE) {

    if ($_FILES['image']['error'] !== UPLOAD_ERR_OK) {
        die("Image upload failed");
    }

    if ($_FILES['image']['size'] > 2 * 1024 * 1024) {
        die("Image size must be less than 2MB");
    }

    $allowedTypes = [
        'image/jpeg' => 'jpg',
        'image/png' => 'png',
        'image/webp' => 'webp'
    ];

    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime = finfo_file($finfo, $_FILES['image']['tmp_name']);
    finfo_close($finfo);

    if (!isset($allowedTypes[$mime])) {
        die("Only JPG, PNG and WEBP images are allowed");
    }

    $extension = $allowedTypes[$mime];
    $newImage = uniqid('user_', true) . '.' . $extension;

    // Upload folder
    $uploadDir = '../uploads/';

    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    if (!move_uploaded_file(
        $_FILES['image']['tmp_name'],
        $uploadDir . $newImage
    )) {
        die("Unable to upload image");
    }

    $image = $newImage;
}

// Update password only if entered
if (!empty($password)) {
    $password = password_hash($password, PASSWORD_DEFAULT);

    $stmt = mysqli_prepare($conn,
        "UPDATE users SET name=?, email=?, password=?, role=?, image=? WHERE id=?"
    );

    mysqli_stmt_bind_param(
        $stmt, "sssssi",
        $name, $email, $password, $role, $image, $id
    );

} else {

    $stmt = mysqli_prepare($conn,
        "UPDATE users SET name=?, email=?, role=?, image=? WHERE id=?"
    );

    mysqli_stmt_bind_param(
        $stmt, "ssssi",
        $name, $email, $role, $image, $id
    );
}

// Execute query
if (mysqli_stmt_execute($stmt)) {
    header("Location: users.php");
    exit;
} else {
    echo "Update failed: " . mysqli_error($conn);
}

?>
