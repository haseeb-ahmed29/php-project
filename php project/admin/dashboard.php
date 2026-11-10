<?php
include('../config/db.php');
//fetch users
$usercount= mysqli_num_rows(mysqli_query($conn,"select * from users"));
$productcount= mysqli_num_rows(mysqli_query($conn,"select * from products"));
$ordercount= mysqli_num_rows(mysqli_query($conn,"select * from orders"));
$feedbackcount= mysqli_num_rows(mysqli_query($conn,"select * from feedback"));
?>
<?php include('../includes/adminheader.php') ?>
<div class="container mt-5">
    <h3>ADMIN DASHBOARD</h3>
  <a href="adminlogout.php" class="btn btn-primary mb-5">logout</a>
<div class="row">
    <div class="col-md-3">
        <div class="card" style="width: 18rem;">
  <div class="card-body">
    <h5 class="card-title">USERS</h5>
    <p class="card-text"> count: <?php echo $usercount; ?></p>
    <a href="users.php" class="btn btn-success">Manage users</a>
  </div>
</div>
    </div>
    <div class="col-md-3">
        <div class="card" style="width: 18rem;">
  <div class="card-body">
    <h5 class="card-title">PRODUCTS</h5>
    <p class="card-text"><?php echo $productcount; ?></p>
    <a href="#" class="btn btn-success">Manage products</a>
  </div>
</div>
    </div>
    <div class="col-md-3">
        <div class="card" style="width: 18rem;">
  <div class="card-body">
    <h5 class="card-title">ORDERS</h5>
    <p class="card-text"> <?php echo $ordercount; ?></p>
    <a href="#" class="btn btn-success">Manage orders</a>
  </div>
</div>
</div>
    <div class="col-md-3">
        <div class="card" style="width: 18rem;">
  <div class="card-body">
    <h5 class="card-title">Feedbacks</h5>
    <p class="card-text"><?php echo $feedbackcount; ?> </p>
    <a href="#" class="btn btn-success">Manage feedbacks</a>
  </div>
</div>
    </div>
  
</div>
</div>