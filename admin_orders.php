<?php
include 'config.php';
session_start();

// Check admin login
$admin_id = $_SESSION['admin_id'] ?? null;

if(!isset($admin_id)){
   header('location:login.php');
   exit();
}

// Update payment status
if(isset($_POST['update_order'])){
   $order_id = intval($_POST['order_id']);
   $update_payment = mysqli_real_escape_string($conn, $_POST['update_payment']);

   mysqli_query($conn, "UPDATE orders SET payment_status='$update_payment' WHERE id='$order_id'");
}

// Delete order
if(isset($_GET['delete'])){
   $delete_id = intval($_GET['delete']);
   mysqli_query($conn, "DELETE FROM orders WHERE id='$delete_id'");
   header('location:admin_orders.php');
   exit();
}
?>

<!DOCTYPE html>
<html>
<head>
   <title>Admin Orders</title>
   <link rel="stylesheet" href="css/admin_style.css">

   <style>
      .box{
         background:#fff;
         padding:20px;
         margin:15px;
         border-radius:8px;
         box-shadow:0 0 10px rgba(0,0,0,0.1);
      }

      .receipt-btn{
         display:inline-block;
         padding:10px;
         background:green;
         color:white;
         text-decoration:none;
         margin-top:10px;
      }
   </style>
</head>

<body>

<h1>All Orders</h1>

<?php
$result = mysqli_query($conn, "SELECT * FROM orders ORDER BY id DESC");

while($row = mysqli_fetch_assoc($result)){
?>

<div class="box">

<p>Order ID: <?php echo $row['id']; ?></p>
<p>Name: <?php echo $row['name']; ?></p>
<p>Phone: <?php echo $row['number']; ?></p>
<p>Email: <?php echo $row['email']; ?></p>
<p>Address: <?php echo $row['address']; ?></p>
<p>Products: <?php echo $row['total_products']; ?></p>
<p>Total Price: ₹<?php echo $row['total_price']; ?></p>
<p>Payment: <?php echo $row['method']; ?></p>
<p>Status: <?php echo $row['payment_status']; ?></p>

<!-- Update form -->
<form method="post">
   <input type="hidden" name="order_id" value="<?php echo $row['id']; ?>">

   <select name="update_payment">
      <option value="">Change Status</option>
      <option value="pending">Pending</option>
      <option value="completed">Completed</option>
   </select>

   <button type="submit" name="update_order">Update</button>
</form>

<!-- Delete -->
<a href="admin_orders.php?delete=<?php echo $row['id']; ?>" onclick="return confirm('Delete order?')">Delete</a>

<br>

<!-- Receipt Button -->
<a href="receipt.php?id=<?php echo $row['id']; ?>" target="_blank" class="receipt-btn">
   View Receipt
</a>

</div>

<?php } ?>

</body>
</html>